<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class NewsSubmission extends Model
{
    protected $fillable = [
        'university_id',
        'user_id',
        'approved_by',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'rejection_reason',
        'submitted_at',
        'approved_at',
        'published_at',
        'wordpress_post_id',
        'is_revision',
        'previous_status',
        'last_edited_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'last_edited_at' => 'datetime',
        'is_revision' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($newsSubmission) {
            if (empty($newsSubmission->slug)) {
                $newsSubmission->slug = Str::slug($newsSubmission->title);
            }
            // Set published_at when status is published
            if ($newsSubmission->status === 'published' && !$newsSubmission->published_at) {
                $newsSubmission->published_at = now();
            }
        });

        // Automatically set published_at when status changes to published
        static::updating(function ($newsSubmission) {
            if ($newsSubmission->isDirty('status')) {
                if ($newsSubmission->status === 'published' && !$newsSubmission->published_at) {
                    $newsSubmission->published_at = now();
                }
                // Clear published_at if status changes away from published
                if ($newsSubmission->status !== 'published' && $newsSubmission->published_at) {
                    $newsSubmission->published_at = null;
                }
            }
        });
    }

    /**
     * Get the university that owns the news submission
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the user who created the news submission
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved the news submission
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the categories for the news submission
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'news_submission_category');
    }

    /**
     * Get the tags for the news submission
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_submission_tag');
    }

    /**
     * Scope: Get drafts only
     */
    public function scopeDrafts($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Get pending submissions only
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get approved submissions only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Get rejected submissions only
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Get published submissions only
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Check if submission is a draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if submission is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if submission is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if submission is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if submission is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
