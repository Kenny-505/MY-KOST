<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public string $name;
    public string $label;
    public string $type;
    public ?string $value;
    public ?string $placeholder;
    public bool $required;
    public ?string $help;
    public array $options;
    public ?string $accept;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $label,
        string $type = 'text',
        ?string $value = null,
        ?string $placeholder = null,
        bool $required = false,
        ?string $help = null,
        array $options = [],
        ?string $accept = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder ?: $label;
        $this->required = $required;
        $this->help = $help;
        $this->options = $options;
        $this->accept = $accept;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-input');
    }
}
