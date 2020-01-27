<?php

namespace App\Console\Commands;

use App\Models\Inputs\Settings\Label;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportLabelTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:Labels';

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
        Label::flushEventListeners();
        Label::getEventDispatcher();

        $entity = "selos";

        $this->info( '* Import selos' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $user = User::where('idtecnico', $row->idtecnico)->first();

	            $id = DB::table('labels')->insertGetId([
		            'created_at'        => $row->created_at,
		            'idselo'            => $row->idselo,
		            'owner_id'          => $user->id,
		            'number'            => $row->numeracao,
		            'external_number'   => $row->numeracao_externa,
		            'extern'            => $row->externo,
		            'used'              => $row->used,
		            'declared_at'       => $row->declared,

	            ]);

                $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
