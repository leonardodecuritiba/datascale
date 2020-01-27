<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Client;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use App\Models\Financials\Payment;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportOrderTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:orders';

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
        Order::flushEventListeners();
        Order::getEventDispatcher();

        $entity = "ordem_servicos";

        $this->info( '* Import ORDEM DE SERVIÇOS' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $client = Client::where('idcliente', $row->idcliente)->first();
                $cost_center = Client::where('idcliente', $row->idcentro_custo)->first();
                $billing = Billing::where('idfaturamentos', $row->idfaturamento)->first();
                $user = User::where('idcolaborador', $row->idcolaborador)->first();

	            $id = DB::table('orders')->insertGetId([
                    'created_at'            => $row->created_at,
                    'idordem_servico'       => $row->idordem_servico,
                    'client_id'             => $client->id,
                    'user_id'               => $user->id,
                    'status'                => $row->idsituacao_ordem_servico,
                    'cost_center_id'        => optional($cost_center)->id,
                    'billing_id'            => optional($billing)->id,

                    'finished_at'         => $row->data_finalizada,
                    'closed_at'           => $row->data_fechada,
                    'call_number'           => $row->numero_chamado,
                    'responsible'           => $row->responsavel,
                    'responsible_cpf'       => $row->responsavel_cpf,
                    'responsible_position'  => $row->responsavel_cargo,
                    'total_value'           => $row->valor_total,
                    'discount_tec'          => $row->desconto_tecnico,
                    'increase_tec'          => $row->acrescimo_tecnico,
                    'final_value'           => $row->valor_final,

                    'travel_cost'           => $row->custos_deslocamento,
                    'tolls'                 => $row->pedagios,
                    'other_cost'            => $row->outros_custos,
                    'exemption_cost'        => $row->custos_isento,

                ]);

	            $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
