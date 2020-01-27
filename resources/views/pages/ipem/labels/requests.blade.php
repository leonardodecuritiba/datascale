@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.ipem.labels.menu.data')

@endsection

@section('style_content')

    @include('layouts.inc.select2.css')

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card" id="card1" style="display: none;">
            <h4 class="card-title"></h4>

            <div class="card-content">
                <div class="card-body">

                    <div class="form-row d-flex justify-content-between">
                        <div class="jumbotron col-md-6 pt-4 pb-4 pl-3">

                            <div class="d-flex flex-column">

                                <div class="text-left mb-2">Requerente: <strong id="requester"></strong></div>
                                <div class="text-left">ID: <strong id="id"></strong></div>
                                <div class="text-left">Status: <strong id="status"></strong></div>
                                <div class="text-left">Data de Requisição: <strong id="created_at"></strong></div>
                                <div class="text-left">Detalhes: <strong id="details"></strong></div>
                                <div class="text-left">Razão: <strong id="reason"></strong></div>

                            </div>

                        </div>

                        {{Form::open(array(
                            'route' => ['labels.tracking.accept'],
                            'method'=>'POST',
                            'class'=>'col-md-6 ',
                            'data-provide'=> "validation",
                            'data-disable'=>'false'
                        )
                        )}}

                            {{ Form::hidden('id','') }}
                            <div id="confirma" style="display: none;">

                                <div class="form-group col-md-12">
                                    {!! Html::decode(Form::label('user_id','Origem* ', array('class' => 'col-form-label'))) !!}
                                    <div class="d-flex justify-content-between">
                                        {{Form::select('user_id', $Page->auxiliar['users'], [] , ['id'=>'user_id','class'=>'form-control show-tick col-md-8','required'])}}
                                        <button type="button" class="btn btn-info btn-search col-md-3">Buscar</button>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-12">
                                    {!! Html::decode(Form::label('values','Valores* ', array('class' => 'col-form-label'))) !!}

                                    <select name="values[]" class="select2_multiple-ajax form-control" multiple tabindex="-1"
                                            placeholder="{{$Page->names}}" required
                                            data-parsley-errors-container="#select-errors"></select>
                                    <div class="invalid-feedback"></div>
                                </div>

                            </div>

                            <div id="nega" style="display: none;">

                                <div class="form-group col-md-12">
                                    {!! Html::decode(Form::label('response','Motivo *', array('class' => 'col-form-label'))) !!}
                                    {{Form::textarea('response', '' , ['id'=>'response','placeholder'=>'Motivo','class'=>'md-textarea form-control','rows'=>'5','cols'=>'100%', 'minlength'=>'3', 'maxlength'=>'500', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>

                            </div>

                            <footer class="card-footer text-right">
                                <button class="btn btn-danger" type="button" id="cancelar">Cancelar</button>
                                <button class="btn btn-primary" type="submit">Confirmar</button>
                            </footer>

                        {{Form::close()}}

                    </div>

                </div>
            </div>
        </div>


        <div class="card" style="display: none;" id="card2">
            <h4 class="card-title"><strong>{{$Page->names}}</strong> Disponíveis</h4>

            <div class="card-content">
                <div class="card-body values">
                </div>
            </div>
            @include('layouts.inc.loading')

        </div>

        <div class="card" id="tabela">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> Registros</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered table-responsive table-responsive-sm"
                           cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Requerente</th>
                            <th>Gestor</th>
                            <th>Detalhes</th>
                            <th>Valores</th>
                            <th>Razão</th>
                            <th>Retorno</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Requerente</th>
                            <th>Gestor</th>
                            <th>Detalhes</th>
                            <th>Valores</th>
                            <th>Razão</th>
                            <th>Retorno</th>
                            <th>Ação</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td id="id">{{$sel['id']}}</td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>
                                    <span class="badge badge-sm badge-{{$sel['status_color']}}">{{$sel['status_text']}}</span>
                                </td>
                                <td>{{$sel['requester_text']}}</td>
                                <td>{{$sel['manager_text']}}</td>
                                <td>{{$sel['details_text']}}</td>
                                <td>@foreach($sel['values'] as $value) <span
                                            class="badge badge-sm badge-info">{{$value}}</span> @endforeach</td>
                                <td>{{$sel['reason']}}</td>
                                <td>{{$sel['response']}}</td>
                                <td>
                                    @if($sel['can_show_deny_btn'])
                                        <button data-id="{{$sel['id']}}"
                                                class="btn btn-square btn-outline btn-danger negar"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Negar"><i
                                                    class="fa fa-minus-circle"></i></button>

                                    @endif
                                    @if($sel['can_show_acept_btn'])
                                        <button data-id="{{$sel['id']}}"
                                                data-quantity="{{$sel['quantity']}}"
                                                class="btn btn-square btn-outline btn-success confirmar"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Aceitar"><i
                                                    class="fa fa-plus-circle"></i></button>
                                    @endif
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


@section('script_content')

    <!-- Select2 -->
    @include('layouts.inc.select2.js')
    <!-- /Select2 -->

    <script>
        var TITLE = '{{$Page->names}}';
        var URL_DENY = '{{route('labels.tracking.deny')}}';
        var URL_ACEPT = '{{route('labels.tracking.accept')}}';

        function fillData($data){
            var $parent = $('#card1').find('div.jumbotron');
            $($parent).find('strong#requester').html($data[3].innerHTML);
            $($parent).find('strong#id').html($data[0].innerHTML);
            $($parent).find('strong#created_at').html($data[1].innerHTML);
            $($parent).find('strong#status').html($data[2].innerHTML);
            $($parent).find('strong#details').html($data[5].innerHTML);
            $($parent).find('strong#reason').html($data[7].innerHTML);
        }

        var $_SELECT2_MULTIPLE_ = "select[name='values[]']";
        var remoteDataConfigSelos = {
            width: 'resolve',
            maximumSelectionLength: 3,
            minimumInputLength: 1,
//            allowClear: true,
            language: "pt-BR"
//                templateResult: formatState
        };

        function selectBtn($this){
            $($this).data('value',1);
            $($this).removeClass('btn-default');
            $($this).addClass('btn-success');
        }

        function unselectBtn($this){
            $($this).data('value',0);
            $($this).removeClass('btn-success');
            $($this).addClass('btn-default')
        }

        function removeOption(_data){
            if ($($_SELECT2_MULTIPLE_).find("option[value='" + _data.id + "']").length) {
                $($_SELECT2_MULTIPLE_).find(" option[value='" + _data.id + "']").remove().trigger('change');
                var values = $($_SELECT2_MULTIPLE_).val();
                if(values.length > 1){
                    values = values.sort();
                }
                $($_SELECT2_MULTIPLE_).val(values).trigger('change');
            }
        }

        function addOption(_data){
            var newOption = new Option(_data.text, _data.id, false, false);
            $($_SELECT2_MULTIPLE_).append(newOption);
            var values = $($_SELECT2_MULTIPLE_).val();
            if(values == null) {
                values = _data.id;
            } else {
                values.push(_data.id);
                values = values.sort();
            }
            $($_SELECT2_MULTIPLE_).val(values).trigger('change');

            console.log(values);
        }

        function acceptBtn($this){
            var val = $($this).data('value');
            var _data = {};
            _data.id = $($this).data('id');
            _data.text = $($this).html();
            if(val == "1"){
                unselectBtn($this);
                removeOption(_data);
            } else {
                selectBtn($this)
                addOption(_data);
            }
        }

        $($_SELECT2_MULTIPLE_).on('select2:unselect', function (e) {
            var _data = {};
            _data.id = e.params.data.id;
            _data.text = e.params.data.text;
            var $this = $('div.values').find('button[data-id=' + e.params.data.id + ']');
            unselectBtn($this);
            removeOption(_data);
        });

        $($_SELECT2_MULTIPLE_).on('select2:select', function (e) {
            var _data = {};
            _data.id = e.params.data.id;
            _data.text = e.params.data.text;
            var $this = $('div.values').find('button[data-id=' + e.params.data.id + ']');
            selectBtn($this);
            addOption(_data);
        });

        $(document).ready(function () {

            $($_SELECT2_MULTIPLE_).select2(remoteDataConfigSelos);

            $(".btn-search").click(function () {
                var origin = $(this).prev().find(":selected");
                //fazer busca
                $('div.values').empty();
                $.ajax({
                    url: "{{route('ajax.get.available-labels')}}",
                    type: 'get',
                    data: {"user_id": origin.val()},
                    dataType: "json",

                    beforeSend: function () {
                        loadingCard('show',$('div#card2').find('div.card-content'));
                    },
                    complete: function (xhr, textStatus) {
                        loadingCard('hide',$('div#card2').find('div.card-content'));
                    },
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    success: function (json) {
                        console.log(json);
                        if (json!=null) {
                            var values = $($_SELECT2_MULTIPLE_).val();
                            $(json).each(function(i,v){
                                if($.inArray(v.id.toString(), values) > -1){
                                    $('div.values')
                                        .append('<button class="btn btn-xs btn-primary" onclick="acceptBtn(this)" data-value="1" data-id="' + v.id + '">' + v.text + '</button> ');
                                } else {
                                    $('div.values')
                                        .append('<button class="btn btn-xs btn-default" onclick="acceptBtn(this)" data-value="0" data-id="' + v.id + '">' + v.text + '</button> ');
                                }
                            })
                        } else {
                            $('div.values')
                                .append('<p class="text-danger">{{$Page->names}} não encontrados. Selecione outra Origem!</p>');
                        }
                    }
                });

            });

            $('table tbody').find('.negar').bind('click', function () {

                var table_title = 'Negar requisição de ' + TITLE;
                $('#card1').show();
                $('#card1').find('h4.card-title').html(table_title);

                var $form = $('#card1').find('form');
                $($form).find('input[name=id]').val($(this).data('id'));
                $($form).attr('action',URL_DENY);
                $($form).find('select[name="values[]"], select[name=user_id]').attr('required',false);
                $($form).find('textarea[name=response]').attr('required',true);
                $($form).find('select[name=user_id], select[name="values[]"]').val(null).trigger("change");

                var data = $(this).closest('tr').find('td');
                fillData(data);



                $('#card2').find('div.values').empty();
                $('#card2').hide();
                $('#confirma').hide();
                $('#nega').show();
                $('.card#tabela').hide();

            });

            $('table tbody').find('.confirmar').bind('click', function () {
                var table_title = 'Confirmar requisição de ' + TITLE;
                $('#card1, #card2').show();
                $('#card1').find('h4.card-title').html(table_title);

                var $form = $('#card1').find('form');
                $($form).find('input[name=id]').val($(this).data('id'));
                $($form).attr('action',URL_ACEPT);
                $($form).find('select[name="values[]"], select[name=user_id]').attr('required',true);
                $($form).find('textarea[name=response]').attr('required',false);

                var data = $(this).closest('tr').find('td');

                remoteDataConfigSelos.maximumSelectionLength = $(this).data('quantity');
                $($_SELECT2_MULTIPLE_).select2(remoteDataConfigSelos);

                fillData(data);

                $('#nega').hide();
                $('#confirma').show();
                $('.card#tabela').hide();
            });

            $('#cancelar').bind('click', function () {
                $('#card1').hide();
                var $form = $('#card1').find('form');
                $($form).find('select[name="values[]"], select[name=user_id],textarea[name=response]').attr('required',false);
                $($form).find('select[name=user_id], select[name="values[]"]').val(null).trigger("change");


                $('#card2').find('div.values').empty();
                $('#card2').hide();
                $('#confirma').hide();
                $('#nega').hide();
                $('.card#tabela').show();
            });

        });

    </script>

@endsection