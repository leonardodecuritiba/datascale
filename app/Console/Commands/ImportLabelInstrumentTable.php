<?php

namespace App\Console\Commands;

use App\Models\Inputs\Instruments\Instrument;
use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\LabelInstrument;
use App\Models\Transactions\Apparatu;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportLabelInstrumentTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:label_instruments';

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
        LabelInstrument::flushEventListeners();
        LabelInstrument::getEventDispatcher();

        $entity = "selo_instrumentos";

        $this->info( '* Import selo_instrumentos' );
        $start = microtime(true);

        $filename = $entity . '.xls';

        $this->info( "*** Iniciando o Upload (" . $entity . ") ***");
        $file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
        set_time_limit(3600);
        $reader = Excel::load($file, function ($sheet) {
            // Loop through all sheets
            $sheet->each(function ($row) {

                $instrument = Instrument::where('idinstrumento', $row->idinstrumento)->first();
                $apparatu_set = Apparatu::where('idaparelho_manutencao', $row->idaparelho_set)->first();
                $apparatu_unset = Apparatu::where('idaparelho_manutencao', $row->idaparelho_unset)->first();
                $label = Label::where('idselo', $row->idselo)->first();


	            $id = DB::table('label_instruments')->insertGetId([
		            'created_at'            => $row->created_at,
		            'idselo_instrumento'    => $row->idselo_instrumento,
		            'instrument_id'         => $instrument->id,
		            'apparatu_set_id'       => optional($apparatu_set)->id,
		            'apparatu_unset_id'     => optional($apparatu_unset)->id,
		            'label_id'              => $label->id,

		            'external'              => $row->external,
		            'set_at'              => $row->afixado_em,
		            'unset_at'            => $row->retirado_em,
//		            'used'                  => $row->external,

	            ]);

                $this->info( "****************** (" . $id . ") ******************");

            });
        })->ignoreEmpty();

        $this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
