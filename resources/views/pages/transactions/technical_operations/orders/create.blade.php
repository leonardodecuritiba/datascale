@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link" href="{{route('orders.index')}}">LISTAR ORDEM SERVIÇO</a>
    <a class="nav-link active" href="{{route('orders.create')}}" href="#">ABRIR ORDEM SERVIÇO</a>
    <a class="nav-link" href="#">ABRIR ORÇAMENTO O.S</a>
    <a class="nav-link" href="#">LISTAR ORÇAMENTO O.S</a>
    <a class="nav-link" href="#">FATURAMENTO DIRETO</a>

@endsection

@section('page_modals')

    {{--VISUALIZAR ANTES DE ADICIONAR--}}
    <div class="modal fade show " id="modal-client" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {!! Form::open(['route' => ['transactions.orders.open'],
                    'method' => 'POST',
                    'data-provide'=> "validation",
                    'data-disable'=>'false']) !!}
                {{Form::hidden('client_id', NULL)}}

                    <div class="modal-header">
                        <h4 class="modal-title">Abrir Ordem de Serviço</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('pages.human_resources.clients.modal.show')
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                        <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Confirmar</button>
                    </div>


                {{Form::close()}}
            </div>
        </div>
    </div>

@endsection




@section('page_content')
    <!-- Main container -->

    <div class="main-content">

        @include('layouts.inc.alerts')
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Filter row
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            <header class="card-header">
                <h4 class="card-title">Filtros</h4>
                <ul class="card-controls">
                    <li><a class="card-btn-slide" href="#"></a></li>
                </ul>
            </header>

            <div class="card-content">
                <div class="card-body">

                    {!! Form::open(['route' => 'orders.create',
                        'method' => 'GET']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            {{Form::text('client_id', old('client_id', Request::get('client_id')), ['placeholder'=>'ID do Cliente','class'=>'form-control', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <button class="btn btn-info" type="submit" name="search_id"><i class="ti-search"></i> Buscar apenas por ID</button>
                        </div>
                    </div>
                    {{ Form::close() }}

                    <hr class="hr-sm mb-2">

                    {!! Form::open(['route' => 'orders.create',
                        'method' => 'GET']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('description', 'Buscar Cliente', array('class' => 'col-form-label'))) !!}
                                {{Form::text('description', old('description',Request::get('description')), ['placeholder'=>'Buscar Cliente','class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> Registros</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Situação</th>
                            <th>Cadastrado</th>
                            <th>Fantasia</th>
                            <th>Razão Social</th>
                            <th>CPF/CNPJ</th>
                            <th>Nome Responsável</th>
                            <th>Fone</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Situação</th>
                            <th>Cadastrado</th>
                            <th>Fantasia</th>
                            <th>Razão Social</th>
                            <th>CPF/CNPJ</th>
                            <th>Nome Responsável</th>
                            <th>Fone</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                                <td>{{$sel['id']}}</td>
                                <td><img class="avatar avatar-lg" src="{{$sel['image']}}"></td>
                                <td>
                                    <span class="badge badge-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['fantasy_name_text']}}</td>
                                <td>{{$sel['social_reason_text']}}</td>
                                <td>{{$sel['short_document']}}</td>
                                <td>{{$sel['responsible_name']}}</td>
                                <td>{{$sel['phone']}}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal-client" data-href="{{route('ajax.clients.show', $sel['id'])}}"
                                       class="btn btn-simple btn-info btn-xs btn-icon"
                                    ><i class="material-icons">remove_red_eye</i>
                                    </button>
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
    @include('layouts.inc.active.js')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

    @include('layouts.inc.sweetalert.js')

    <script>


        // MODAL CLIENT
        $(document).ready(function(){
            $("div#modal-client").on("show.bs.modal", function (event) {

                var $button = $(event.relatedTarget);
                var $parent = $(this).find('div.modal-body');
                loadingCard('show',$($parent).find('div.row'));
                
             

                $.ajax({
                    url: $($button).data('href'),
                    type: 'GET',
                    dataType: "json",
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    success: function (result) {
                        console.log(result);
                        loadingCard('hide',$($parent).find('div.row'));


                        //preencher o modal do cliente
                        var $form = $($parent).parent();
                        $($form).find('input[name=client_id]').val(result.id);

                        $($parent).find('#image').attr('src',result.image );
                        $($parent).find('#fantasy_name')
                            .html(result.fantasy_name)
                            .attr('href',result.url);

                        $($parent).find('b#short_document').html( result.short_document );
                        $($parent).find('b#address').html( result.address );
                        $($parent).find('b#phones').html( result.phones );
                        $($parent).find('b#email').html( result.email );

                        $($parent).find('b#technical_limit').html( result.technical_limit_formatted );
                        $($parent).find('b#technical_limit').removeClass('text-danger').removeClass('text-success');
                        if(result.technical_limit > 0){
                            $($parent).find('b#technical_limit').addClass('text-success');
                        } else {
                            $($parent).find('b#technical_limit').addClass('text-danger');
                        }

                        $($parent).find('b#commercial_limit').html( result.commercial_limit_formatted );
                        $($parent).find('b#commercial_limit').removeClass('text-danger').removeClass('text-success');
                        if(result.commercial_limit > 0){
                            $($parent).find('b#commercial_limit').addClass('text-success');
                        } else {
                            $($parent).find('b#commercial_limit').addClass('text-danger');
                        }


                    }
                });


            });
        });

    </script>
@endsection