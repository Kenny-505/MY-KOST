<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Kamar;

class RoomCard extends Component
{
    public Kamar $room;
    public bool $showBookButton;
    public ?string $minPrice;
    public ?string $maxPrice;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Kamar $room,
        bool $showBookButton = true
    ) {
        $this->room = $room;
        $this->showBookButton = $showBookButton;
        
        // Calculate price range for this room type
        $packages = $room->tipeKamar->paketKamar ?? collect();
        if ($packages->isNotEmpty()) {
            $this->minPrice = 'Rp ' . number_format($packages->min('harga'), 0, ',', '.');
            $this->maxPrice = 'Rp ' . number_format($packages->max('harga'), 0, ',', '.');
        } else {
            $this->minPrice = null;
            $this->maxPrice = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.room-card');
    }
}
