<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;

class StageFlowService
{
    protected static $validStages = [
        'reception', 'triage', 'doctor_consult', 'lab',
        'pharmacy', 'billing', 'completed', 'cancelled',
    ];

    protected static $rolePermissions = [
        'receptionist'    => ['reception', 'triage', 'cancelled'],
        'nurse'           => ['triage', 'doctor_consult'],
        'doctor'          => ['doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'],
        'lab_technician'  => ['lab'],
        'pharmacist'      => ['pharmacy', 'billing', 'completed'],
        'admin'           => ['reception', 'triage', 'doctor_consult', 'lab', 'pharmacy', 'billing', 'completed', 'cancelled'],
    ];

    public static function updateStage(Appointment $appointment, string $stage)
    {
        $user = Auth::user();
        $role = $user->role ?? null;

        // Validate stage
        if (!in_array($stage, self::$validStages)) {
            return ['error' => 'Invalid stage selected.'];
        }

        // Check permission
        if (!isset(self::$rolePermissions[$role]) || !in_array($stage, self::$rolePermissions[$role])) {
            return ['error' => 'You do not have permission to move a patient to this stage.'];
        }

        // Prevent redundant update
        if ($appointment->process_stage === $stage) {
            return ['info' => 'Patient is already in this stage.'];
        }

        // Update and log who did it
        $appointment->process_stage = $stage;
        $appointment->updated_by = $user->id ?? null;
        $appointment->save();

        // Optional automation
        self::handleAutoActions($appointment, $stage);

        // Return message
        return ['success' => 'Patient moved to ' . ucfirst(str_replace('_', ' ', $stage)) . ' stage successfully.'];
    }

    protected static function handleAutoActions(Appointment $appointment, string $stage)
    {
        // Example automation: Auto-create billing record when reaching billing stage
        if ($stage === 'billing') {
            if (!Billing::where('billable_type', Appointment::class)
                ->where('billable_id', $appointment->id)
                ->exists()) {
                Billing::create([
                    'patient_id'         => $appointment->patient_id,
                    'billable_type'      => Appointment::class,
                    'billable_id'        => $appointment->id,
                    'amount'             => 0.00,
                    'status'             => 'unpaid',
                ]);
            }
        }
    }
}
