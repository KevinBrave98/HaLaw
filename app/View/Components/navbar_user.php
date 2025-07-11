<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navbar_user extends Component
{
    /**
     * Create a new component instance.
     */
    public $pengguna;
    public function __construct($pengguna)
    {
        $this->pengguna = $pengguna;
    }

    /**
     * Get the view / conte nts that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar_user');
    }
}
