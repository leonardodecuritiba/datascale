<?php

namespace App\Http\Controllers\Requestions;

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
    public function parts()
    {
        $Page = (object)[
            'title' => 'Pedido de Peças',
            'create_option' => 0,
            'subtitle' => 'Pedido de Peças',
        ];
        return view('pages.requestions.parts.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function main_provider()
    {
        $Page = (object)[
            'title' => 'Pedido Matriz Fornecedor',
            'create_option' => 0,
            'subtitle' => 'Pedido Matriz Fornecedor',
        ];
        return view('pages.requestions.main_provider.index')
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
            'title' => 'Produtos',
            'create_option' => 0,
            'subtitle' => 'Produtos',
        ];
        return view('pages.requestions.products.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function labels()
    {
        $Page = (object)[
            'title' => 'Marcas de Reparos',
            'create_option' => 0,
            'subtitle' => 'Marcas de Reparos',
        ];
        return view('pages.requestions.labels.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function seals()
    {
        $Page = (object)[
            'title' => 'Lacres',
            'create_option' => 0,
            'subtitle' => 'Lacres',
        ];
        return view('pages.requestions.seals.index')
            ->with('Page', $Page);
    }
}
