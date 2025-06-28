<?php

namespace App\Http\Controllers;

use App\Models\TipeKamar;
use App\Models\Kamar;
use App\Models\PaketKamar;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get room types with their related data
        $roomTypes = TipeKamar::with(['kamars', 'paketKamars'])
            ->withCount([
                'kamars',
                'kamars as available_rooms_count' => function ($query) {
                    $query->where('status', 'Kosong');
                }
            ])
            ->limit(6) // Show only 6 room types on landing page
            ->get();

        // Get some stats for the landing page
        $stats = [
            'total_rooms' => Kamar::count(),
            'available_rooms' => Kamar::where('status', 'Kosong')->count(),
            'room_types' => TipeKamar::count(),
            'starting_price' => PaketKamar::min('harga') ?? 0,
        ];

        // Get featured room types (those with available rooms)
        $featuredRoomTypes = TipeKamar::whereHas('kamars', function ($query) {
            $query->where('status', 'Kosong');
        })
        ->with(['paketKamars' => function ($query) {
            $query->orderBy('harga', 'asc');
        }])
        ->limit(3)
        ->get();

        return view('welcome', compact('roomTypes', 'stats', 'featuredRoomTypes'));
    }
} 