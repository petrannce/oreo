<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\BillingItem;
use App\Models\HospitalService;
use App\Models\Medicine;

class BillingService
{
    /**
     * Create or update a billing record for a given entity (lab, triage, pharmacy, etc.)
     */
    public static function createFor($billable, $patientId, $type = null)
    {
        $amount = 0;

        // Determine charge type
        if ($type === 'triage') {
            $amount = 0; // free
        } elseif ($type === 'lab') {
            $service = HospitalService::where('code', 'LAB_TEST')->first();
            $amount = $service?->price ?? 0;
        } elseif ($type === 'consultation') {
            $service = HospitalService::where('code', 'DOCTOR_CONSULT')->first();
            $amount = $service?->price ?? 0;
        } elseif ($type === 'pharmacy') {
            // Calculate total medicine prices
            foreach ($billable->items as $item) {
                $medicine = Medicine::where('name', $item->drug_name)->first();
                $amount += ($medicine?->price ?? 0) * $item->quantity;
            }
        }

        if ($amount <= 0) return null;

        $billing = Billing::create([
            'patient_id' => $patientId,
            'billable_id' => $billable->id,
            'billable_type' => get_class($billable),
            'amount' => $amount,
            'status' => 'unpaid',
        ]);

        BillingItem::create([
            'billing_id' => $billing->id,
            'description' => ucfirst($type),
            'amount' => $amount,
        ]);

        return $billing;
    }
}
