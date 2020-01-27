@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.financial.billings.clients.menu.data')

@endsection

@section('style_content')

    @include('layouts.inc.select2.css')

@endsection

@section('page_content')

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

                    {!! Form::open(['route' => 'billings.clients.report',
                        'method' => 'GET']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {{Form::text('billing_id', old('billing_id', Request::get('billing_id')), ['placeholder'=>'ID do Faturamento','class'=>'form-control', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-info" type="submit" name="search_id"><i class="ti-search"></i> Buscar apenas por ID</button>
                            </div>
                        </div>
                    {{ Form::close() }}

                    <hr class="hr-sm mb-2">

                    {!! Form::open(['route' => 'billings.clients.report',
                        'method' => 'GET']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('type', 'Tipo *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('type', $Page->auxiliar['types'], old('type', Request::get('type')), ['id'=>'type','placeholder' => 'Escolha o Tipo', 'class'=>'form-control select2_single', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('status', 'Situação', array('class' => 'col-form-label'))) !!}
                                {{Form::select('status', $Page->auxiliar['status'], old('status', Request::get('status')), ['id'=>'status','placeholder' => 'Escolha a Situação', 'class'=>'form-control select2_single'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('client_id', 'Clientes', array('class' => 'col-form-label'))) !!}
                                {{Form::select('client_id', $Page->auxiliar['clients'], old('client_id', Request::get('client_id')), ['id'=>'client_id','placeholder' => 'Escolha o Cliente', 'class'=>'form-control select2_single'])}}
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
                            <th>Situação</th>
                            <th>Data</th>
                            <th>Tipo de Pagamento</th>
                            <th>Quantidade O.S.</th>
                            <th>CNPJ</th>
                            <th>Cliente</th>
                            <th width="20px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Situação</th>
                            <th>Data</th>
                            <th>Tipo de Pagamento</th>
                            <th>Quantidade O.S.</th>
                            <th>CNPJ</th>
                            <th>Cliente</th>
                            <th width="20px">Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse($Page->response as $sel)
                            <tr>
                                <td>{{$sel['id']}}</td>
                                <td><span class="badge badge-{{$sel['status_color']}} badge-md">
                                     {{$sel['status_text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['payment_text']}}</td>
                                <td>{{$sel['quantity_orders']}}</td>
                                <td>{{$sel['document_text']}}</td>
                                <td>
                                    <a target="_blank" href="{{route('clients.show',$sel['client_id'])}}">{{$sel['client_text']}}</a>
                                </td>
                                <td>
                                    <a href="{{route('billings.clients.show', $sel['id'])}}"
                                       class="btn btn-square btn-xs btn-outline btn-info"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="Visualizar"
                                    ><i class="fa fa-eye"></i>
                                    </a>

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

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

    @include('layouts.inc.select2.js')

@endsection

