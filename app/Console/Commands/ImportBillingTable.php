<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Client;
use App\Models\Financials\Billing;
use App\Models\Financials\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportBillingTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:billings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Billing::flushEventListeners();
        Billing::getEventDispatcher();

        $entity = "faturamentos";

        $this->info( '* Import FATURAMENTOS' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $client = Client::where('idcliente', $row->idcliente)->first();
                $payment = Payment::where('idpagamentos', $row->idpagamento)->first();

	            $id = DB::table('billings')->insertGetId([
	                'created_at'            => $row->created_at,
                    'idfaturamentos'        => $row->idfaturamento,
                    'client_id'             => $client->id,
                    'status'                => $row->idstatus_faturamento,
                    'payment_id'            => $payment->id,
                    'nfe_id_homologacao'    => $row->idnfe_homologacao,
                    'nfe_date_homologacao'  => $row->data_nfe_homologacao,
                    'nfe_id_producao'       => $row->idnfe_producao,
                    'nfe_date_producao'     => $row->data_nfe_producao,
                    'nfse_id_homologacao'   => $row->idnfse_homologacao,
                    'nfse_date_homologacao' => $row->data_nfse_homologacao,
                    'nfse_id_producao'      => $row->idnfse_producao,
                    'nfse_date_producao'    => $row->data_nfse_producao,
                    'nfe_link'              => NULL,
                    'nfse_link'             => NULL,
                    'cost_center'           => $row->centro_custo
                ]);

                $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
