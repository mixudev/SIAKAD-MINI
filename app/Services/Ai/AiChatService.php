<?php

namespace App\Services\Ai;

use App\Models\AiChatLog;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiChatService
{
    public function __construct(
        private readonly AiService $aiService,
        private readonly AiPromptBuilder $promptBuilder,
    ) {}

    public function processMessage(User $user, string $message, ?string $conversationId = null): string
    {
        $role = $user->getRoleNames()->first() ?? 'unknown';
        $mahasiswa = $role === 'mahasiswa' ? $user->mahasiswa : null;
        $convId = $conversationId ?? (string) Str::uuid();

        $history = $conversationId ? $this->getConversationHistory($conversationId, $user) : [];
        $messages = $this->promptBuilder->buildChatMessage($role, $message, $mahasiswa, $history);

        $response = $this->aiService->chat($messages);

        $this->logChat($user, $convId, $role, $message, $response);

        return $response;
    }

    public function processMessageStream(User $user, string $message, string $conversationId, callable $callback): void
    {
        $role = $user->getRoleNames()->first() ?? 'unknown';
        $mahasiswa = $role === 'mahasiswa' ? $user->mahasiswa : null;

        $history = $this->getConversationHistory($conversationId, $user);
        $messages = $this->promptBuilder->buildChatMessage($role, $message, $mahasiswa, $history);

        $fullResponse = '';

        $this->aiService->chatStream($messages, function ($chunk) use (&$fullResponse, $callback) {
            $fullResponse .= $chunk;
            $callback($chunk);
        });

        $this->logChat($user, $conversationId, $role, $message, $fullResponse);
    }

    protected function getConversationHistory(string $conversationId, User $user, int $limit = 5): array
    {
        return AiChatLog::byConversation($conversationId)
            ->where('user_id', $user->id)
            ->orderBy('created_at')
            ->take($limit)
            ->get()
            ->map(fn ($log) => [
                ['role' => 'user', 'content' => $log->message],
                ['role' => 'assistant', 'content' => $log->response],
            ])
            ->flatten(1)
            ->toArray();
    }

    public function getConversations(User $user): Collection
    {
        return AiChatLog::where('user_id', $user->id)
            ->whereNotNull('conversation_id')
            ->where('role', 'user')
            ->selectRaw('conversation_id, MIN(message) as title, MIN(created_at) as created_at')
            ->groupBy('conversation_id')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn ($log) => [
                'id' => $log->conversation_id,
                'title' => Str::limit($log->title, 50),
                'created_at' => $log->created_at,
            ]);
    }

    public function getConversationMessages(string $conversationId, User $user): Collection
    {
        return AiChatLog::byConversation($conversationId)
            ->where('user_id', $user->id)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($log) => [
                'id' => $log->id,
                'role' => $log->role,
                'message' => $log->message,
                'response' => $log->response,
            ]);
    }

    protected function logChat(User $user, string $conversationId, string $role, string $message, string $response): void
    {
        try {
            $isFirstUserMessage = AiChatLog::where('conversation_id', $conversationId)
                ->where('role', 'user')
                ->doesntExist();

            AiChatLog::create([
                'user_id' => $user->id,
                'conversation_id' => $conversationId,
                'role' => $role,
                'message' => $message,
                'response' => $response,
                'title' => $isFirstUserMessage ? Str::limit($message, 100) : null,
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to save AI chat log', ['error' => $e->getMessage()]);
        }
    }
}
