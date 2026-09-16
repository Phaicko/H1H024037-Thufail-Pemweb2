<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sks extends Component
{
    public function __construct(public int $sks)
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.sks');
    }
}
