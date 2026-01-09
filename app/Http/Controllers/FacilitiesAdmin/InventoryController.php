<?php

namespace App\Http\Controllers\FacilitiesAdmin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::query()->with('room'); // Eager load room

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('item_code', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        $inventories = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('roles.FacilitiesAdmin.inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = \App\Models\Room::all();
        return view('roles.FacilitiesAdmin.inventories.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_code' => 'required|string|unique:inventories,item_code',
            'name' => 'required|string|max:255',
            'condition' => 'required|in:Good,Damaged,Lost',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
            'location' => 'nullable|string|max:255', // Location is now detail location, optional
            'description' => 'nullable|string',
        ]);

        Inventory::create($request->all());

        return redirect()->route('facilitiesadmin.inventories.index')->with('success', 'Item added to inventory successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $rooms = \App\Models\Room::all();
        return view('roles.FacilitiesAdmin.inventories.edit', compact('inventory', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_code' => 'required|string|unique:inventories,item_code,' . $inventory->id,
            'name' => 'required|string|max:255',
            'condition' => 'required|in:Good,Damaged,Lost',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $inventory->update($request->all());

        return redirect()->route('facilitiesadmin.inventories.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('facilitiesadmin.inventories.index')->with('success', 'Inventory item deleted successfully.');
    }

    /**
     * Print the inventory list.
     */
    public function print(Request $request)
    {
        $inventories = Inventory::orderBy('item_code')->get();
        return view('roles.FacilitiesAdmin.inventories.print', compact('inventories'));
    }
}
