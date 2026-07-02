<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ai\ChatRequest;
use App\Services\Ai\AiChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct(private readonly AiChatService $aiChatService) {}

    public function conversations(Request $request): JsonResponse
    {
        $list = $this->aiChatService->getConversations($request->user());

        return response()->json(['conversations' => $list]);
    }

    public function history(Request $request, string $conversationId): JsonResponse
    {
        $messages = $this->aiChatService->getConversationMessages($conversationId, $request->user());

        return response()->json(['messages' => $messages]);
    }

    public function send(ChatRequest $request)
    {
        $validated = $request->validated();
        $conversationId = $validated['conversation_id'] ?? (string) Str::uuid();

        if ($request->input('stream', true)) {
            $headers = [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
            ];

            return response()->stream(function () use ($request, $validated, $conversationId) {
                echo "data: {\"type\":\"start\"}\n\n";

                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();

                $this->aiChatService->processMessageStream(
                    $request->user(),
                    $validated['message'],
                    $conversationId,
                    function ($chunk) {
                        echo 'data: '.json_encode(['content' => $chunk])."\n\n";
                        if (ob_get_level() > 0) {
                            ob_flush();
                        }
                        flush();
                    }
                );

                echo "data: {\"type\":\"done\"}\n\n";
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            }, 200, $headers);
        }

        $response = $this->aiChatService->processMessage(
            $request->user(),
            $validated['message'],
            $conversationId
        );

        return response()->json(['response' => $response, 'conversation_id' => $conversationId]);
    }
}
