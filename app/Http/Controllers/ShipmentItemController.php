<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShipmentItem;
use Illuminate\Support\Facades\DB;

class ShipmentItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => ShipmentItem::with([])->get(),
            'status' => 'success',
            'message' => 'Get shipment item success',
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = ShipmentItem::create([
                'itemId' => $request->itemId,
                'quantity' => $request->quantity,
                'shipmentId' => $request->shipmentId,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create shipment item failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create shipment item success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = ShipmentItem::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Shipment item not found',
                ]);
            }

            
            $data->itemId = $request->get('itemId');
            $data->quantity = $request->get('quantity');
            $data->shipmentId = $request->get('shipmentId');

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
            'message' => 'Update shipment item success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [ShipmentItem::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get shipment item success',
        ]);
    }

    public function destroy($id)
    {
        $data = ShipmentItem::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Shipment item not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete shipment item success',
        ]);
    }
}
