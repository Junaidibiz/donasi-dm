<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Judul halaman.
     *
     * @var string
     */
    public $title;

    /**
     * Buat instance komponen baru.
     *
     * @param  string  $title
     * @return void
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name', 'Dashboard');
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}