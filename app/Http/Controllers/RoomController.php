<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->search, function ($query, $search) {
                $query->where('kode_ruang', 'like', "%{$search}%")
                    ->orWhere('nama_ruang', 'like', "%{$search}%");
            })
            ->when($request->gedung, function ($query, $gedung) {
                $query->where('gedung', $gedung);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms,
            'filters' => $request->only('search', 'gedung'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
