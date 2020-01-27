@extends('pages.parts.prices.list.master')

@section('card')

    <div class="card">
        <h4 class="card-title"><strong>{{$Data->service_prices->count()}}</strong> Preço de Serviços</h4>


        <div class="card-content">
            <div class="card-body">

                <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Serviço</th>
                        <th>Valor Peça</th>
                        <th>Preço (Margem)</th>
                        <th>Preço Mínimo (Margem)</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Serviço</th>
                        <th>Valor Peça</th>
                        <th>Preço (Margem)</th>
                        <th>Preço Mínimo (Margem)</th>
                        <th>Ações</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($Data->service_prices as $sel)
                        <tr>
                            <td>{{$sel['id']}}</td>
                            <td class="data-name">@if($sel['service_id'] != NULL)<a target="_blank" href="{{route('services.edit',$sel['service_id'])}}">{{$sel->getServiceName()}}</a>@endif</td>
                            <td>{{$sel->original_price_formatted}}</td>
                            <td data-order="{{$sel['price']}}">{{$sel['price_formatted'] . ' (' . $sel['range_formatted'] . ')'}}</td>
                            <td data-order="{{$sel['price_min']}}">{{$sel['price_min_formatted'] .' (' . $sel['range_min_formatted'] . ')'}}</td>
                            <td>
                                <a class="btn btn-simple btn-info btn-xs btn-icon edit"
                                   href="#" data-toggle="modal" data-target="#changePrice"
                                   data-json="{{$sel->getDataJson()}}"
                                   data-type="service"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="Editar"><i class="material-icons">edit</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('layouts.inc.loading')
    </div>

@endsection
@section('script_content')
    @include('layouts.inc.maskmoney.js')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    @include('pages.parts.prices.js.prices')

@endsection