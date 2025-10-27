<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'wordpress_category_id',
    ];

    /**
     * Get the news submissions that belong to this category
     */
    public function newsSubmissions(): BelongsToMany
    {
        return $this->belongsToMany(NewsSubmission::class, 'news_submission_category');
    }
}
