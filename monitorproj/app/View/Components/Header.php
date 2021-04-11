<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $a;
    public $fruits3;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($name,$fruits2)
    {
        $this->a = $name;
        $this->fruits3 = $fruits2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}
