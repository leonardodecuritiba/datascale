@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="#">LISTAR / EDITAR</a>
    <a class="nav-link" href="{{route('services.create')}}">CADASTRAR</a>

@endsection

@section('page_content')
    <!-- Main container -->

    <div class="main-content">

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
                            <th>Cadastrado</th>
                            <th>Descrição</th>
                            <th>Grupo</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Situação</th>
                            <th>Cadastrado</th>
                            <th>Descrição</th>
                            <th>Grupo</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                                <td>{{$sel['id']}}</td>
                                <td>
                                    <span class="badge badge-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['content']}}</td>
                                <td>@if($sel['group_id'] != NULL)<a target="_blank" href="{{route('groups.edit',$sel['group_id'])}}">{{$sel['group_name']}}</a>@endif</td>
                                <td>
                                    @include('layouts.inc.buttons.active',['active'=>$sel['active']])
                                    @include('layouts.inc.buttons.edit')
                                    @include('layouts.inc.buttons.delete')
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

@endsection