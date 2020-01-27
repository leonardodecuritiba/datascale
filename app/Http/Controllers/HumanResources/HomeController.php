<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |--------------------------------------------------------------------------
    | ROLES functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        $Page = (object)[
            'title' => "Grupos",
            'create_option' => 0,
            'subtitle' => "Grupos",
        ];
        return view('pages.settings.human_resources.roles.index')
            ->with('Page', $Page);
    }

}
