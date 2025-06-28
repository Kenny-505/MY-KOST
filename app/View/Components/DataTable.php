<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class DataTable extends Component
{
    public array $headers;
    public $data;
    public bool $showActions;
    public ?string $editRoute;
    public ?string $deleteRoute;
    public ?string $showRoute;
    public string $emptyMessage;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $headers,
        $data,
        bool $showActions = true,
        ?string $editRoute = null,
        ?string $deleteRoute = null,
        ?string $showRoute = null,
        string $emptyMessage = 'Tidak ada data yang tersedia.'
    ) {
        $this->headers = $headers;
        $this->data = $data;
        $this->showActions = $showActions;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->showRoute = $showRoute;
        $this->emptyMessage = $emptyMessage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}
