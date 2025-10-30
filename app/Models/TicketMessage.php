<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketMessage extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'is_internal_note',
    ];

    protected $casts = [
        'is_internal_note' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the ticket that owns the message.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who created the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this message is from an admin.
     */
    public function isFromAdmin(): bool
    {
        return $this->user && ($this->user->isAdmin() || $this->user->isSuperAdmin());
    }

    /**
     * Scope a query to only include public messages (not internal notes).
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal_note', false);
    }
}
