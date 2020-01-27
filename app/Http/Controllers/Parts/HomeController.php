<?php

namespace App\Http\Controllers\Parts;

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
    | PEÇAS - PRODUTOS - SERVIÇOS functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function stocks()
    {
        $Page = (object)[
            'title' => "Estoque - Qtde",
            'create_option' => 0,
            'subtitle' => "Estoque - Qtde",
        ];
        return view('pages.parts.stocks.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function item_tables()
    {
        $Page = (object)[
            'title' => "Tabela de Itens",
            'create_option' => 0,
            'subtitle' => "Tabela de Itens",
        ];
        return view('pages.parts.item_tables.index')
            ->with('Page', $Page);
    }


}
