<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatBox extends Component
{
    public string $title;
    public string $value;
    public string $icon;
    public string $color;
    public ?string $subtitle;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string $value,
        string $icon = 'chart-bar',
        string $color = 'blue',
        ?string $subtitle = null
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stat-box');
    }
}
