@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.requestions.patterns.menu.data')

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> Registros</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered table-responsive-lg"
                           cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th>Massa Total</th>
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
                            <th>Tipo</th>
                            <th>Massa Total</th>
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
                                <td>{{$sel['type_text']}}</td>
                                <td>{{$sel['total']}}</td>
                                <td>{{$sel['value_formatted']}}</td>
                                <td>{{$sel['reason']}}</td>
                                <td>{{$sel['response']}}</td>
                                <td>
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