<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {

            return $this->adminDashboard();
        }

        return $this->dosenDashboard();
        // return Inertia::render('Dashboard', [
        //     'title' => 'Dashboard',
        // ]);
    }

    private function adminDashboard()
    {
        return Inertia::render('Dashboard', [

            'totalRooms' => Room::count(),

            'totalBookings' => Booking::count(),

            'pending' => Booking::where('status', 'Menunggu')->count(),

            'approved' => Booking::where('status', 'Disetujui')->count(),

            'rejected' => Booking::where('status', 'Ditolak')->count(),

            'completed' => Booking::where('status', 'Selesai')->count(),

            'latestBookings' => Booking::with([
                'room',
                'user'
            ])
                ->latest()
                ->take(10)
                ->get(),

        ]);
    }

    // dosen dashboard
    private function dosenDashboard()
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [

            'totalBookings' => $user->bookings()->count(),

            'pending' => $user->bookings()
                ->where('status', 'Menunggu')
                ->count(),

            'approved' => $user->bookings()
                ->where('status', 'Disetujui')
                ->count(),

            'rejected' => $user->bookings()
                ->where('status', 'Ditolak')
                ->count(),

            'completed' => $user->bookings()
                ->where('status', 'Selesai')
                ->count(),

            'latestBookings' => $user->bookings()
                ->with('room')
                ->latest()
                ->take(10)
                ->get(),

        ]);
    }
}
