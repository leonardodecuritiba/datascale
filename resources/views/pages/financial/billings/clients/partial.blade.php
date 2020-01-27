@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.financial.billings.clients.menu.data')

@endsection

@section('page_content')

    <div class="main-content">

        @if($Page->response['closings']->count() > 0)

            <div class="card">
                <h4 class="card-title"><strong>{{count($Page->response['closings'])}}</strong> {{$Page->subtitle}} Não
                    Fechados</h4>

                <div class="card-content">
                    <div class="card-body">

                        <table class="table table-striped table-bordered table-responsive-lg"
                               cellspacing="0" data-provide="datatables">
                            <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Fantasia</th>
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>Qtd. O.S</th>
                                <th width="20px">Ações</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Imagem</th>
                                <th>Fantasia</th>
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>Qtd. O.S</th>
                                <th width="20px">Ações</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                @foreach($Page->response['closings'] as $sel)
                                    <tr>
                                        <td><img class="avatar avatar-lg" src="{{$sel['image']}}"></td>
                                        <td>
                                            <a target="_blank" href="{{route('clients.show',$sel['client_id'])}}">{{$sel['client_name']}}</a>
                                        </td>
                                        <td>{{$sel['social_reason_text']}}</td>
                                        <td>{{$sel['short_document']}}</td>
                                        <td>{{$sel['quantity']}}</td>
                                        <td>
                                            <a class="btn btn-square btn-outline btn-xs btn-info"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Visualizar"
                                               href="{{route('billings.closing.show',[$sel['client_id'], $Page->response['cost_center']])}}"><i
                                                        class="fa fa-eye"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        @endif

        @if($Page->response['billings']->count() > 0)

            <div class="card">
                <h4 class="card-title"><strong>{{$Page->response['billings']->count()}}</strong> {{$Page->title}}
                    Abertos</h4>

                <div class="card-content">
                    <div class="card-body">

                        <table class="table table-striped table-bordered table-responsive-lg"
                               cellspacing="0" data-provide="datatables">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Situação</th>
                                <th>Data de Criação</th>
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
                                <th>Data de Criação</th>
                                <th>Tipo de Pagamento</th>
                                <th>Quantidade O.S.</th>
                                <th>CNPJ</th>
                                <th>Cliente</th>
                                <th width="20px">Ações</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($Page->response['billings'] as $sel)
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

        @endif


    </div><!--/.main-content -->

@endsection

@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')
    <script>
        app.ready(function () {
            $_TABLE_.page.len( 4 ).draw();
        });
    </script>
@endsection