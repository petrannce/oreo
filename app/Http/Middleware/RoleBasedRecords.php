<?php

namespace App\Http\Middleware;

use App\Models\Appointment;
use App\Models\Medical;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedRecords
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        view()->composer('*', function ($view) use ($user) {
    if (!$user) {
        // Guest → no data
        $view->with('medical_records', collect());
        $view->with('appointments', collect());
        return;
    }

    // --------------------------
    // PATIENT
    // --------------------------
    if ($user->role === 'patient') {
        $view->with('medical_records', Medical::with('doctor') // assuming you add doctor_id later
            ->where('patient_id', $user->id)
            ->latest()
            ->get());

        $view->with('appointments', Appointment::with('doctor')
            ->where('patient_id', $user->id)
            ->latest()
            ->get());
    }

    // --------------------------
    // DOCTOR
    // --------------------------
    elseif ($user->role === 'doctor') {
        $view->with('medical_records', Medical::with('patient')
            ->where('doctor_id', $user->id) // you’ll need doctor_id column in medical_records
            ->latest()
            ->get());

        $view->with('appointments', Appointment::with('patient')
            ->where('doctor_id', $user->id)
            ->latest()
            ->get());
    }

    // --------------------------
    // ADMIN
    // --------------------------
    elseif ($user->role === 'admin') {
        $view->with('medical_records', Medical::with(['patient', 'doctor'])->latest()->get());
        $view->with('appointments', Appointment::with(['patient', 'doctor'])->latest()->get());
    }

    // --------------------------
    // FALLBACK
    // --------------------------
    else {
        $view->with('medical_records', collect());
        $view->with('appointments', collect());
    }
});

        return $next($request);
    }
}
