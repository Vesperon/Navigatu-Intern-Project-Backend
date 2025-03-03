<?php

namespace App\Http\Controllers;
use App\Models\Returned;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\Logs;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    //
    public function returned(Request $request){
        Returned::create([
            'borrow_id' => $request->borrow_id,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'office' => $request->office,
            'person' => $request->person,
            'purpose' => $request->purpose
        ]);
        $data = Returned::where('borrow_id', $request->borrow_id)->first();
        Logs::create([
            'reference_id' => $data->returned_id,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'office' => $request->office,
            'person' => $request->person,
            'purpose' => $request->purpose,
            'status' => "Returned"
        ]);

        $data = Borrow::where('borrow_id', $request->borrow_id)->first();
        $item = Item::where('item_id', $data->item_id)->first();
        if($item){
            $item->quantity = $item->quantity + $data->quantity;
            $item->save();

            return response()->json([
                'message' => "Item Returned Successfully!",
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => "Item not found.",
                'code' => 404
            ]);
        }
    }

    public function returnedItem(Request $request){
        return Returned::all();
    }
}
