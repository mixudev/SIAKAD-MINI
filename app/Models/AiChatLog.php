<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiChatLog extends Model
{
    protected $table = 'ai_chat_logs';

    protected $fillable = [
        'user_id',
        'conversation_id',
        'role',
        'message',
        'response',
        'title',
    ];

    protected function casts(): array
    {
        return [
            'conversation_id' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByConversation(Builder $query, string $conversationId): Builder
    {
        return $query->where('conversation_id', $conversationId);
    }
}
