@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.ipem.certificates.menu.data')

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
                            <th>Número Certificado</th>
                            <th>Data de Verificação</th>
                            <th>Data de Validade</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Número Certificado</th>
                            <th>Data de Verificação</th>
                            <th>Data de Validade</th>
                            <th>Ação</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td id="id">{{$sel['id']}}</td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['number']}}</td>
                                <td data-order="{{$sel['verified_at_time']}}">{{$sel['verified_at']}}</td>
                                <td data-order="{{$sel['due_at_time']}}">{{$sel['due_at']}}</td>
                                <td>
                                    @role(['admin'])
                                    @include('layouts.inc.buttons.edit')
                                    @endrole
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

@endsection