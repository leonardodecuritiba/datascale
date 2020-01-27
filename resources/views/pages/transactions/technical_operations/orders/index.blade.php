@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="{{route('orders.index')}}">LISTAR ORDEM SERVIÇO</a>
    <a class="nav-link" href="{{route('orders.create')}}" href="#">ABRIR ORDEM SERVIÇO</a>
    <a class="nav-link" href="#"><del>ABRIR ORÇAMENTO O.S</del></a>
    <a class="nav-link" href="#"><del>LISTAR ORÇAMENTO O.S</del></a>
    <a class="nav-link" href="#"><del>FATURAMENTO DIRETO</del></a>

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

                    {!! Form::open(['route' => 'orders.index',
                        'method' => 'GET']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {{Form::text('order_id', old('order_id', Request::get('order_id')), ['placeholder'=>'ID da Ordem de Serviço','class'=>'form-control', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-info" type="submit" name="search_id"><i class="ti-search"></i> Buscar apenas por ID</button>
                            </div>
                        </div>
                    {{ Form::close() }}

                    <hr class="hr-sm mb-2">

                    {!! Form::open(['route' => 'orders.index',
                        'method' => 'GET']) !!}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('created_at_start', 'Data de Abertura', array('class' => 'col-form-label'))) !!}
                                {{Form::text('created_at_start', old('created_at_start',Request::get('created_at_start')), ['placeholder'=>'Data de Abertura','class'=>'form-control show-date'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('status', 'Situação *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('status', $Page->auxiliar['status'], old('status', Request::get('status')), ['id'=>'status','placeholder' => 'Escolha a Situação', 'class'=>'form-control show-tick'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('client_id', 'Clientes *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('client_id', $Page->auxiliar['clients'], old('client_id', Request::get('client_id')), ['id'=>'client_id','placeholder' => 'Escolha o Cliente', 'class'=>'form-control show-tick'])}}
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

        @if($Page->response != NULL)


            @if($Page->response['current_orders'] != NULL)

                @include('pages.transactions.technical_operations.orders.list.orders', ['Orders' => $Page->response['current_orders'], 'period' => NULL])

            @endif

            @if($Page->response['past_orders'] != NULL)

                <div class="card">
                    <h5 class="card-title"><strong>Períodos Anteriores</strong></h5>

                    <div class="card-body">

                        <div class="nav-tabs-left">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-success">

                                <?php $c = 0; ?>
                                @foreach ($Page->response['past_orders'] as $period => $orders)

                                    <li class="nav-item">
                                        <a class="nav-link @if($c==0) active @endif" data-toggle="tab" href="#{{$period}}">Período {{$period}}</a>
                                    </li>
                                    <?php $c++; ?>

                                @endforeach

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" style="width: 100%;">

	                            <?php $c = 0; ?>
                                @foreach ($Page->response['past_orders'] as $period => $orders)

                                    <div class="tab-pane fade @if($c==0) active show @endif" id="{{$period}}">

                                        @include('pages.transactions.technical_operations.orders.list.orders', ['Orders' => $orders, 'period' => $period])

                                    </div>
                                    <?php $c++; ?>

                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>

            @endif

        @endif


    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

    @include('layouts.inc.sweetalert.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')
@endsection