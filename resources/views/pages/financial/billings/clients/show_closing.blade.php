@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

{{--@section('page_header-nav')--}}

{{--@include('pages.financial.billings.clients.menu.data')--}}

{{--@endsection--}}

@section('page_modals')


@endsection
@section('page_content')

    <div class="main-content">

    @include('layouts.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">

            <h4 class="card-title"><strong>Gerador de Faturamento</strong>
                <a class="btn btn-a btn-success pull-right ml-2"
                   href="{{route('billings.bill', [$Client->id, $cost_center])}}">
                    <i class="fa fa-money fa-2"></i> Iniciar Faturamento</a>
            </h4>

            <div class="card-body">

                <h6 class="text-uppercase mt-3">Informações</h6>
                <hr class="hr-sm mb-2">
                <dl class="row">
                    <dt class="col-sm-2">Cliente</dt>
                    <dd class="col-sm-4"><a href="{{route('clients.edit',$Client->id)}}"
                                            target="_blank">{{$Client->fantasy_name_text}}</a></dd>

                </dl>

                <h6 class="text-uppercase mt-3">Valores</h6>
                <hr class="hr-sm mb-2">


                @include('pages.transactions.technical_operations.orders.list.values', ['values' => $Values])

            </div>
        </div>

        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | O.S
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->

        @include('pages.financial.billings.list.orders', ['Orders' => $Orders])
    </div><!--/.main-content -->

@endsection

@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

@endsection
