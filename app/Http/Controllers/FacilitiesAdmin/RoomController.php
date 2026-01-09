<?php

namespace App\Http\Controllers\FacilitiesAdmin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Inventory;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('Inventories')->get();
        return view('roles.FacilitiesAdmin.room.index', compact('rooms'));
    }

    public function create()
    {
        return view('roles.FacilitiesAdmin.room.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:rooms,code',
        ], [
            'name.required' => 'Nama Ruangan tidak boleh kosong!',
            'code.required' => 'Kode Ruangan tidak boleh kosong!',
            'code.unique' => 'Kode Ruangan sudah ada!',
        ]);

        Room::create($validated);

        return redirect()->route('facilitiesadmin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $room = Room::with('Inventories')->findOrFail($id);
        return view('roles.FacilitiesAdmin.room.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('roles.FacilitiesAdmin.room.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:rooms,code,' . $id,
        ], [
            'name.required' => 'Nama Ruangan tidak boleh kosong!',
            'code.required' => 'Kode Ruangan tidak boleh kosong!',
            'code.unique' => 'Kode Ruangan sudah ada!',
        ]);

        $room = Room::findOrFail($id);
        $room->update($validated);

        return redirect()->route('facilitiesadmin.rooms.index')->with('success', 'Ruangan berhasil diubah!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        // Note: Set null on delete is handled by database foreign key constraint for Inventories
        $room->delete();

        return redirect()->route('facilitiesadmin.rooms.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}
