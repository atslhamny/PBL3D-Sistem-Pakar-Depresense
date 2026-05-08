<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAnswer extends Model
{
    protected $guarded = ['id'];
    
    const UPDATED_AT = null;
    const CREATED_AT = 'answered_at';

    protected function casts(): array
    {
        return [
            'answer_value' => 'integer',
            'answered_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ScreeningSession::class, 'session_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(BdiQuestion::class, 'question_id');
    }
}
