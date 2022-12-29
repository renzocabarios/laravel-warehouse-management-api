<?php

namespace App\Http\Controllers;

use App\Models\ShipmentItem;
use Illuminate\Http\Request;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Shipment::with(["vehicle"])->get(),
            'status' => 'success',
            'message' => 'Get shipment success',
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = Shipment::create([
                'isApproved' => false,
                'vehicleId' => $request->vehicleId,
            ]);

            foreach ($request->items as $item) {
                ShipmentItem::create([
                    'itemId' => $item["itemId"],
                    'quantity' => $item["quantity"],
                    'shipmentId' => $data->id,
                ]);
            }


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create shipment success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Shipment::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Shipment not found',
                ]);
            }

            $data->isApproved = $request->get('isApproved');
            $data->vehicleId = $request->get('vehicleId');

            $data->save();
            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Update shipment success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Shipment::with(["vehicle"])->find($id)],
            'status' => 'success',
            'message' => 'Get shipment success',
        ]);
    }

    public function destroy($id)
    {
        $data = Shipment::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Shipment not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete shipment success',
        ]);
    }
}