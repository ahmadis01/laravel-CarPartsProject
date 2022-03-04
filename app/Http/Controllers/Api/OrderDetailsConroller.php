<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderParts;
use Illuminate\Http\Request;

class OrderDetailsConroller extends Controller
{
    public function ShowOrderParts($id)
    {
        $order = OrderParts::where('order_id', $id)->get();
        return response()->json($order);
    }
    public function AddOrderParts($id, request $request)
    {
        for($i=0;$i<count($request->part_id);$i++) {
            OrderParts::updateOrCreate([
                'order_id' => $id,
                'part_id' => $request->part_id[$i],
                'quantity' => $request->quantity[$i]
            ]);
        }
    }
}
