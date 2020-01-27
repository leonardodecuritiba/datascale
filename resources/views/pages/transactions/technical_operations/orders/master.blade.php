@extends('layouts.admin.app')

@section('title', $Page->title)

@section('style_content')

    <!-- Select2 -->
    @include('layouts.inc.select2.css')


@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layouts.inc.breadcrumb')

@endsection

@section('page_modals')
    <div class="modal fade in bg-danger" id="modal-delete-alert" tabindex="-2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Atenção! Deseja remover a Ordem de Serviço?</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body"><h5>Você realmente deseja remover Ordem de Serviço #1979 e suas relações? Esta ação é irreversível!</h5></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>

                    {!! Form::open(['method' => 'DELETE','route'=>['orders.destroy',$Data->id]]) !!}
                        <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Continuar</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    {{--VALORES DA ORDEM DE SERVIÇO--}}
    <div class="modal fade show " id="modal-orders-values" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Ordem de Serviço #{{$Data->id}} - {{$Data->status_text}}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-content">

                        @include('pages.transactions.technical_operations.orders.list.values', ['values' => NULL])

                    </div>

                    @include('layouts.inc.loading')
                </div>
              
                <div class="modal-footer">
                    @if($Data->canShowDeleteBtn())
                        <button class="btn btn-label btn-danger" data-toggle="modal" data-target="#modal-delete-alert"><label><i class="ti-trash"></i></label> Remover O.S.</button>
                    @endif
                    
                    
                    <button class="btn btn-label btn-warning"  data-toggle="modal" data-target="#modal-client" data-href="{{route('ajax.clients.show', $Data->client_id)}}"><label><i class="ti-search"></i></label> Consultar Cliente</button>
                    
                    <a class="btn-a btn btn-label btn-primary" href="{{route('transactions.orders.resume', $Data->id)}}"><label><i class="ti-check"></i></label> Finalizar O.S.</a>
                    <button class="btn  btn-secondary" data-dismiss="modal"> Fechar</button>
                </div>
            
            </div>
        </div>
    </div>


    
    

    



    {{--CLIENTE--}}
    <div class="modal fade show " id="modal-client" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Visualizar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('pages.human_resources.clients.modal.show')
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Fechar</button>
                </div>

            </div>
        </div>
    </div>





    {{--VISUALIZAR ANTES DE ADICIONAR--}}
    <div class="modal fade show " id="modal-apparatu" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"></h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 id="description"></h4>
                        <div class="row">
                            <div class="col-md-3"><img id="image" src="" class="rounded img-fluid"></div>
                            <div class="col-md-9">
                                <ul class="data-equipment hidex">
                                    <li><i class="fa fa-info"></i> Marca: <b id="brand"></b></li>
                                    <li><i class="fa fa-info"></i> Modelo: <b id="model"></b></li>
                                    <li><i class="fa fa-info"></i> Número de Série: <b id="serial_number"></b></li>
                                </ul>
                                <ul class="data-instrument hidex">
                                    <li><i class="fa fa-info"></i> Número de Série: <b id="serial_number"></b></li>
                                    <li><i class="fa fa-info"></i> Inventário: <b id="inventory"></b></li>
                                    <li><i class="fa fa-info"></i> Selo: <b id="label"></b></li>
                                    <li><i class="fa fa-info"></i> Lacres: <b id="seals"></b></li>
                                    {{--<li><i class="fa fa-info"></i> Portaria: <b id="portaria"></b></li>--}}
                                    {{--<li><i class="fa fa-info"></i> Divisão: <b id="divisao"></b></li>--}}
                                    {{--<li><i class="fa fa-info"></i> Capacidade: <b id="capacidade"></b></li>--}}
                                    {{--<li><i class="fa fa-info"></i> IP: <b id="ip"></b></li>--}}
                                    {{--<li><i class="fa fa-info"></i> Endereço: <b id="endereco"></b></li>--}}
                                    {{--<li><i class="fa fa-info"></i> Setor: <b id="setor"></b></li>--}}
                                </ul>
                            </div>
                        </div>

                        <hr class="hr-sm mb-2">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    <strong><i class="fa fa-exclamation-triangle"></i> Atenção!</strong>
                                    Caso o nº do chamado lançado esteja incorreto
                                    ou seja nº fictício, o usuário arcará com custos aplicados à esse instrumento/equipamento.
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('call_number', 'Nº Chamado', array('class' => 'col-form-label'))) !!}
                                    {{Form::text('call_number', '', ['id'=>'call_number','placeholder'=>'Nº Chamado','class'=>'form-control', 'maxlength'=>'50', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                        <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Selecionar</button>
                    </div>


                
            </div>
        </div>
    </div>

    {{--EQUIPAMENTOS--}}
    <div class="modal fade show " id="modal-equipments" tabindex="-2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Adicionar Equipamento</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Nº de Série</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th width="100px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Nº de Série</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th width="100px">Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Data->client->equipments as $sel)
                            <tr>
                                <td>{{$sel->id}}</td>
                                <td><img src="{{$sel->thumb_image}}" class="rounded img-fluid"></td>
                                <td>{{$sel->description}}</td>
                                <td>{{$sel->serial_number}}</td>
                                <td>{{$sel->brand->description}}</td>
                                <td>{{$sel->model}}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal-apparatu" data-type="equipment" class="btn btn-simple btn-info btn-xs"
                                    >Adicionar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--INSTRUMENTOS--}}
    <div class="modal fade show " id="modal-instruments" tabindex="-2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Adicionar Instrumento</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Nº de Série</th>
                            <th>Inventário</th>
                            <th>Selo</th>
                            <th>Lacres</th>
                            <th width="100px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Nº de Série</th>
                            <th>Inventário</th>
                            <th>Selo</th>
                            <th>Lacres</th>
                            <th width="100px">Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Data->client->instruments as $sel)
                            <tr>
                                <td>{{$sel->id}}</td>
                                <td><img src="{{$sel->thumb_image}}" class="rounded img-fluid"></td>
                                <td>{{$sel->getBaseDescription()}}</td>
                                <td>{{$sel->serial_number}}</td>
                                <td>{{$sel->inventory}}</td>
                                <td>{{$sel->getNumberLabelSetted()['text']}}</td>
                                <td>{{$sel->getNumberSealsSetted()['text']}}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal-apparatu" data-type="instrument" class="btn btn-simple btn-info btn-xs"
                                    >Adicionar
                                    </button> 
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--ADICIONAR SERVIÇO/PEÇA--}}
    <div class="modal fade show " id="modal-change-input" tabindex="-9999999999">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Adicionar/Editar Serviço</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card-content">

                        <div class="form-row hidex">
                            <div class="form-group col-md-12">
                                <h5>Paragraphs</h5>
                            </div>
                        </div>

                        <div class="form-row hidex">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('service_id', 'Serviço *', array('class' => 'col-form-label'))) !!}


                                <select class="form-control select2_single" name="service_id" id="service_id"
                                        tabindex="-1" required>
                                    <option value="">Escolha o Serviço</option>
                                    @foreach($Page->auxiliar['services'] as $service)
                                        <option
                                                value="{{$service['id']}}"
                                                data-price="{{$service['price']}}"
                                                data-price-formatted="{{$service['price_formatted']}}"
                                        >{{$service['description']}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-row hidex">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('part_id', 'Peça *', array('class' => 'col-form-label'))) !!}


                                <select class="form-control select2_single" name="part_id" id="part_id"
                                        tabindex="-1" required>
                                    <option value="">Escolha a Peça</option>
                                    @foreach($Page->auxiliar['parts'] as $service)
                                        <option
                                                value="{{$service['id']}}"
                                                data-price="{{$service['price']}}"
                                                data-price-formatted="{{$service['price_formatted']}}"
                                        >{{$service['description']}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-row">
                            {{Form::hidden('type', 'add')}}
                            {{Form::hidden('input_id', '')}}
                            {{Form::hidden('input', '')}}
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('value', 'Valor', array('class' => 'col-form-label'))) !!}
                                {{Form::text('value', 'R$ 0,00', ['id'=>'value','class'=>'form-control calc-total', 'disabled'])}}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('quantity', 'Quantidade *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('quantity', '1', ['id'=>'quantity','class'=>'form-control calc-total show-int', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('discount', 'Desconto *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('discount','R$ 0,00', ['id'=>'discount','class'=>'form-control show-fixed-price calc-total', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('total', 'Total', array('class' => 'col-form-label'))) !!}
                                {{Form::text('total', 'R$ 0,00', ['id'=>'total','class'=>'form-control show-fixed-price', 'disabled'])}}
                            </div>
                        </div>

                    </div>

                    @include('layouts.inc.loading')
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <button class="btn btn-label btn-primary pull-right change-input"><label><i class="ti-check"></i></label> Salvar</button>
                </div>


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
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">

            <h4 class="card-title"><strong>Ordem de Serviço #{{$Data->id}}</strong></h4>

            <div class="card-body">

                <div class="alert alert-{{$Data->status_color}}" role="alert">
                    Situação: <strong>{{$Data->status_text}}</strong>
                </div>


                <h6 class="text-uppercase mt-3">Informações
                    <button class="btn btn-success pull-right btn-xs" data-toggle="modal" data-target="#modal-orders-values">Resumo de Valores</button>
                </h6>
                <hr class="hr-sm mb-2">
                <dl class="row">
                    <dt class="col-sm-2">ID</dt>
                    <dd class="col-sm-6">{{$Data->id}} ({{$Data->idordem_servico}})</dd>

                    <dt class="col-sm-2">Data de Abertura</dt>
                    <dd class="col-sm-2">{{$Data->created_at_formatted}}</dd>

                    <dt class="col-sm-2">Cliente</dt>
                    <dd class="col-sm-6"><a href="{{route('clients.edit',$Data->client_id)}}" target="_blank">{{$Data->client->fantasy_name_text}}</a></dd>

                    <dt class="col-sm-2">Limite Técnica Atual</dt>
                    <dd class="col-sm-2"></dd>

                    <dt class="col-sm-2">Colaborador</dt>
                    <dd class="col-sm-6">{{$Data->owner->name}}</dd>

                </dl>
            </div>
            <footer class="card-footer text-right">
                <button class="btn btn-cyan pull-left" data-toggle="modal" data-target="#modal-equipments">Adicionar Equipamento</button>
                <button class="btn btn-brown" data-toggle="modal" data-target="#modal-instruments">Adicionar Instrumento</button>
            </footer>

        </div>

        @foreach($Data->apparatu_equipments as $apparatu)
            <?php $equipment = $apparatu->equipment; ?>
            <div class="card">

                <h3 class="card-title"><strong>Equipamento #{{$equipment->id}}-{{$apparatu->id}}</strong> <small class="sidetitle">Número Chamado: {{$apparatu->call_number}}</small>
                    <button class="btn btn-square btn-sm btn-danger pull-right" onclick="showDeleteMessage(this)" data-function="remApparatu" data-id="{{$apparatu->id}}" data-href="{{route('ajax.orders.rem-apparatu',$Data->id)}}" ><i class="ti-close"></i></button>
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

                            <h4>Lista de Serviços</h4>

                            @include('pages.transactions.technical_operations.orders.list.services',['Apparatu_services' => $apparatu->apparatu_services, 'Apparatu' => $apparatu])

                            <hr class="hr-sm mb-2">

                            <h4>Lista de Peças</h4>

                            @include('pages.transactions.technical_operations.orders.list.parts',['Apparatu_parts' => $apparatu->apparatu_parts, 'Apparatu' => $apparatu])

                        @else

                            {{Form::open(array(
                                'route' => ['apparatus.update', $apparatu->id],
                                'method'=>'PATCH',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                                ))}}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        {!! Html::decode(Form::label('defect', 'Defeito *', array('class' => 'col-form-label'))) !!}
                                        {{Form::textarea('defect', '', ['id'=>'defect','placeholder'=>'Defeito','class'=>'form-control', 'rows'=>4, 'minlength'=>'3', 'maxlength'=>'500', 'required'])}}
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Html::decode(Form::label('solution', 'Solução *', array('class' => 'col-form-label'))) !!}
                                        {{Form::textarea('solution', '', ['id'=>'solution','placeholder'=>'Solução','class'=>'form-control','rows'=>4, 'minlength'=>'3', 'maxlength'=>'500', 'required'])}}
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-row pull-right">
                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                </div>

                            {{Form::close()}}

                        @endif
                    </div>
                    @include('layouts.inc.loading')
                </div>

            </div>
        @endforeach


        @foreach($Data->apparatu_instruments as $apparatu)
            <?php $instrument = $apparatu->instrument; ?>
            <div class="card">

                <h3 class="card-title"><strong>Instrumento #{{$instrument->id}}-{{$apparatu->id}}</strong> <small class="sidetitle">Número Chamado: {{$apparatu->call_number}}</small>
                    <button class="btn btn-square btn-sm btn-danger pull-right" onclick="showDeleteMessage(this)" data-function="remApparatu" data-id="{{$apparatu->id}}" data-href="{{route('ajax.orders.rem-apparatu',$Data->id)}}" ><i class="ti-close"></i></button>
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

                        @if($apparatu->canShowInputs())

                            @include('pages.transactions.technical_operations.orders.inc.labelseals', ['apparatu' => $apparatu])

                            <div class="row">
                                <dt class="col-md-2 fs-14 text-danger">Defeito</dt>
                                <dd class="col-md-4">{{$apparatu->defect}}</dd>
                                <dt class="col-md-2 fs-14 text-success">Solução</dt>
                                <dd class="col-md-4">{{$apparatu->solution}}</dd>
                            </div>

                            <hr class="hr-sm mb-2">

                            <h4>Lista de Serviços</h4>

                            @include('pages.transactions.technical_operations.orders.list.services',['Apparatu_services' => $apparatu->apparatu_services, 'Apparatu' => $apparatu])

                            <hr class="hr-sm mb-2">

                            <h4>Lista de Peças</h4>

                            @include('pages.transactions.technical_operations.orders.list.parts',['Apparatu_parts' => $apparatu->apparatu_parts, 'Apparatu' => $apparatu])


                        @else

                            {{Form::open(array(
                                'route' => ['apparatus.update', $apparatu->id],
                                'method'=>'PATCH',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                                ))}}

		                    <?php
                                $labels_unsetted = $apparatu->instrument->getNumberLabelSetted(); //$selos_retirados
                                $seals_unsetted = $apparatu->instrument->getNumberSealsSetted(); //$lacres_retirados
		                    //dd($seals_unsetted)
		                    ?>

                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <div class="checkbox ">
                                        <label>
                                            {{--lacre_rompido--}}
                                            <input name="broken_seal" type="checkbox" class="flat" checked="checked"> Lacre rompido?
                                        </label>
                                    </div>

                                    @if($labels_unsetted != NULL)
                                        <div class="checkbox">
                                            <label>
                                                {{--selo_outro--}}
                                                <input name="other_label" type="checkbox" class="flat"> Outro Selo?
                                            </label>
                                        </div>
                                    @else
                                        <input name="other_label" type="hidden" value="1">
                                    @endif

                                    @if($seals_unsetted != NULL)
                                        <div class="checkbox">
                                            <label>
                                                <input name="other_seals" type="checkbox" class="flat"> Outros Lacres?
                                            </label>
                                        </div>
                                    @else
                                        <input name="other_seals" type="hidden" value="1">
                                    @endif
                                </div>

                            </div>

                            <div id="labelseals">

                                <div id="label-container">

                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                            <label class="control-label">Selo retirado: <span
                                                        class="required">*</span></label>
                                            @if($labels_unsetted != NULL)

                                                <input type="text" name="label_unsetted" class="form-control" placeholder="Selo retirado"
                                                    data-label_id="{{json_encode($labels_unsetted['id'])}}"
                                                    data-label_text="{{$labels_unsetted['text']}}"
                                                    value="{{$labels_unsetted['text']}}" disabled />
                                                <input type="hidden" name="label_unsetted_hidden"
                                                       value="{{json_encode($labels_unsetted['id'])}}"/>

                                            @else
                                                <input type="text" name="label_unsetted" class="form-control" placeholder="Selo retirado"
                                                    data-selo="" data-selo_text="" required />
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                            <label class="control-label">Selo afixado: <span
                                                        class="required">*</span></label>
                                            <select name="label_setted" class="select2_single-ajax form-control" tabindex="-1"
                                                    placeholder="Selo afixados" required></select>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                    </div>

                                </div>

                                <div id="seals-container">

                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                            <label class="control-label">Lacres retirados: *</label>

                                            @if($seals_unsetted != NULL)

                                                <select name="seals_unsetted[]" class="select2_multiple-ajax form-control"
                                                        tabindex="-1" multiple="multiple" required></select>
                                                <script>
                                                    $(document).ready(function () {
                                                        var data = JSON.parse('<?php echo json_encode( $seals_unsetted['data'] );?>');
                                                        var ids_data = $(data).map(function () {
                                                            return this.id;
                                                        }).get();
                                                        $("select[name='seals_unsetted[]']").select2({data: data});
                                                        $("select[name='seals_unsetted[]']").val(ids_data).trigger("change");
                                                    });
                                                </script>

                                                <input type="hidden" name="seals_unsetted_hidden"
                                                       value="{{json_encode($seals_unsetted['data'])}}"/>

                                            @endif

                                            <input type="text" name="seals_unsetted_free"
                                                   placeholder="Outros Lacres separados por ';' Ex: 1001; 1002; 1003"
                                                   @if($seals_unsetted == NULL) required class="form-control" @else class="form-control hidex" @endif/>


                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                            <label class="control-label">Lacres afixados: *</label>
                                            <select name="seals_setted[]" class="select2_multiple-ajax form-control"
                                                    tabindex="-1" multiple="multiple" required></select>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    {!! Html::decode(Form::label('defect', 'Defeito *', array('class' => 'col-form-label'))) !!}
                                    {{Form::textarea('defect', '', ['id'=>'defect','placeholder'=>'Defeito','class'=>'form-control', 'rows'=>4, 'minlength'=>'3', 'maxlength'=>'500', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    {!! Html::decode(Form::label('solution', 'Solução *', array('class' => 'col-form-label'))) !!}
                                    {{Form::textarea('solution', '', ['id'=>'solution','placeholder'=>'Solução','class'=>'form-control','rows'=>4, 'minlength'=>'3', 'maxlength'=>'500', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="form-row pull-right">
                                <button class="btn btn-primary" type="submit">Salvar</button>
                            </div>

                            {{Form::close()}}


                        @endif

                    </div>
                    @include('layouts.inc.loading')
                </div>

            </div>
        @endforeach

    </div><!--/.main-content -->
@endsection


@section('script_content')


    <!-- Select2 -->
    @include('layouts.inc.select2.js')

    <!-- Jquery Validation Plugin Js -->
{{--    @include('layouts.inc.validation.js')--}}

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')


    <script>
        //DEFINIÇÃO DOS AJAX
        $(document).ready(function(){
            var remoteDataConfigLabel = {
                width: 'resolve',
                ajax: {
                    url: "{{route('ajax.get.available-labels')}}",
                    dataType: 'json',
                    delay: 250,

                    data: function (params) {
                        return {
                            value   : params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
                language: "pt-BR"
//                templateResult: formatState
            };
            var remoteDataConfigSeals = {
                width: 'resolve',
                ajax: {
                    url: "{{route('ajax.get.available-seals')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            value   : params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: "pt-BR"
//                templateResult: formatState
            };
            $(".select2_single-ajax").select2(remoteDataConfigLabel);
            $(".select2_multiple-ajax").select2(remoteDataConfigSeals);
        });

        //LACRE ROMPIDO

        $(document).ready(function(){

            $('input[name="broken_seal"]').on('change', function (event) {
                var $parent = $(this).closest('div.form-row').next();
                if (this.checked == true){
                    $($parent).removeClass('hidex');
                    $($parent).find('select[name=label_setted]').attr('required', true);
                    $($parent).find('select[name="seals_setted[]"]').attr('required', true);
                } else {
                    $($parent).addClass('hidex');
                    $($parent).find('select[name=label_setted]').attr('required', false);
                    $($parent).find('select[name="seals_setted[]"]').attr('required', false);
                }
            });

            $('input[name="other_label"]').on('change', function (event) {

                var $field = $(this).closest('div.form-row').next().find('div#label-container input[name=label_unsetted]');
                if (this.checked == true){
                    $($field).attr('disabled',false);
                } else {
                    $($field).attr('disabled',true);
                    $($field).val($($field).data('label_text'));
                }
            });

            $('input[name="other_seals"]').on('change', function (event) {

                var $field = $(this).closest('div.form-row').next().find('div#seals-container input[name=seals_unsetted_free]');
                if (this.checked == true){
                    $($field).removeClass('hidex');
                    $($field).closest('div.form-group').find('select[name="seals_unsetted[]"]').attr('disabled',true);
                } else {
                    $($field).addClass('hidex');
                    $($field).closest('div.form-group').find('select[name="seals_unsetted[]"]').attr('disabled',false);
                    $($field).val('');
                }
            });
        });

    </script>


    <script>
        var $_BTN_REF_ = "";
        var $_URL_OS_VALUES_ = "{{route('ajax.orders.values', $Data->id)}}";
        var $_URL_SAVE_INPUT_ = "";

        $(document).ready(function(){
            $("div#modal-delete-alert").on("show.bs.modal", function (event) {
                $('div#modal-orders-values').modal('hide');
            });
            $("div#modal-delete-alert").on("hide.bs.modal", function (event) {
                $('div#modal-orders-values').modal('show');
            });

            $("div#modal-orders-values").on("show.bs.modal", function (event) {
                var $button = $(event.relatedTarget);
                var $parent = $(this).find('div.modal-body');

                console.log($($button).data('order_id'));
                $($parent).find('span.data-info').empty();

                loadingCard('show',$($parent).find('dl.row'));


                $.ajax({
                    url: $_URL_OS_VALUES_,
                    type: 'GET',
                    dataType: "json",
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    success: function (result) {
                        console.log(result);
                        loadingCard('hide',$($parent).find('dl.row'));


                        var fields = $($parent).find('span.data-info');
                        $( fields ).each(function(i,v) {
                            var name = v.id;
                            $($parent).find('span#' + name).html( result[name] );
                            console.log(result[name]);
                        });
                    }
                });
            });
        });

        // MODAL ADD APPARATU
        $(document).ready(function(){
            $("div#modal-apparatu").on("show.bs.modal", function (event) {

                var $button = $(event.relatedTarget);
                var $parent = $(this).find('div.modal-body');

                var obj = $($button).parents('tr').find('td');
                var type = $($button).data('type');


                var apparatu = {};


                apparatu.id = obj[0].innerHTML;
                apparatu.image = $(obj[1]).find('img').attr('src');
                apparatu.description = obj[2].innerHTML;
                apparatu.serial_number = obj[3].innerHTML;

                if(type == 'equipment'){
                    apparatu.brand = obj[4].innerHTML;
                    apparatu.model = obj[5].innerHTML;
                    $('div#modal-equipments').modal('hide');
                } else {
                    apparatu.inventory = obj[4].innerHTML;
                    apparatu.label = obj[5].innerHTML;
                    apparatu.seals = obj[6].innerHTML;
                    $('div#modal-instruments').modal('hide');
                }


                //preencher o modal do apparatu
                var $form = $($parent).parent();
                $($form).find('input[name=type]').val(type);
                $($form).find('input[name=id]').val(apparatu.id);

                if(type == 'equipment'){

                    $(this).find('h4.modal-title').html('Adicionar Equipamento');
                    $($parent).find('#id').html(apparatu.id);
                    $($parent).find('#image').attr('src', apparatu.image);
                    $($parent).find('#description').html(apparatu.description);

                    $($parent).find('ul.data-equipment #serial_number').html(apparatu.serial_number);
                    $($parent).find('ul.data-equipment #brand').html(apparatu.brand);
                    $($parent).find('ul.data-equipment #model').html(apparatu.model);


                    $(this).find('ul.data-equipment').removeClass('hidex');
                    $(this).find('ul.data-instrument').addClass('hidex');

                } else {

                    $(this).find('h4.modal-title').html('Adicionar Instrumento');
                    $($parent).find('#id').html(apparatu.id);
                    $($parent).find('#image').attr('src', apparatu.image);
                    $($parent).find('#description').html(apparatu.description);

                    $($parent).find('ul.data-instrument #serial_number').html(apparatu.serial_number);
                    $($parent).find('ul.data-instrument #inventory').html(apparatu.inventory);
                    $($parent).find('ul.data-instrument #label').html(apparatu.label);
                    $($parent).find('ul.data-instrument #seals').html(apparatu.seals);



                    $(this).find('ul.data-instrument').removeClass('hidex');
                    $(this).find('ul.data-equipment').addClass('hidex');

                }

            });


            $("div#modal-apparatu").on('hidden.bs.modal', function( event ) {
                if( $(this).find('form input[name=type]').val() == 'equipment'){
                    $('div#modal-equipments').modal('show');
                } else {
                    $('div#modal-instruments').modal('show');
                }
            });

        });


        //APPARATU
        function remApparatu($this){
            var $button = $($this);
            loadingCard('show',$($button));
            $.ajax({
                url: $($button).data('href'),
                dataType: "json",
                type: 'DELETE',
                data: {
                    "id" :$($button).data('id'),
                    "_token": "{{ csrf_token() }}"
                },
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                },
                success: function (result) {
                    loadingCard('hide',$($button));
                    console.log(result);
                    // return false;
                    if(result.status == 1) {
                        swal(
                            'Sucesso!',
                            result.text,
                            'success'
                        );
                        $($button).closest('div.card').remove();

                    } else {
                        swal(
                            'Erro!',
                            result.text,
                            'error'
                        );
                    }
                    return false;

                }
            });
        }
        //MODAL DELETE PREVENT

        function showDeleteMessage($this) {
            swal({
                title: "Você tem certeza?",
                text: "Esta ação será irreversível!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim! ",
                cancelButtonText: "Não, cancelar! "
            }).then(
                function (isConfirm) {
                    if (typeof isConfirm.dismiss == 'undefined') {
                        switch($($this).data('function')){
                            case 'remInput':
                                remInput($this);break;
                            case 'remApparatu':
                                remApparatu($this);break;
                        }
                        return true;
                    } else {
                        swal(
                            "Cancelado",
                            "Nenhuma alteração realizada!",
                            "error"
                        )
                    }
                }
            );
        }

        //MODAL ADICIONAR SERVIÇO

        function clearInputs($fields){
            $($fields).find("select").val("").trigger('change.select2');

            $($fields).find('input[name=value]').val("R$ 0,00");
            $($fields).find('input[name=value]').attr('real-value', '');
            $($fields).find('input[name=discount]').maskMoney('mask', 0);
            $($fields).find('input[name=quantity]').val(1);
            $($fields).find('input[name=total]').maskMoney('mask', 0);
        }

        function remInput($this){
            var $button = $($this);
            loadingCard('show',$($button));
            $.ajax({
                url: $($button).data('href'),
                dataType: "json",
                type: 'DELETE',
                data: {
                    "id" :$($button).data('id'),
                    "input_id" :$($button).data('input_id'),
                    "input" :$($button).data('input'),
                    "_token": "{{ csrf_token() }}"
                },
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                },
                success: function (result) {
                    loadingCard('hide',$($button));
                    console.log(result);
                    if(result.status == 1) {
                        swal(
                            'Sucesso!',
                            result.text,
                            'success'
                        );
                        $($button).closest('tr').remove();

                    } else {
                        swal(
                            'Erro!',
                            result.text,
                            'error'
                        );
                    }
                    return false;

                }
            });
        }

        function addInput($this){
            var $fields = $($this).parent().prev();
            var input = $($fields).find('input[name=input]').val();
            var id = $($fields).find('select#' + input + '_id').find(":selected").val();
            if(id != "" && id != undefined){
                var $parent = $($fields).find('div.form-row');
                var $button = $($this);
                loadingCard('show',$parent);
                $($button).attr('disabled',true);

                var discount = $($fields).find('input[name=discount]').maskMoney('unmasked')[0];;
                var quantity = $($fields).find('input[name=quantity]').val();
                var value = $($fields).find('input[name=value]').attr('real-value');

                $.ajax({
                    url: $_URL_SAVE_INPUT_,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "id" :id,
                        "value" :value,
                        "discount" :discount,
                        "quantity" :quantity,
                        "input" :input,
                        "_token": "{{ csrf_token() }}"
                    },
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    success: function (result) {
                        loadingCard('hide',$parent);
                        $($button).attr('disabled',false);
                        console.log(result);
                        if(result.status == 1){

                            //ZERANDO OS VALORES DO FORM DO MODAL
                            clearInputs($fields);

                            //ADICIONANDO A NOVA ROW
                            var $parentTR = $_BTN_REF_.closest('tfoot').next().find('tr').last();
                            var $new = $parentTR.clone();
                            if($($new).hasClass('hidex')) {
                                $($new).removeClass('hidex');
                            }

                            var data_ = result.data;
                            if(input == 'service'){
                                $($new).find('th').first().html(data_.service_id);
                            } else {
                                $($new).find('th').first().html(data_.part_id);
                            }

                            $($new).find('th').last().html(data_.name);
                            $fields = $($new).find('td')
                            $fields[0].innerHTML = data_.value_formatted;
                            $fields[1].innerHTML = data_.quantity;
                            $fields[2].innerHTML = data_.discount_formatted;
                            $fields[3].innerHTML = data_.total_formatted;

                            var $bts = $($fields[4]).find('a');

                            var $btnedit = $($bts).first();
                            $($btnedit).attr('data-id',data_.id);

                            var $btndel = $($bts).last();
                            $($btndel).attr('data-id',data_.id);
                            if(input == 'service'){
                                $($btndel).attr('data-input_id',data_.service_id);
                            } else {
                                $($btndel).attr('data-input_id',data_.part_id);
                            }
                            $($btndel).addClass('rem-input');

                            $new.insertAfter($parentTR);

                            swal(
                                'Sucesso!',
                                result.text,
                                'success'
                            );
                        } else {

                            swal(
                                'Erro!',
                                result.text,
                                'error'
                            );
                        }
                        return false;

                    }
                });

            }
        }

        function saveInput($this){
            var $fields = $($this).parent().prev();
            var $parent = $($fields).find('div.form-row');
            var $button = $($this);
            loadingCard('show',$parent);
            $($button).attr('disabled',true);

            var discount = $($fields).find('input[name=discount]').maskMoney('unmasked')[0];
            var quantity = $($fields).find('input[name=quantity]').val();
            var value = $($fields).find('input[name=value]').attr('real-value');
            var id = $($fields).find('input[name=input_id]').val();
            var input = $($fields).find('input[name=input]').val();

            $.ajax({
                url: "{{route('ajax.orders.save-input')}}",
                type: 'POST',
                dataType: "json",
                data: {
                    "id" :id,
                    "value" :value,
                    "input" :input,
                    "discount" :discount,
                    "quantity" :quantity,
                    "_token": "{{ csrf_token() }}"
                },
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                },
                success: function (result) {
                    loadingCard('hide',$parent);
                    $($button).attr('disabled',false);
                    console.log(result);
                    if(result.status == 1){

                        //ZERANDO OS VALORES DO FORM DO MODAL
                        clearInputs($fields);

                        //ATUALIZANDO A ROW
                        var data_ = result.data;
                        $fields = $_BTN_REF_.closest('tr').find('td')
                        $fields[0].innerHTML = data_.value_formatted;
                        $fields[1].innerHTML = data_.quantity;
                        $fields[2].innerHTML = data_.discount_formatted;
                        $fields[3].innerHTML = data_.total_formatted;

                        $($button).closest('div.modal#modal-change-input').modal('hide');
                        swal(
                            'Sucesso!',
                            result.text,
                            'success'
                        );
                    } else {

                        swal(
                            'Erro!',
                            result.text,
                            'error'
                        );
                    }
                    return false;

                }
            });

        }

        $(document).ready(function () {
            $("select#service_id, select#part_id").on("select2:select", function() {
                var $parent = $(this).parents('div.modal-body');
                var $selected = $(this).find(":selected");

                // $($parent).find('input[name=discount]').maskMoney('destroy');
                $($parent).find('input[name=discount]').maskMoney('mask', 0);

                $($parent).find('input[name=quantity]').val(1);

                // $($parent).find('input[name=total]').maskMoney('destroy');

                if ($($selected).val() != '') {
                    var data = {};
                    data.id = $($selected).val();
                    data.price = $($selected).data('price');
                    data.price_formatted = $($selected).data('price-formatted');
                    $($parent).find('input[name=value]').val(data.price_formatted);
                    $($parent).find('input[name=value]').attr('real-value', data.price);
                    $($parent).find('input[name=total]').maskMoney('mask', parseFloat(data.price));
                } else {
                    $($parent).find('input[name=value]').val('R$ 0,00');
                    $($parent).find('input[name=value]').attr('real-value', '');
                    $($parent).find('input[name=total]').maskMoney('mask', 0);
                }
            });

            //MANIPULAÇÃO DE PREÇO
            $(".calc-total").keyup( function () {
                //achar parent, pegar próximo td e escrever o valor


                var $parent = $(this).parents('div.form-row');
                // $($parent).find('input[name=total]').maskMoney('destroy');

                var price = $($parent).find('input[name=value]').attr('real-value');
                var quantity = $($parent).find('input[name=quantity]').val();
                if(quantity == ''){
                    quantity = 1;
                    $($parent).find('input[name=quantity]').val(1);
                }

                if (price != '' && price != undefined) {
                    var discount = $($parent).find('input[name=discount]').maskMoney('unmasked')[0];
                    price = (price * quantity) - discount;

                    $($parent).find('input[name=total]').maskMoney('mask', price);
                } else {
                    $($parent).find('input[name=total]').maskMoney('mask', 0);
                }
            });

            $(".change-input").click(function(){
                var $fields = $(this).parent().prev();
                if($($fields).find("input[name=type]").val() == 'add'){
                    addInput(this);
                } else {
                    saveInput(this);
                }
            });

            $("div#modal-change-input").on('show.bs.modal', function( event ) {
                $_BTN_REF_ = $(event.relatedTarget);
                var input = $_BTN_REF_.data('input');
                $(this).find('input[name=type]').val($_BTN_REF_.data('type'));
                $(this).find('input[name=input_id]').val('');
                $(this).find('input[name=input]').val(input);
                var $parent = $(this).find('div.card-content').find('div.form-row');
                if($_BTN_REF_.data('type') == 'edit'){
                    $(this).find('input[name=input_id]').val($($_BTN_REF_).data('id'));
                    var $button =$_BTN_REF_;
                    $.ajax({
                        url: $($_BTN_REF_).data('href'),
                        dataType: "json",
                        type: 'GET',
                        data: {
                            "id" :$($_BTN_REF_).data('id'),
                            "input" :input,
                            "_token": "{{ csrf_token() }}"
                        },
                        error: function (xhr, textStatus) {
                            console.log('xhr-error: ' + xhr.responseText);
                            console.log('textStatus-error: ' + textStatus);
                        },
                        success: function (result) {
                            // loadingCard('hide', $parent);
                            // $($button).attr('disabled', false);
                            console.log(result);
                            if(result.status == 1) {
                                var data = result.data;

                                var $i = $($parent).first();
                                if(input == 'service'){
                                    $($i).removeClass('hidex').find('h5').html(data.service_id + ' - ' + data.name);
                                } else {
                                    $($i).removeClass('hidex').find('h5').html(data.part_id + ' - ' + data.name);
                                }

                                $i = $($i).next();
                                $($i).addClass('hidex');
                                $($i).next().addClass('hidex');

                                $parent = $($parent).last();
                                $($parent).find('input[name=value]').val(data.value_formatted);
                                $($parent).find('input[name=value]').attr('real-value', data.value);
                                $($parent).find('input[name=discount]').maskMoney('mask', parseFloat(data.discount));
                                $($parent).find('input[name=quantity]').val(data.quantity);
                                $($parent).find('input[name=total]').maskMoney('mask', data.total);

                            } else {
                                swal(
                                    'Erro!',
                                    result.text,
                                    'error'
                                );
                            }
                        }
                    });
                } else {

                    var $i = $($parent).first();
                    $($i).addClass('hidex');
                    if(input == 'service'){
                        $i = $($i).next();
                        $($i).removeClass('hidex');
                        $($i).next().addClass('hidex');
                    } else {
                        $i = $($i).next();
                        $($i).addClass('hidex');
                        $($i).next().removeClass('hidex');
                    }

                    clearInputs($($parent));
                }
                $_URL_SAVE_INPUT_ = $($_BTN_REF_).data('href');
            });

            $("div#modal-change-input").on('hidden.bs.modal', function( event ) {
                var $parent = $(this).find('div.form-row');
                loadingCard('hide',$parent);
                //ZERANDO OS VALORES DO FORM DO MODAL
            });

        });
        app.ready(function(){
            var table = $('table.table[data-provide="datatables"]').DataTable();
            table.page.len( 4 ).draw();
        });
        // app.ready(function(){
    </script>
    
    


    

    <script>


        // MODAL CLIENT
        $(document).ready(function(){
            $("div#modal-client").on("show.bs.modal", function (event) {

                //AO ABRIR O MODAL DO CLIENTE, FECHAR O MODAL DE VALORES
                $('div#modal-orders-values').modal('hide');

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

            //AO FECHAR O MODAL DO CLIENTE, ABRIR O MODAL DE VALORES NOVAMENTE
            $("div#modal-client").on('hidden.bs.modal', function( event ) {
                $('div#modal-orders-values').modal('show');
            });
        });

    </script>
    
    




@endsection