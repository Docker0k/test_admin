<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $menu;

    /**
     * @param $menu
     * @return void
     */
    public function setLayout($menu): void
    {
        $this->menu = $menu;
    }

    public function boot()
    {
        //
    }
}
