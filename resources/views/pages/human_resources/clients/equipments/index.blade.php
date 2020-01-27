<!-- Main container -->
<div id="main-content_equipments">

    <div id="modal-equipment" class="modal fade show">

        <div class="modal-dialog modal-lg">

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
                                <div class=" img-thumbnail d-flex justify-content-center w-100" id="image-div"> <img id="image" src="" class="rounded img-fluid" style="max-width: 325px; max-height: 325px;"> </div>
                            </div>
                        </div>

                        <div class="form-row">



                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('description', '', ['id'=>'description','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('brand_id', 'Marca *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('brand_id', $Page->auxiliar['brands'], [] , ['id'=>'brand_id','placeholder'=>'Escolha uma marca','class'=>'form-control select2_single','required'])}}

                                <div class="invalid-feedback"></div>
                            </div>


                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('serial_number', 'Número de Série *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('serial_number', '', ['id'=>'serial_number','placeholder'=>'Número de Série','class'=>'form-control select2_single', 'required'])}}

                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('model', 'Modelo *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('model', '', ['id'=>'model','placeholder'=>'Modelo','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('picture', 'Foto <i class="fa fa-question-circle"
                                    data-provide="tooltip"
                                    data-placement="right"
                                    data-tooltip-color="primary"
                                    data-original-title="'.config('system.pictures.message').'"></i>', array('class' => 'col-form-label'))) !!}
                                <input name="picture" type="file" data-provide="dropify">

                            </div>

                        </div>
                    </div>

                    @include('layouts.inc.loading')

                    <div class="modal-footer">

                        <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit">Salvar</button>

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

    <button type="button" id="create_button_equipments" class="btn btn-outline btn-purple col-lg-4 offset-lg-8"
            data-toggle="modal" data-target="#modal-equipment">
        {{trans('pages.view.CREATE', [ 'name' => 'Equipamento' ])}}
    </button>

    <div class="card">
        <h4 class="card-title"><strong>{{count($equipments)}}</strong> Registros</h4>

        <div class="card-content">
            <div class="card-body">

                <table class="table table-striped table-bordered table-responsive-lg" cellspacing="0" data-provide="datatables">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Série</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Série</th>
                        <th>Ações</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($equipments as $sel)
                        <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                            <td>{{$sel['id']}}</td>
                            <td><img class="avatar avatar-lg" src="{{$sel['image']}}"></td>
                            <td>
                                <span class="badge badge-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                            </td>
                            <td>{{$sel['name']}}</td>
                            <td>{{$sel['brand']}}</td>
                            <td>{{$sel['model']}}</td>
                            <td>{{$sel['serial_number']}}</td>
                            <td>
                                @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                <a class="btn btn-square btn-xs btn-outline btn-info"
                                   data-toggle="modal"
                                   data-target="#modal-equipment"
                                   data-type="edit"
                                   data-id="{{$sel['id']}}"
                                ><i class="fa fa-edit"></i>
                                </a>
                                @include('layouts.inc.buttons.delete',['field_delete_route' => '/ajax/settings/equipments/'.$sel['id'],'field_delete'=>'Equipment'])
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div><!--/.main-content -->
