<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $hideSidebar;

    /**
     * Create a new component instance.
     */
    public function __construct($hideSidebar = false)
    {
        $this->hideSidebar = filter_var($hideSidebar, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
