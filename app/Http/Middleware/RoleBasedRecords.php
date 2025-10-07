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
                $view->with('medical_records', Medical::with('doctor')
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
                    ->where('doctor_id', $user->id)
                    ->latest()
                    ->get());

                $view->with('appointments', Appointment::with('patient')
                    ->where('doctor_id', $user->id)
                    ->latest()
                    ->get());
            }

            // --------------------------
            // RECEPTIONIST
            // --------------------------
            elseif ($user->role === 'receptionist') {
                // Receptionists can see all appointments
                $view->with('appointments', Appointment::with(['patient', 'doctor'])
                    ->latest()
                    ->get());

                // Usually, receptionists don’t access full medical records.
                // But if needed, you can include limited info.
                $view->with('medical_records', collect());
                
            }

            // --------------------------
            // LAB_TECHNICIAN
            // --------------------------
            elseif ($user->role === 'lab_technician') {
                $view->with('appointments', Appointment::with(['patient', 'doctor'])->latest()->get());
                $view->with('medical_records', collect());
            }

            // --------------------------
            // NURSE
            // --------------------------
            elseif ($user->role === 'nurse') {
                $view->with('appointments', Appointment::with(['patient', 'doctor'])->latest()->get());
                $view->with('medical_records', collect());
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
