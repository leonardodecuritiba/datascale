@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.requestions.patterns.menu.data')

@endsection

@section('page_modals')

    @if(isset($Data))
        {{--VISUALIZAR ANTES DE ADICIONAR VOID--}}
        <div class="modal fade show " id="modal-pattern" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">


                    {{Form::model($Data,
                    array(
                        'route' => ['patterns.attach-pattern', $Data->id],
                        'method'=>'PATCH',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}

                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Adicionar Padrão</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('pattern_id', 'Padrão *', array('class' => 'col-form-label'))) !!}
                                    {{Form::select('pattern_id', $Page->auxiliar['patterns'], "", ['placeholder' => 'Escolha o Padrão', 'class'=>'form-control show-tick', 'required'])}}
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

                    {{Form::close()}}

                </div>
            </div>
        </div>

    @endif

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">

                @if(isset($Data))
                    {{Form::model($Data,
                    array(
                        'route' => ['requestions.patterns.update', $Data->id],
                        'method'=>'PATCH',
                        'files'=>'true',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                @else
                    {{Form::open(array(
                        'route' => ['requestions.patterns.store'],
                        'method'=>'POST',
                        'files'=>'true',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                @endif

                @if(!isset($Data))
                    {{Form::hidden('type',$Page->auxiliar['type'])}}
                    {{Form::hidden('value',$Page->auxiliar['value'])}}
                @endif

                <div class="card-body">
                    <dl class="row">
                        @if(isset($Data))
                            <dt class="col-sm-2">ID</dt>
                            <dd class="col-sm-10">{{$Data->id}}</dd>
                        @endif

                        <dt class="col-sm-2">Tipo</dt>
                        <dd class="col-sm-10">{{isset($Data) ? $Data->type_text : $Page->auxiliar['request_type']}}</dd>

                        <dt class="col-sm-2">Valor</dt>
                        <dd class="col-sm-10">{{isset($Data) ? $Data->value_formatted : $Page->auxiliar['request_value']}}</dd>

                    </dl>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('reason', 'Razão *', array('class' => 'col-form-label'))) !!}
                            {{Form::textarea('reason', ((isset($Data) ? $Data->reason : old('reason'))), ['placeholder'=>'Razão da Requisição','class'=>'form-control', 'minlength'=>'3', 'maxlength'=>'1000', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>

                </div>

                <footer class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">Salvar</button>
                </footer>


                {{Form::close()}}
            </div>

        </div>

        @if(isset($Data))

            <div class="card">
                <h4 class="card-title">Padrões presentes no requerimento
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
                            @foreach($Data->itens_list() as $sel)
                                <tr>
                                    <td id="id">{{$sel['id']}}</td>
                                    <td>{{$sel['model_text']}}</td>
                                    <td>{{$sel['brand_text']}}</td>
                                    <td>{{$sel['feature_text']}}</td>
                                    <td>{{$sel['mass_formatted']}}</td>
                                    <td>{{$sel['void_text']}}</td>
                                    <td>
                                        @include('layouts.inc.buttons.delete',[
                                        'field_delete_route' => route('patterns.detach-pattern',[$sel['request_pattern_id'], $sel['id']])
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
                @include('layouts.inc.loading')
            </div>

        @endif
    </div><!--/.main-content -->

@endsection

@section('script_content')

    @if(isset($Data))

        <!-- Sample data to populate jsGrid demo tables -->
        @include('layouts.inc.datatable.js')

        @include('layouts.inc.sweetalert.js')

    @endif

@endsection

