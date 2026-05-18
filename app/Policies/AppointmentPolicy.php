<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    // Client — makikita lang ang sariling appointments
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->client_id
            || $user->id === $appointment->admin_id;
    }

    // Client lang ang pwedeng mag-book
    public function create(User $user): bool
    {
        return $user->isClient();
    }

    // Client pwedeng mag-cancel ng sariling appointment
    public function cancel(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->client_id
            && $appointment->status === 'pending';
    }

    // Admin lang ang pwedeng mag-approve o mag-complete
    public function approve(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->admin_id
            && $appointment->status === 'pending';
    }

    public function complete(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->admin_id
            && $appointment->status === 'approved';
    }
}