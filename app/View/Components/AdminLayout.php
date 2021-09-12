<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public bool $showSearch;
    public bool $showErrors;

    public function __construct(bool $showErrors = true, bool $showSearch = false) {
        $this->showErrors = $showErrors;
        $this->showSearch = $showSearch;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.admin');
    }
}
