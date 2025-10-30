<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'contact_email',
        'logo',
        'wordpress_user_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the users for the university.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the news submissions for the university.
     */
    public function newsSubmissions(): HasMany
    {
        return $this->hasMany(NewsSubmission::class);
    }

    /**
     * Get the FAQs for the university.
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    /**
     * Get the tickets for the university.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Scope a query to only include active universities.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include pending universities.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
