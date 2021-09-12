<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public bool $showErrors;

    public function __construct(bool $showErrors = true) {
        $this->showErrors = $showErrors;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
