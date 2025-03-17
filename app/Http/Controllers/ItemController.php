<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Logs;

class ItemController extends Controller
{
    //

    public function readAll(Request $request){
        return Item::orderBy('item', 'asc')->get();
    }

    public function readItem($name){
        return Item::where('item',$name)->get();
    }

    public function add(Request $request){

        $validated = $request->validate([
            'property_num' => 'nullable|string|max:255',
            'serial_num' => 'nullable|string|max:255',
            'item' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'set_items' => 'nullable|array',
            'set_items.*.property_num' => 'required|string',
            'set_items.*.serial_num' => 'required|string',
            'set_items.*.description' => 'required|string',
            'tbi_assigned' => 'required|string|max:255',

        ]);

        if (is_string($validated['set_items'])) {
            $validated['set_items'] = json_decode($validated['set_items'], true);
        }

        $item = Item::create($validated);



        $data = Item::where('item', $request->item)->first();
        Logs::create([
            'reference_id' => $item->item_id,
            'item' => $item->item,
            'quantity' => $item->quantity,
            'office' => $item->tbi_assigned,
            'person' => "Admin",    
            'purpose' => "Add Item",
            'status' => "Add"
        ]);

        
        return response()->json([
            'message' => "Item Added Successfully",
            'data' => $item
        ],201);

    }

    public function update(Request $request)
    {
        $data = Item::where('item_id', $request->item_id)->first();
    
        if (!$data) {
            return response()->json([
                'message' => "Item not found!",
                'code' => 404
            ], 404);
        }
    
        $validated = $request->validate([
            'item' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer',
            'tbi_assigned' => 'sometimes|required|string|max:255',
            'unit' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'property_num' => 'nullable|string|max:255',
            'serial_num' => 'nullable|string|max:255',
            'set_items' => 'nullable|array',
            'set_items.*.property_num' => 'nullable|string|max:255',
            'set_items.*.serial_num' => 'nullable|string|max:255',
            'set_items.*.description' => 'nullable|string|max:1000',
        ]);
    
        // Update main item details
        $data->update($validated);
    
        // Handle set items if the unit is 'SET'
        if ($request->unit === 'SET' && in_array($request->category, ['ICT Equipments', 'Furniture & Appliances'])) {
            $setItemsData = [];
    
            foreach ($request->set_items as $setItem) {
                $setItemsData[] = [
                    'property_num' => $setItem['property_num'] ?? null,
                    'serial_num' => $setItem['serial_num'] ?? null,
                    'description' => $setItem['description'] ?? '',
                ];
            }
    
        }
    
        return response()->json([
            'message' => "Item updated successfully!",
            'code' => 200
        ]);
    }
    

    public function delete($id){
        $data = Item::where('item_id', $id)->first();
        $data->delete();

        return response([
            'message' => "Item deleted successfully!",
            'code' => 200
        ]);
    }

    public function consume(Request $request){
        $data = Item::where('item_id', $request->item_id)->first();
        $data->quantity = $data->quantity - $request->quantity;
        $data->save();

        $data = Item::where('item', $request->item)->first();
        Logs::create([
            'reference_id' => $data->item_id,
            'item' => $data->item,
            'quantity' => $data->quantity,
            'office' => $data->tbi_assigned,
            'person' => $request->person,    
            'purpose' => $request->purpose,
            'status' => "Consume"
        ]);

        return response([
            'message' => "Item consumed successfully!",
            'code' => 200
        ]);
    }
}
