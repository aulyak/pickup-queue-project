<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $namaSiswa;
    public $nikSiswa;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($namaSiswa, $nikSiswa, $type)
    {
        //
        $this->namaSiswa = $namaSiswa;
        $this->nikSiswa = $nikSiswa;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}