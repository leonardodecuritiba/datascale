<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    public function index()
    {
	    $Page = (object)[
		    'title' => 'Home',
            'create_option' => 0,
		    'subtitle' => 'Bem-Vindo',
	    ];
        return view('index')
	        ->with('Page', $Page);
    }


    /*
    |--------------------------------------------------------------------------
    | INTELIGÊNCIA functions
    |--------------------------------------------------------------------------
    |
    */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function banking_operations()
    {
        $Page = (object)[
            'title' => 'Operações Bancárias',
            'create_option' => 0,
            'subtitle' => 'Operações Bancárias',
        ];
        return view('pages.intelligence.banking_operations.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function goals()
    {
        $Page = (object)[
            'title' => 'Metas',
            'create_option' => 0,
            'subtitle' => 'Metas',
        ];
        return view('pages.intelligence.goals.index')
            ->with('Page', $Page);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function graphs()
    {
        $Page = (object)[
            'title' => 'Gráficos',
            'create_option' => 0,
            'subtitle' => 'Gráficos',
        ];
        return view('pages.intelligence.graphs.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments()
    {
	    $Page = (object)[
		    'title' => 'Pagamentos - Recebimentos',
            'create_option' => 0,
		    'subtitle' => 'Pagamentos - Recebimentos',
	    ];
        return view('pages.intelligence.payments.index')
	        ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function reports()
    {
	    $Page = (object)[
		    'title' => 'Relatórios',
            'create_option' => 0,
		    'subtitle' => 'Relatórios',
	    ];
        return view('pages.intelligence.reports.index')
	        ->with('Page', $Page);
    }




    /*
    |--------------------------------------------------------------------------
    | COMUNICAÇÃO functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function schedules()
    {
        $Page = (object)[
            'title' => 'Agenda',
            'create_option' => 0,
            'subtitle' => 'Agenda',
        ];
        return view('pages.communication.schedules.index')
            ->with('Page', $Page);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function notices()
    {
        $Page = (object)[
            'title' => 'Avisos',
            'create_option' => 0,
            'subtitle' => 'Avisos',
        ];
        return view('pages.communication.notices.index')
            ->with('Page', $Page);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications()
    {
        $Page = (object)[
            'title' => 'Notificações',
            'create_option' => 0,
            'subtitle' => 'Notificações',
        ];
        return view('pages.communication.notifications.index')
            ->with('Page', $Page);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function calls()
    {
        $Page = (object)[
            'title' => 'Chamados',
            'create_option' => 0,
            'subtitle' => 'Chamados',
        ];
        return view('pages.communication.calls.index')
            ->with('Page', $Page);
    }



    /*
    |--------------------------------------------------------------------------
    | FINANCEIRO functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank_charges()
    {
        $Page = (object)[
            'title' => 'Taxas Bancárias',
            'create_option' => 0,
            'subtitle' => 'Taxas Bancárias',
        ];
        return view('pages.financial.bank_charges.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bank_apis()
    {
        $Page = (object)[
            'title' => 'APIs Bancárias',
            'create_option' => 0,
            'subtitle' => 'APIs Bancárias',
        ];
        return view('pages.financial.bank_apis.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function banks()
    {
        $Page = (object)[
            'title' => 'Instituições Bancárias',
            'create_option' => 0,
            'subtitle' => 'Instituições Bancárias',
        ];
        return view('pages.financial.banks.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function franchiseesBillings()
    {
        $Page = (object)[
            'title' => "Faturamentos para Franqueados",
            'create_option' => 0,
            'subtitle' => "Faturamentos para Franqueados",
        ];
        return view('pages.financial.billings.franchisees.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fiscals()
    {
        $Page = (object)[
            'title' => "Fiscal",
            'create_option' => 0,
            'subtitle' => "Fiscal",
        ];
        return view('pages.financial.fiscals.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function stock_values()
    {
        $Page = (object)[
            'title' => "Estoque Valores",
            'subtitle' => "Estoque Valores",
            'create_option' => 0,
        ];
        return view('pages.financial.stock_values.index')
            ->with('Page', $Page);
    }



    /*
    |--------------------------------------------------------------------------
    | IPEM functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function patterns()
    {
        $Page = (object)[
            'title' => 'Padrões - Certificados',
            'create_option' => 0,
            'subtitle' => 'Padrões - Certificados',
        ];
        return view('pages.ipem.patterns.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function technical_capacity()
    {
        $Page = (object)[
            'title' => 'Capacidade Técnica',
            'create_option' => 0,
            'subtitle' => 'Capacidade Técnica',
        ];
        return view('pages.ipem.technical_capacity.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pam()
    {
        $Page = (object)[
            'title' => 'Pam',
            'create_option' => 0,
            'subtitle' => 'Pam',
        ];
        return view('pages.ipem.pam.index')
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
            'title' => 'Marcas de reparo',
            'create_option' => 0,
            'subtitle' => 'Marcas de reparo',
        ];
        return view('pages.ipem.labels.index')
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
        return view('pages.ipem.seals.index')
            ->with('Page', $Page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulks()
    {
        $Page = (object)[
            'title' => 'Massas',
            'create_option' => 0,
            'subtitle' => 'Massas',
        ];
        return view('pages.ipem.bulks.index')
            ->with('Page', $Page);
    }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function inspections() {
		$Page = (object) [
			'title'         => 'Inspeção',
			'create_option' => 0,
			'subtitle'      => 'Inspeção',
		];

		return view( 'pages.ipem.inspections.index' )
			->with( 'Page', $Page );
	}




    /*
    |--------------------------------------------------------------------------
    | OPERAÇÕES functions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function technical_operations()
    {
        return Redirect::route('orders.index');
//        return view('pages.transactions.technical_operations.index')
//            ->with('Page', $Page);
    }


    /**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function comercial_operations()
	{
		$Page = (object)[
			'title' => "Operações Comerciais",
            'create_option' => 0,
			'subtitle' => "Operações Comerciais",
		];
		return view('pages.transactions.commercial_operations.index')
			->with('Page', $Page);
	}



}
