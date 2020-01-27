<?php

namespace App\Console\Commands;

use App\Models\Inputs\Settings\Seal;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportSealTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:seals';

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
        Seal::flushEventListeners();
        Seal::getEventDispatcher();

        $entity = "lacres";

        $this->info( '* Import lacres' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $user = User::where('idtecnico', $row->idtecnico)->first();

	            $id = DB::table('seals')->insertGetId([
		            'created_at'        => $row->created_at,
		            'idlacre'           => $row->idlacre,
		            'owner_id'          => $user->id,
		            'number'            => $row->numeracao,
		            'external_number'   => $row->numeracao_externa,
		            'extern'            => $row->externo,
		            'used'              => $row->used,

	            ]);

                $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
