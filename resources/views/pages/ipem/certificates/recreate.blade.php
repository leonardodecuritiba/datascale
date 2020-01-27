@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.ipem.certificates.menu.data')

@endsection

@section('page_modals')

    {{--VISUALIZAR ANTES DE ADICIONAR VOID--}}
    <div class="modal fade show " id="modal-pattern" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Adicionar Padrão</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('model_id', 'Modelo *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('model_id', $Page->auxiliar['models'], "", ['placeholder' => 'Escolha o Modelo', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('brand_id', 'Marca *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('brand_id', $Page->auxiliar['brands'], "", ['placeholder' => 'Escolha a Marca', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('mass_id', 'Massa *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('mass_id', $Page->auxiliar['masses'], "", ['placeholder' => 'Escolha a Massa', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Html::decode(Form::label('feature_id', 'Carcaterísticas *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('feature_id', $Page->auxiliar['features'], "", ['placeholder' => 'Escolha a Carcaterística', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('void_id', 'Etiqueta *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('void_id', $Page->auxiliar['voids'], "", ['placeholder' => 'Escolha a Etiqueta', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Selecionar
                    </button>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">
                {{Form::open(array(
                    //'route' => ['patterns.store'],
                    'method'=>'GET',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}

                <div class="card-body">


                    <div class="form-row">

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('number', 'Número do Certificado *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('number', '', ['placeholder'=>'Número do Certificado','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('date_begin', 'Data de Verificação *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('date_begin', '', ['placeholder'=>'Data de Validade','class'=>'form-control','data-provide'=>'datepicker', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('date_end', 'Data de Validade *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('date_end', '', ['placeholder'=>'Data de Validade','class'=>'form-control','data-provide'=>'datepicker', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('certify', 'PDF do certificado original <i class="fa fa-question-circle"
                                data-provide="tooltip"
                                data-placement="right"
                                data-tooltip-color="primary"
                                data-original-title="'.config('system.pdfs.message').'"></i>', array('class' => 'col-form-label'))) !!}
                            <input name="certify" type="file" data-provide="dropify">

                        </div>

                    </div>


                </div>

                <footer class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">Salvar</button>
                </footer>


                {{Form::close()}}
            </div>

        </div>

        <div class="card">
            <h4 class="card-title">Padroes presentes no certificado acima
                <button class="btn btn-info pull-right"
                        type="button"
                        data-toggle="modal" data-target="#modal-pattern">Adicionar
                </button>
            </h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-skin table-bordered table-responsive-lg"
                           cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Caracteristica</th>
                            <th>Massa</th>
                            <th>Etiqueta</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Caracteristica</th>
                            <th>Massa</th>
                            <th>Etiqueta</th>
                            <th>Ação</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td id="id">{{$sel['id']}}</td>
                                <td>{{$sel['model_text']}}</td>
                                <td>{{$sel['brand_text']}}</td>
                                <td>{{$sel['feature_text']}}</td>
                                <td>{{$sel['mass_text']}}</td>
                                <td>{{$sel['void_text']}}</td>
                                <td>
                                    <button class="btn btn-square btn-xs btn-outline btn-danger"
                                            type="button"><i class="fa fa-trash"></i></button>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
            @include('layouts.inc.loading')
        </div>
    </div><!--/.main-content -->

@endsection

