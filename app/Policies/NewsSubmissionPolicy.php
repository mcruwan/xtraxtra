<?php

namespace App\Policies;

use App\Models\NewsSubmission;
use App\Models\User;

class NewsSubmissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isUniversityUser() || $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NewsSubmission $newsSubmission): bool
    {
        // Admins can view all
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        // University users can only view their own university's submissions
        return $user->isUniversityUser() && $user->university_id === $newsSubmission->university_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isUniversityUser() && $user->isActive();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NewsSubmission $newsSubmission): bool
    {
        // Admins cannot edit university submissions
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return false;
        }

        // University users can only edit their own university's submissions
        // and only if status is draft or pending
        return $user->isUniversityUser() 
            && $user->university_id === $newsSubmission->university_id
            && in_array($newsSubmission->status, ['draft', 'pending']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NewsSubmission $newsSubmission): bool
    {
        // Admins cannot delete university submissions
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return false;
        }

        // University users can only delete their own university's submissions
        // and only if status is draft, pending, or rejected
        return $user->isUniversityUser() 
            && $user->university_id === $newsSubmission->university_id
            && in_array($newsSubmission->status, ['draft', 'pending', 'rejected']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NewsSubmission $newsSubmission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NewsSubmission $newsSubmission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, NewsSubmission $newsSubmission): bool
    {
        return ($user->isAdmin() || $user->isSuperAdmin()) 
            && $newsSubmission->status === 'pending';
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, NewsSubmission $newsSubmission): bool
    {
        return ($user->isAdmin() || $user->isSuperAdmin()) 
            && $newsSubmission->status === 'pending';
    }
}
