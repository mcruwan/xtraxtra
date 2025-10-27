<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'wordpress_tag_id',
    ];

    /**
     * Get the news submissions that have this tag
     */
    public function newsSubmissions(): BelongsToMany
    {
        return $this->belongsToMany(NewsSubmission::class, 'news_submission_tag');
    }
}
