@extends('layouts.admin.app')

@section('title', $Page->title)

@section('style_content')

@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layouts.inc.breadcrumb')

@endsection

@section('page_content')
    <!-- Main container -->
    <div class="main-content">


    @include('layouts.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">

            <h4 class="card-title"><strong>Ordem de Serviço #{{$Data->id}}</strong>
                @if($Data->canShowReopenBtn())
                    <a class="btn btn-a btn-warning pull-right"
                       href="{{route('transactions.orders.reopen',$Data->id)}}">
                        <i class="fa fa-refresh fa-2"></i> Reabrir O.S.</a>
                @endif
            </h4>

            <div class="card-body">

                <div class="alert alert-{{$Data->status_color}}" role="alert">
                    Situação: <strong>{{$Data->status_text}}</strong>
                </div>
                

                <h6 class="text-uppercase mt-3">Informações</h6>
                
                
                <hr class="hr-sm mb-2">
                <dl class="row">
                    <dt class="col-sm-2">ID</dt>
                    <dd class="col-sm-4">{{$Data->id}} ({{$Data->idordem_servico}})</dd>

                    <dt class="col-sm-3">Data de Abertura</dt>
                    <dd class="col-sm-3">{{$Data->created_at_full_formatted}}</dd>

                    <dt class="col-sm-2">Cliente</dt>
                    <dd class="col-sm-4"><a href="{{route('clients.edit',$Data->client_id)}}" target="_blank">{{$Data->client->fantasy_name_text}}</a></dd>

                    <dt class="col-sm-3">Data de Finalização</dt>
                    <dd class="col-sm-3">{{$Data->finished_at_full_formatted}}</dd>

                    <dt class="col-sm-2">Colaborador</dt>
                    <dd class="col-sm-4">{{$Data->owner->name}}</dd>

                    <dt class="col-sm-3">Limite Técnica / Comercial</dt>
                    <dd class="col-sm-3">{!! $Data->client->getAvailableLimitCurrencyHtml('technical') !!} / {!! $Data->client->getAvailableLimitCurrencyHtml('commercial') !!}</dd>

                    @if($Data->isClosed())

                        <dt class="col-sm-2">Responsável / Cargo</dt>
                        <dd class="col-sm-4">{{$Data->responsible.' / '.$Data->responsible_position}}</dd>

                        <dt class="col-sm-3">CPF</dt>
                        <dd class="col-sm-3">{{$Data->responsible_cpf}}</dd>

                    @endif

                </dl>

                <h6 class="text-uppercase mt-3">Valores</h6>
                <hr class="hr-sm mb-2">

                @if($Data->isClosed() && ($Data->exemption_cost))
                    <div class="alert alert-danger" role="alert">
                        <span class="fa fa-exclamation-triangle"></span> <strong>Isento de Custos com Deslocamentos</strong>
                    </div>
                @endif

                @include('pages.transactions.technical_operations.orders.list.values', ['values' => $Data->getResumedValuesArray()])

                @if(!$Data->isClosed())

                    <h6 class="text-uppercase mt-3">Fechamento</h6>
                    <hr class="hr-sm mb-2">

                    {!! Form::open(['route' => ['transactions.orders.finish',$Data->id],
                        'method' => 'POST',
                        'data-provide'=> "validation",
                        'data-disable'=>'false']) !!}

                {{-- --}}

                        <div class="alert-exemption_cost alert alert-danger @if(isset($Data) && ($Data->exemption_cost == 0)) hidex @endif" role="alert">
                            <strong><i class="fa fa-exclamation-triangle"></i> Atenção!</strong> Esta O.S. está
                            sendo isentada de custos com Deslocamentos, Pedágios e Outros Custos.
                        </div>

                        {{--RESPONSÁVEL / ISENCAO DE CUSTOS--}}
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                {!! Html::decode(Form::label('responsible', 'Nome Responsável', array('class' => 'col-form-label'))) !!}
                                {{Form::text('responsible', old('responsible',(isset($Data) ? $Data->responsible : "")), ['id'=>'responsible','placeholder'=>'Nome Responsável','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-2">
                                {!! Html::decode(Form::label('exemption_cost', 'Isenção de Custos', array('class' => 'col-form-label'))) !!}
                                <div class="custom-control-lg custom-control custom-checkbox" >
                                    <input type="checkbox" name="exemption_cost" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="exemption_cost">Isentar</label>
                                </div>

                                {{--<input name="exemption_cost" type="checkbox" class="flat"--}}
                                       {{--@if(isset($Data) && ($Data->exemption_cost == 1)) checked="checked" @endif--}}
                                {{-->--}}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('responsible_cpf', 'CPF', array('class' => 'col-form-label'))) !!}
                                {{Form::text('responsible_cpf', old('responsible_cpf',(isset($Data) ? $Data->responsible_cpf : "")), ['id'=>'cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('responsible_position', 'Cargo', array('class' => 'col-form-label'))) !!}
                                {{Form::text('responsible_position', old('responsible_position',(isset($Data) ? $Data->responsible_position : "")), ['id'=>'responsible_position','placeholder'=>'Cargo','class'=>'form-control','minlength'=>'3', 'maxlength'=>'50'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="alert alert-danger" role="alert">
                            <strong><i class="fa fa-exclamation-triangle"></i> Atenção O.S. não
                                Finalizada!</strong>
                            A O.S. somente será aceita pelo Financeiro uma vez que assinada e com situação
                            FINALIZADA.
                            Os canhotos das Marcas de Reparo somente poderão ser fixados em O.S. cuja situação
                            seja FINALIZADA.
                            O descumprimento acarretará em Advertência ao usuário.
                            O mesmo também estará sujeito a arcar com os valores da O.S. em caso de
                            descumprimento.
                        </div>
                        <div class=" pull-right">
                            <button class="btn btn-success btn-lg" type="submit"><i class="fa fa-sign-out fa-2"></i>
                                Finalizar
                            </button>
                        </div>

                    {{Form::close()}}
                @endif
            </div>
            <footer class="card-footer text-right">

                @if($Data->isClosed())
                    <a class="btn btn-a btn-label btn-info" href="{{route('transactions.orders.send', $Data->id)}}"><label><i class="ti-email"></i></label> Encaminhar</a>
                @else
                    <a class="btn btn-label btn-info pull-left" href="{{route('orders.show', $Data->id)}}"><label><i class="ti-back-left"></i></label> Editar</a>
                @endif

                <a class="btn btn-a btn-label btn-brown" href="{{route('transactions.orders.print', $Data->id)}}" target="_blank"><label><i class="ti-printer"></i></label> Imprimir</a>
                <a class="btn btn-a btn-label btn-brown disabled"><label><i class="ti-download"></i></label> Exportar</a>
            </footer>

        </div>

        @foreach($Data->apparatu_equipments as $apparatu)
            <?php $equipment = $apparatu->equipment; ?>
            <div class="card">

                <h3 class="card-title">
                    <strong>Equipamento #{{$equipment->id}}-{{$apparatu->id}}</strong>
                    <small class="sidetitle">Número Chamado: {{$apparatu->call_number}}</small>
                </h3>

                <div class="card-body">

                    <div class="card-content">

                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$equipment->thumb_image}}" alt="..." class="rounded img-fluid">
                            </div>
                            <div class="col-md-5">
                                <ul class="list-unstyled">
                                    <li>Adicionado em: <b>{{$apparatu->created_at_formatted}}</b></li>
                                    <li>Descrição: <b>{{$equipment->description}}</b></li>
                                    <li>Marca: <b>{{$equipment->getBrandName()}}</b></li>
                                    <li>Modelo: <b>{{$equipment->model}}</b></li>
                                    <li>Nº de Série: <b>{{$equipment->serial_number}}</b></li>
                                </ul>
                            </div>
                        </div>

                        <hr class="hr-sm mb-2">

                        @if($apparatu->canShowInputs())

                            <div class="row">
                                <div class="col-121 col-md-6">
                                    <h6 class="fs-18 text-danger">Defeito</h6>
                                    <p>{{$apparatu->defect}}</p>
                                </div>

                                <div class="col-121 col-md-6">
                                    <h6 class="fs-18 text-success">Solução</h6>
                                    <p>{{$apparatu->solution}}</p>
                                </div>
                            </div>

                            <hr class="hr-sm mb-2">

                            @if($apparatu->apparatu_services->count() > 0)

                                <h4>Lista de Serviços</h4>

                                @include('pages.transactions.technical_operations.orders.list.services-resume',['Apparatu_services' => $apparatu->apparatu_services, 'Apparatu' => $apparatu])

                                <hr class="hr-sm mb-2">

                            @endif

                            @if($apparatu->apparatu_parts->count() > 0)

                                <h4>Lista de Peças</h4>

                                @include('pages.transactions.technical_operations.orders.list.parts-resume',['Apparatu_parts' => $apparatu->apparatu_parts, 'Apparatu' => $apparatu])

                            @endif
                        @endif
                    </div>

                </div>

            </div>
        @endforeach


        @foreach($Data->apparatu_instruments as $apparatu)
            <?php $instrument = $apparatu->instrument; ?>
            <div class="card">

                <h3 class="card-title">
                    <strong>Instrumento #{{$instrument->id}}-{{$apparatu->id}}</strong> <small class="sidetitle">Número Chamado: {{$apparatu->call_number}}</small>
                </h3>

                <div class="card-body">

                    <div class="card-content">

                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$instrument->thumb_image}}" alt="..." class="rounded img-fluid">
                            </div>
                            <div class="col-md-5">
                                <ul class="list-unstyled">
                                    <li>Adicionado em: <b>{{$apparatu->created_at_formatted}}</b></li>
                                    <li>Marca / Modelo: <b>{{$instrument->getBrandModel()}}</b></li>
                                    <li>Nº de Série: <b>{{$instrument->serial_number}}</b></li>
                                    <li>Divisão: <b>{{$instrument->getBaseDivision()}}</b></li>
                                    <li>Capacidade: <b>{{$instrument->getBaseCapacity()}}</b></li>
                                    <li>Portaria: <b>{{$instrument->getBaseOrdinance()}}</b></li>
                                </ul>
                            </div>

                            <div class="col-md-5">
                                <ul class="list-unstyled">
                                    <li>Patrimônio: <b>{{$instrument->patrimony}}</b></li>
                                    <li>Inventário: <b>{{$instrument->inventory}}</b></li>
                                    <li>Ano: <b>{{$instrument->year}}</b></li>
                                    <li>IP / Endereço: <b>{{$instrument->address_ip}}</b></li>
                                    <li>Setor: <b>{{$instrument->setor_name}}</b></li>
                                </ul>
                            </div>

                        </div>

                        <hr class="hr-sm mb-2">

                        @include('pages.transactions.technical_operations.orders.inc.labelseals', ['apparatu' => $apparatu])

                        @if($apparatu->canShowInputs())

                            <div class="row">
                                <dt class="col-md-2 fs-14 text-danger">Defeito</dt>
                                <dd class="col-md-4">{{$apparatu->defect}}</dd>
                                <dt class="col-md-2 fs-14 text-success">Solução</dt>
                                <dd class="col-md-4">{{$apparatu->solution}}</dd>
                            </div>

                            <hr class="hr-sm mb-2">

                            <h4>Lista de Serviços</h4>

                            @include('pages.transactions.technical_operations.orders.list.services-resume',['Apparatu_services' => $apparatu->apparatu_services, 'Apparatu' => $apparatu])

                            <hr class="hr-sm mb-2">

                            <h4>Lista de Peças</h4>

                            @include('pages.transactions.technical_operations.orders.list.parts-resume',['Apparatu_parts' => $apparatu->apparatu_parts, 'Apparatu' => $apparatu])


                        @endif

                    </div>
                </div>

            </div>
        @endforeach


    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    <script>
        //ISENÇÃO DE DESLOCAMENTO
        $('input[name="exemption_cost"]').on('change', function (event) {
            var $alert = $(this).parents().find('div.alert-exemption_cost');
            if (this.checked == true){
                $($alert).removeClass('hidex');
            } else {
                $($alert).addClass('hidex');
            }
        });
    </script>

@endsection