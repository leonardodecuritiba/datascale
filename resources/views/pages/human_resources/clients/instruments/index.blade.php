<!-- Main container -->
<div id="main-content_instruments">

    <div id="modal-instrument" class="modal fade">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">
                {{Form::open(array(
                    'route' => ['equipments.store'],
                    'method'=>'POST',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
                    {{Form::hidden('id',0)}}

                    <div class="modal-header">
                        <h5 class="modal-title">Dados do Equipamento</h5>

                        <button class="close" data-dismiss="modal"><span>&times;</span></button>

                    </div>

                    <div class="modal-body">


                        <div class="row">
                            <div class="col">
                                <div class="img-thumbnail d-flex justify-content-center w-100" id="image-div"><img
                                            id="image" src="" class="rounded img-fluid hidex"
                                            style="max-width: 325px; max-height: 325px;"></div>
                            </div>
                        </div>
                        

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('pam_id', 'Base *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('pam_id', $Page->auxiliar['pams'], [] , ['id'=>'pam_id','placeholder'=>'Escolha um Instumento Base','class'=>'form-control select2_single','required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('instrument_setor_id', 'Setor *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('instrument_setor_id', $Page->auxiliar['instrument_setors'], [] , ['id'=>'instrument_setor_id','placeholder'=>'Escolha um Setor','class'=>'form-control select2_single','required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">


                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('serial_number', 'Modelo *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('serial_number', '', ['id'=>'serial_number','placeholder'=>'Nº Série','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}


                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('year', 'Ano *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('year', '', ['id'=>'year','placeholder'=>'Ano','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}


                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">


                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('inventory', 'Inventário *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('inventory', '', ['id'=>'inventory','placeholder'=>'Inventário','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('patrimony', 'Patrimônio *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('patrimony', '', ['id'=>'patrimony','placeholder'=>'Patrimônio','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>


                        <div class="form-row">


                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('ip', 'IP *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('ip', '', ['id'=>'ip','placeholder'=>'IP','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('address', 'Endereço *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('address', '', ['id'=>'address','placeholder'=>'Endereço','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>
                        
                        


                        <div class="form-row no-gutters" data-provide="photoswipe">

                            <div class="form-group col-md-6">
                                <div class="img-thumbnail d-flex justify-content-center w-100"
                                     id="label_inventory_image-div"><img id="label_inventory_image" src=""
                                                                         class="rounded img-fluid hidex cursor-pointer"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="img-thumbnail d-flex justify-content-center w-100"
                                     id="label_identification_image-div"><img id="label_identification_image" src=""
                                                                             class="rounded img-fluid hidex cursor-pointer"></div>
                            </div>

                        </div>
                        
                        
                   

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('label', 'Etiqueta de Inventário <i class="fa fa-question-circle"
                                    data-provide="tooltip"
                                    data-placement="right"
                                    data-tooltip-color="primary"
                                    data-original-title="'.config('system.pictures.message').'"></i>', array('class' => 'col-form-label'))) !!}
                                <input name="label_inventory" type="file" data-provide="dropify">
                            </div>


                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('label', 'Etiqueta de Identificação <i class="fa fa-question-circle"
                                    data-provide="tooltip"
                                    data-placement="right"
                                    data-tooltip-color="primary"
                                    data-original-title="'.config('system.pictures.message').'"></i>', array('class' => 'col-form-label'))) !!}
                                <input name="label_identification" type="file" data-provide="dropify">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success">Salvar</button>

                    </div>

                {{Form::close()}}

            </div>

            @include('layouts.inc.loading')

        </div>


    </div>

    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Zero configuration
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <button type="button" id="create_button_instrument" class="btn btn-outline btn-purple col-lg-4 offset-lg-8"
            data-toggle="modal" data-target="#modal-instrument">
        {{trans('pages.view.CREATE', [ 'name' => 'Instrumento' ])}}
    </button>
    
    

    <div class="card">
        <h4 class="card-title"><strong>{{count($instruments)}}</strong> Registros</h4>

        <div class="card-content">
            <div class="card-body">

                <table class="table table-striped table-bordered table-responsive-lg" cellspacing="0" data-provide="datatables">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                        <th>Serie</th>
                        <th>Inventário</th>
                        <th>Selo</th>
                        <th>Lacres</th>
                        <th>Ações</th>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                        <th>Serie</th>
                        <th>Inventário</th>
                        <th>Selo</th>
                        <th>Lacres</th>
                        <th>Ações</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($instruments as $sel)
                        <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                            <td>{{$sel['id']}}</td>
                            <td><img class="avatar avatar-lg" src="{{$sel['image']}}"></td>
                            <td>
                                <span class="badge badge-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                            </td>
                            <td>{{$sel['name']}}</td>
                            <td>{{$sel['serial_number']}}</td>
                            <td>{{$sel['inventory']}}</td>
                            <td>{{ !is_null($sel['label']) ? $sel['label']['text'] : 'Sem Interveção'}}</td>
                            <td>{{ !is_null($sel['seals']) ? $sel['seals']['text'] : 'Sem Interveção'}}</td>
                            <td>
                                @include('layouts.inc.buttons.active',['active'=>$sel['active']])

                                <button class="btn btn-square btn-xs btn-outline btn-info"
                                   data-toggle="modal"
                                   data-target="#modal-instrument"
                                   data-type="edit"
                                   data-id="{{$sel['id']}}"
                                ><i class="fa fa-edit"></i>
                                </button>
                                @include('layouts.inc.buttons.delete',['field_delete_route' => '/ajax/settings/instruments/'.$sel['id'],'field_delete'=>'Instrument'])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div><!--/.main-content -->
