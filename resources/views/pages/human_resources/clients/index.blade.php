@extends('layouts.admin.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layouts.inc.defaultsubmenu',['entity'=>$Page->entity])

@endsection

@section('page_content')
    <!-- Main container -->

    <div class="main-content">

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

                    {!! Form::open(['route' => 'clients.index',
                        'method' => 'GET']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            {{Form::text('client_id', old('client_id', Request::get('client_id')), ['placeholder'=>'ID do Cliente','class'=>'form-control', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <button class="btn btn-info" type="submit" name="search_id"><i class="ti-search"></i> Buscar apenas por ID</button>
                        </div>
                    </div>
                    {{ Form::close() }}

                    <hr class="hr-sm mb-2">

                    {!! Form::open(['route' => 'clients.index',
                        'method' => 'GET']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('description', 'Buscar Cliente', array('class' => 'col-form-label'))) !!}
                            {{Form::text('description', old('description',Request::get('description')), ['placeholder'=>'Buscar Cliente','class'=>'form-control'])}}
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
                            <th>Imagem</th>
                            <th>Situação</th>
                            <th>Cadastrado</th>
                            <th>Fantasia</th>
                            <th>Razão Social</th>
                            <th>CPF/CNPJ</th>
                            <th>Nome Responsável</th>
                            <th>Fone</th>
                            <th width="20px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Situação</th>
                            <th>Cadastrado</th>
                            <th>Fantasia</th>
                            <th>Razão Social</th>
                            <th>CPF/CNPJ</th>
                            <th>Nome Responsável</th>
                            <th>Fone</th>
                            <th width="20px">Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                                <td>{{$sel['id']}}</td>
                                <td><img class="avatar avatar-lg" src="{{$sel['image']}}"></td>
                                <td>
                                    <span class="badge badge-{{$sel['active']['active_color']}}">{{$sel['active']['active_text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['fantasy_name_text']}}</td>
                                <td>{{$sel['social_reason_text']}}</td>
                                <td>{{$sel['short_document']}}</td>
                                <td>{{$sel['responsible_name']}}</td>
                                <td>{{$sel['phone']}}</td>
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