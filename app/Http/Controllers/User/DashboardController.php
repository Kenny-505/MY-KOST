<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $availableRooms = Kamar::where('status', 'Kosong')->count();
        $roomTypes = TipeKamar::all();
        
        return view('user.dashboard', compact('availableRooms', 'roomTypes'));
    }
}