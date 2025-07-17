<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.backend.breadcrumbs');
    }
}
