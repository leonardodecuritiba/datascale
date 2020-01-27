<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Client;
use App\Models\Inputs\Equipment;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Transactions\Apparatu;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use App\Models\Financials\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportApparatuTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:apparatus';

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
        Apparatu::flushEventListeners();
        Apparatu::getEventDispatcher();

        $entity = "aparelho_manutencao";

        $this->info( '* Import aparelho_manutencaos' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $order = Order::where('idordem_servico', $row->idordem_servico)->first();
                $instrument = Instrument::where('idinstrumento', $row->idinstrumento)->first();
                $equipment = Equipment::where('idequipamento', $row->idequipamento)->first();

	            $id = DB::table('apparatus')->insertGetId([
	                'created_at'            => $row->created_at,
                    'idaparelho_manutencao' => $row->idaparelho_manutencao,
                    'order_id'              => $order->id,
                    'instrument_id'         => optional($instrument)->id,
                    'equipment_id'          => optional($equipment)->id,
                    'defect'                => $row->defeito,
                    'solution'              => $row->solucao,
                    'call_number'           => $row->numero_chamado,

                ]);

                $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
