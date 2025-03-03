<?php

namespace App\Http\Controllers;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\Logs;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    //

    public function borrow(Request $request){
        Borrow::create([
            'item_id' => $request->item_id,
            'item' => $request->item,
            'category' => $request->category,
            'expected_return' => $request->expected_return,
            'quantity' => $request->quantity,
            'office' => $request->office,
            'person' => $request->person,
            'purpose' => $request->purpose
        ]);
        $data = Borrow::where('item_id', $request->item_id)->first();
        Logs::create([
            'reference_id' => $data->borrow_id,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'office' => $request->office,
            'person' => $request->person,
            'purpose' => $request->purpose,
            'status' => "Borrow"
        ]);

        $data = Item::where('item_id', $request->item_id)->first();
        if($data->quantity < $request->quantity){
            return response()->json([
                'message' => "Not Enough Item",
                'code' => 200
            ]);
        }
        elseif($data) {
            // Deduct the borrowed Item to Item Inventory
            $data->quantity = $data->quantity - $request->quantity;
            $data->save();
    
            return response()->json([
                'message' => "Item Borrowed Successfully!",
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => "Item not found.",
                'code' => 404
            ]);
        }
    }

    public function borrowed(Request $request){
        return Borrow::all();
    }

    public function delete($id){
        $data = Borrow::where('borrow_id', $id)->first();
        $data->delete();
        return response([
            'message' => "Item deleted successfully!",
            'code' => 200
        ]);
    }

}
