<?php

namespace App\Http\Controllers\Patrimonies;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function patterns()
    {
        $Page = (object)[
            'title' => 'Patrimônio de Padrões',
            'create_option' => 0,
            'subtitle' => 'Patrimônio de Padrões',
        ];
        return view('pages.patrimonies.patterns.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function parts()
    {
        $Page = (object)[
            'title' => 'Patrimônio de Peças',
            'create_option' => 0,
            'subtitle' => 'Patrimônio de Peças',
        ];
        return view('pages.patrimonies.parts.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        $Page = (object)[
            'title' => 'Patrimônio de Produtos',
            'create_option' => 0,
            'subtitle' => 'Patrimônio de Produtos',
        ];
        return view('pages.patrimonies.products.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function equipments()
    {
        $Page = (object)[
            'title' => 'Patrimônio de Equipamentos de Backup',
            'create_option' => 0,
            'subtitle' => 'Patrimônio de Equipamentos de Backup',
        ];
        return view('pages.patrimonies.equipments.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function tools()
    {
        $Page = (object)[
            'title' => 'Patrimônio de Ferramentas',
            'create_option' => 0,
            'subtitle' => 'Patrimônio de Ferramentas',
        ];
        return view('pages.patrimonies.tools.index')
            ->with('Page', $Page);
    }
}
