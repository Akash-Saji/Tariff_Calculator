<?php

namespace App\Http\Controllers;

use App\Models\BillModel;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillControllers extends Controller
{
    public function index()
    {
        $bills = BillModel::all();

        $data = [
            'status' => 200,
            'bills' => $bills
        ];

        return response()->json($data, 200);
    }

    public function postBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'units' => 'required|integer',
            'Tariff' => 'required|in:LT-1A',
            'Purpose' => 'required|in:Domestic',
            'Phase' => 'required|in:Single phase',
            'BillingCycle' => 'required|in:2 months',
        ]);

        if ($validator->fails()) {
            $data = [
                "status" => 422,
                "message" => $validator->messages()
            ];

            return response()->json($data, 422);
        } else {
            $unitsConsumed = $request->units;

       
            $fixedCharge = 35;

   
            $totalCost = $fixedCharge;

       
            if ($unitsConsumed <= 250) {
           
                $totalCost += $this->calculateTelescopicCost($unitsConsumed);
            } else {
              
                $nonTelescopicRate = Tariff::where('type', 'non-telescopic')->first();

                if ($nonTelescopicRate) {
                    $totalCost += $unitsConsumed * $nonTelescopicRate->rate;
                } else {
                   
                    $data = [
                        "status" => 404,
                        "message" => "Non-telescopic rate not found"
                    ];
                    return response()->json($data, 404);
                }
            }

     
            $bill = new BillModel;
            $bill->units = $unitsConsumed;
            $bill->Tariff = $request->Tariff;
            $bill->Purpose = $request->Purpose;
            $bill->Phase = $request->Phase; 
            $bill->BillingCycle = $request->BillingCycle;         
            $bill->total_cost = $totalCost;
            $bill->save();

            $data = [
                "status" => 200,
                "message" => "Data uploaded successfully",
                "totalCost" => $totalCost
            ];

            return response()->json($data, 200);
        }
    }

    private function calculateTelescopicCost($unitsConsumed)
    {
        $totalCost = 0;

        $telescopicRates = Tariff::where('type', 'telescopic')->orderBy('slab_start')->get();

        foreach ($telescopicRates as $rate) {
            if (is_null($rate->slab_end) || $unitsConsumed <= $rate->slab_end) {
                $units = min($unitsConsumed, $rate->slab_end) - $rate->slab_start + 1;
                $totalCost += $units * $rate->rate;
                break;
            } else {
              
                $units = $rate->slab_end - $rate->slab_start + 1;
                $totalCost += $units * $rate->rate;
            }
            $unitsConsumed -= $units;
        }

        return $totalCost;
    }
}
