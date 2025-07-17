<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class BreadcrumbItem extends Component
{
    public $route;
    public $icon;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route = null, $icon = null, $type = null)
    {
        $this->route = $route;
        $this->icon = $icon;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.backend.breadcrumb-item');
    }
}
