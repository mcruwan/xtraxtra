<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
     * Get the logo URL attribute.
     * Returns null if logo doesn't exist or file can't be accessed.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }
        
        // Check if file exists in storage
        if (!Storage::disk('public')->exists($this->logo)) {
            Log::warning("University logo file not found in storage", [
                'university_id' => $this->id,
                'logo_path' => $this->logo,
                'full_path' => Storage::disk('public')->path($this->logo)
            ]);
            return null;
        }
        
        return Storage::disk('public')->url($this->logo);
    }
    
    /**
     * Check if the university has a valid logo.
     */
    public function hasLogo(): bool
    {
        return $this->logo && Storage::disk('public')->exists($this->logo);
    }

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
