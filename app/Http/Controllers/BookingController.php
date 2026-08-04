<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookingController extends Controller
{
    // public function index(Request $request)
    // {
    //     // $query = Booking::with(['room', 'user']);

    //     // // Jika dosen, hanya tampilkan data miliknya
    //     // if (auth()->user()->hasRole('Dosen')) {
    //     //     $query->where('user_id', auth()->id());
    //     // }

    //     // $bookings = $query->latest()->paginate(10);

    //     // return Inertia::render('Bookings/Index', [
    //     //     'bookings' => $bookings
    //     // ]);

    //     $query = Booking::with([
    //         'room',
    //         'user'
    //     ]);

    //     /*
    // |--------------------------------------------------------------------------
    // | Role Dosen
    // |--------------------------------------------------------------------------
    // */

    //     if (auth()->user()->hasRole('Dosen')) {

    //         $query->where('user_id', auth()->id());
    //     }

    //     /*
    // |--------------------------------------------------------------------------
    // | Search
    // |--------------------------------------------------------------------------
    // */

    //     if ($request->filled('search')) {

    //         $search = $request->search;

    //         $query->where(function ($q) use ($search) {

    //             $q->whereHas('room', function ($room) use ($search) {

    //                 $room->where('name', 'like', "%$search%");
    //             })

    //                 ->orWhereHas('user', function ($user) use ($search) {

    //                     $user->where('name', 'like', "%$search%");
    //                 })

    //                 ->orWhere('purpose', 'like', "%$search%");
    //         });
    //     }

    //     /*
    // |--------------------------------------------------------------------------
    // | Status
    // |--------------------------------------------------------------------------
    // */

    //     if ($request->filled('status')) {

    //         $query->where('status', $request->status);
    //     }

    //     /*
    // |--------------------------------------------------------------------------
    // | Tanggal
    // |--------------------------------------------------------------------------
    // */

    //     if ($request->filled('booking_date')) {

    //         $query->whereDate(
    //             'booking_date',
    //             $request->booking_date
    //         );
    //     }

    //     $bookings = $query
    //         ->latest()
    //         ->paginate(10)
    //         ->withQueryString();

    //     return Inertia::render('Bookings/Index', [

    //         'bookings' => $bookings,

    //         'filters' => $request->only([

    //             'search',

    //             'status',

    //             'booking_date'

    //         ])

    //     ]);
    // }
    public function index(Request $request)
    {
        $query = Booking::with([
            'room:id,kode_ruang,nama_ruang,gedung',
            'user:id,name'
        ]);

        /*
    |--------------------------------------------------------------------------
    | Dosen hanya melihat pengajuan miliknya
    |--------------------------------------------------------------------------
    */
        if (auth()->user()->hasRole('Dosen')) {
            $query->where('user_id', auth()->id());
        }

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Cari berdasarkan data ruang
                $q->whereHas('room', function ($room) use ($search) {

                    $room->where(function ($r) use ($search) {

                        $r->where('kode_ruang', 'like', "%{$search}%")
                            ->orWhere('nama_ruang', 'like', "%{$search}%")
                            ->orWhere('gedung', 'like', "%{$search}%");
                    });
                })

                    // Cari berdasarkan nama dosen
                    ->orWhereHas('user', function ($user) use ($search) {

                        $user->where('name', 'like', "%{$search}%");
                    })

                    // Cari berdasarkan keperluan
                    ->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Status
    |--------------------------------------------------------------------------
    */
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        /*
    |--------------------------------------------------------------------------
    | Filter Tanggal
    |--------------------------------------------------------------------------
    */
        if ($request->filled('booking_date')) {

            $query->whereDate('booking_date', $request->booking_date);
        }

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
        $bookings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Bookings/Index', [

            'bookings' => $bookings,

            'filters' => [
                'search'       => $request->search,
                'status'       => $request->status,
                'booking_date' => $request->booking_date,
            ],

        ]);
    }

    public function create()
    {
        $rooms = Room::where('status', 'Aktif')->get();

        return Inertia::render('Bookings/Create', [
            'rooms' => $rooms
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        Booking::create([
            'room_id'      => $request->room_id,
            'user_id'      => auth()->id(),
            'booking_date' => $request->booking_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'purpose'      => $request->purpose,
            'status'       => 'Menunggu',
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        return Inertia::render('Bookings/Show', [
            'booking' => $booking->load('room', 'user')
        ]);
    }

    public function edit(Booking $booking)
    {
        return Inertia::render('Bookings/Edit', [
            'booking' => $booking,
            'rooms'   => Room::where('status', 'Aktif')->get()
        ]);
    }

    public function update(StoreBookingRequest $request, Booking $booking)
    {
        if ($booking->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan tidak dapat diubah.');
        }

        $booking->update($request->validated());

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pengajuan berhasil diubah.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan tidak dapat dihapus.');
        }

        $booking->delete();

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }





    // ///untuk method approve booking
    public function approve(Booking $booking)
    {
        // Tidak boleh approve selain status Menunggu
        if ($booking->status != 'Menunggu') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        // Cek bentrok jadwal
        $isConflict = Booking::where('room_id', $booking->room_id)
            ->where('booking_date', $booking->booking_date)
            ->where('status', 'Disetujui')
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($booking) {

                $query->where('start_time', '<', $booking->end_time)
                    ->where('end_time', '>', $booking->start_time);
            })
            ->exists();

        if ($isConflict) {

            return back()->with(
                'error',
                'Ruangan sudah dipinjam pada waktu tersebut.'
            );
        }

        DB::transaction(function () use ($booking) {

            $booking->update([

                'status' => 'Disetujui',

                'approved_by' => auth()->id(),

                'approved_at' => now(),

            ]);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    // Untuk method reject booking
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        if ($booking->status != 'Menunggu') {

            return back()->with(
                'error',
                'Pengajuan sudah diproses.'
            );
        }

        $booking->update([

            'status' => 'Ditolak',

            'approved_by' => auth()->id(),

            'approved_at' => now(),

            'rejection_reason' => $request->rejection_reason,

        ]);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
