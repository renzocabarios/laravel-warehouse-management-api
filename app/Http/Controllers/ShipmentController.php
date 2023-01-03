<?php

namespace App\Http\Controllers;

use App\Models\ShipmentItem;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Shipment::with(["vehicle", "shipmentItems", "to", "from"])->get(),
            'status' => 'success',
            'message' => 'Get shipment success',
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'vehicleId' => 'required|numeric',
            'to' => 'required|numeric',
            'items' => 'required|array',
            'from' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'The form is not valid',
            ]);
        }

        try {
            DB::beginTransaction();

            $data = Shipment::create([
                'isApproved' => false,
                'vehicleId' => $request->vehicleId,
                'to' => $request->to,
                'from' => $request->from,
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
            'data' => [Shipment::with(["vehicle", "shipmentItems", "to", "from"])->find($id)],
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

    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $data = Shipment::with(["vehicle", "shipmentItems", "to", "from"])->find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Shipment not found',
                ]);
            }

            if (!$data->isApproved) {
                $shimemtItems = ShipmentItem::get()->where('shipmentId', '==', $data->id);
                $toId = $data["to"];
                $fromId = $data["from"];

                foreach ($shimemtItems as $item) {

                    $tempStockTo = Stock::get()->where('branchId', '==', $toId)->where('itemId', '==', $item->itemId)->first();

                    if (!$tempStockTo) {
                        $tempStockTo = Stock::create([
                            'itemId' => $item->itemId,
                            'quantity' => 0,
                            'branchId' => $toId,
                        ]);
                    }

                    if (!$tempStockTo->quantity > $item->quantity) {
                        return response()->json([
                            'data' => [$tempStockTo->quantity],
                            'status' => 'failed',
                            'message' => 'To Branch does not have enough stock',
                        ]);
                    }

                    $tempStockTo->quantity = $tempStockTo->quantity - $item->quantity;
                    $tempStockTo->save();

                    $tempStockFrom = Stock::get()->where('branchId', '==', $fromId)->where('itemId', '==', $item->itemId)->first();
                    if (!$tempStockFrom) {
                        $tempStockFrom = Stock::create([
                            'itemId' => $item->itemId,
                            'quantity' => 0,
                            'branchId' => $fromId,
                        ]);
                    }

                    $tempStockFrom->quantity = $tempStockFrom->quantity + $item->quantity;
                    $tempStockFrom->save();
                }
            }

            $data->isApproved = true;

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
}