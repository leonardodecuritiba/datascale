@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('style_content')

    <!-- Select2 -->
    @include('layouts.inc.select2.css')

@endsection

@section('page_header-nav')

    @include('pages.ipem.certificates.menu.data')

@endsection

@if(isset($Data))

@section('page_modals')

    {{--VISUALIZAR ANTES DE ADICIONAR VOID--}}
    <div class="modal fade show " id="modal-pattern">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Adicionar Padrão</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                {{Form::model($Data,
                array(
                    'route' => ['certificates.attach-pattern', $Data->id],
                    'method'=>'PATCH',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}

                {{Form::hidden('voids', '')}}
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
                                {!! Html::decode(Form::label('feature_id', 'Carcaterísticas *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('feature_id', $Page->auxiliar['features'], "", ['placeholder' => 'Escolha a Carcaterística', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('quantity', 'Quantidade', array('class' => 'col-form-label'))) !!}
                                {{Form::text('quantity', 1, ['placeholder'=>'Quantidade *','class'=>'form-control show-int', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('mass', 'Massa (g)*', array('class' => 'col-form-label'))) !!}
                                {{Form::text('mass', '', ['placeholder'=>'Massa *','class'=>'form-control show-int', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Html::decode(Form::label('total', 'Total (Kg)', array('class' => 'col-form-label'))) !!}
                                {{Form::text('total', '', ['class'=>'form-control', 'disabled'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <button id="search-void" class="btn btn-label btn-default btn-block" type="button"><i
                                        class="ti-search"></i> Buscar Etiquetas
                            </button>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12 valores p-4">

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

@endsection

@endif

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">

                @if(isset($Data))
                    {{Form::model($Data,
                    array(
                        'route' => ['certificates.update', $Data->id],
                        'method'=>'PATCH',
                        'files'=>'true',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                @else
                    {{Form::open(array(
                        'route' => ['certificates.store'],
                        'method'=>'POST',
                        'files'=>'true',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                @endif

                <div class="card-body">


                    <div class="form-row">

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('number', 'Número do Certificado *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('number', ((isset($Data) ? $Data->number : old('number'))), ['placeholder'=>'Número do Certificado','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'50', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('verified_at', 'Data de Verificação *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('verified_at', ((isset($Data) ? $Data->verified_at_formatted : old('verified_at'))), ['placeholder'=>'Data de Validade','class'=>'form-control','data-provide'=>'datepicker', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-4">
                            {!! Html::decode(Form::label('due_at', 'Data de Validade *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('due_at', ((isset($Data) ? $Data->due_at_formatted : old('due_at'))), ['placeholder'=>'Data de Validade','class'=>'form-control','data-provide'=>'datepicker', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>

                    {{--Pdf--}}
                    @include('layouts.part.pdf')

                </div>

                <footer class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">Salvar</button>
                </footer>


                {{Form::close()}}
            </div>

        </div>

        @if(isset($Data))
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
                            @foreach($Data->certificate_patterns_list() as $sel)
                                <tr>
                                    <td id="id">{{$sel['id']}}</td>
                                    <td>{{$sel['model_text']}}</td>
                                    <td>{{$sel['brand_text']}}</td>
                                    <td>{{$sel['feature_text']}}</td>
                                    <td>{{$sel['mass_formatted']}}</td>
                                    <td>{{$sel['void_text']}}</td>
                                    <td>
                                        @include('layouts.inc.buttons.delete',[
                                        'field_delete_route' => route('certificates.detach-pattern',[$sel['certificate_id'], $sel['id']])
                                        ])

                                        {{--<button data-href="{{(isset($field_delete_route) ? $field_delete_route : route($Page->entity.'.destroy',$sel['id']))}}"--}}
                                        {{--data-refresh="{{(isset($refresh) ? $refresh : 0)}}"--}}
                                        {{--data-alert="{{(isset($alert) ? $alert : 1)}}"--}}
                                        {{--class="btn btn-square btn-xs btn-outline btn-danger"--}}
                                        {{--onclick="showDeleteTableMessage(this)"--}}
                                        {{--type="button"--}}
                                        {{--data-entity="{{(isset($field_delete) ? $field_delete : $Page->name).': '.$sel['name']}}"><i--}}
                                        {{--class="fa fa-trash"></i></button>--}}

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

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    @include('layouts.inc.select2.js')

    <script>
        var $_TOTAL_SELECTED_ = 0;

        $(document).ready(function () {
            $('input[name=mass],input[name=quantity]').keyup(function () {
                var value = $('input[name=mass]').val();
                var qtd = $('input[name=quantity]').val();
                if ($('input[name=quantity]').val() != "") {
                    $('input[name=total]').val((($('input[name=quantity]').val() * value / 1000)) + 'Kg')
                    $.each($('div.valores').find('button[data-value=1]'), function (i, v) {
                        _unselectBtn(v);
                    });
                    $_TOTAL_SELECTED_ = 0;
                }
            });
        })
    </script>

    <script>

        function _unselectBtn($this) {
            $($this).attr('data-value', 0);
            $($this).removeClass('btn-success');
            $($this).addClass('btn-default');
            //remover no void hidden
            if ($('input[name=voids]').val() != "") {
                var voids = JSON.parse($('input[name=voids]').val());
                var index = voids.indexOf($($this).attr('data-id'));
                if (index > -1) {
                    voids.splice(index, 1);
                }

                $('input[name=voids]').val("");
                if (voids.length > 0) {
                    $('input[name=voids]').val(JSON.stringify(voids));
                }
            }

            $_TOTAL_SELECTED_--;
        }

        function _selectBtn($this) {
            $($this).attr('data-value', 1);
            $($this).removeClass('btn-default');
            $($this).addClass('btn-success');
            //adicionar no void hidden
            if ($('input[name=voids]').val() != "") {
                var voids = JSON.parse($('input[name=voids]').val());
            } else {
                voids = [];
            }
            voids.push($($this).attr('data-id'));
            $('input[name=voids]').val(JSON.stringify(voids));

            $_TOTAL_SELECTED_++;
        }

        function _acceptBtn($this) {

            var val = $($this).attr('data-value');
            if (val == "1") {
                _unselectBtn($this);
            } else {
                if ($_TOTAL_SELECTED_ < $('input[name=quantity]').val()) {
                    _selectBtn($this)
                }
            }
        }

        $(document).ready(function () {

            $('button#search-void').click(function (e) {
                //fazer busca
                $('div.valores').empty();
                if ($('input[name=quantity]').val() != "") {
                    $_TOTAL_SELECTED_ = 0;
                    $('input[name=voids]').val("");
                    $.ajax({
                        url: "{{route('ajax.get.available-voids')}}",
                        type: 'get',
                        dataType: "json",

                        beforeSend: function () {
                            $($_LOADING_).show();
                        },
                        complete: function (xhr, textStatus) {
                            $($_LOADING_).hide();
                        },
                        error: function (xhr, textStatus) {
                            console.log('xhr-error: ' + xhr);
                            console.log('textStatus-error: ' + textStatus);
                        },
                        success: function (json) {
                            console.log(json);
                            if (json != null) {

                                var values = [];
                                var btn = "";
                                $(json).each(function (i, v) {
                                    if ($.inArray(v.id.toString(), values) > -1) {
                                        btn = '<button type="button" data-value="1" onclick="_acceptBtn(this)" data-id="' + v.id + '" class="btn btn-xs m-1 btn-success">' + v.text + '</button>';
                                    } else {
                                        btn = '<button type="button" data-value="0" onclick="_acceptBtn(this)" data-id="' + v.id + '" class="btn btn-xs m-1 btn-default">' + v.text + '</button>';
                                    }
                                    $('div.valores').append(btn);
                                })
                            } else {
                                $('div.valores').append('<div class="row jumbotron"><h1>Ops!</h1><h2>Etiquetas não disponíveis!</h2></div>');
                            }
                        }
                    });

                }


            });

        })
    </script>
@endsection
