<?php

namespace App\View\Components;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt',
            ],
        ];

        if (auth()->user()->role_id === RoleEnum::ADMIN) {
            $menus[] =
                [
                    'name' => 'Kelas',
                    'route' => 'classrooms.index',
                    'icon' => 'fas fa-school',
                ];
        }


        return view('layouts.sidebar', compact('menus'));
    }
}
