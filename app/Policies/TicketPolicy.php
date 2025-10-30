<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
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
    public function view(User $user, Ticket $ticket): bool
    {
        // Admins can view all tickets
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        // University users can only view their own university's tickets
        return $user->isUniversityUser() && $user->university_id === $ticket->university_id;
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
    public function update(User $user, Ticket $ticket): bool
    {
        // Admins can update any ticket
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        // University users can reply to their own university's tickets
        return $user->isUniversityUser() && $user->university_id === $ticket->university_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        // Only super admins can delete tickets
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can manage ticket (change status, priority, assign).
     */
    public function manage(User $user, Ticket $ticket): bool
    {
        // Only admins can manage tickets
        return $user->isAdmin() || $user->isSuperAdmin();
    }
}
