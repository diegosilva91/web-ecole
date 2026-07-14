<?php

namespace App\View\Components;

use Illuminate\View\Component;
use DB;

class CoursesList extends Component
{
    public function __construct(public $courses, public $origin)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.courses-list');
    }
}
