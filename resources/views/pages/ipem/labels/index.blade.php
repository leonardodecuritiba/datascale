@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.ipem.labels.menu.data')

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">

                <div class="card-body">

                    {{Form::open(array(
                        'route' => ['labels.index'],
                        'method'=>'GET',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('number', 'Numeração', array('class' => 'col-form-label'))) !!}
                                {{Form::text('number', old('number',Request::get('number')), ['placeholder'=>'NUMERAÇÃO','minlength'=>"3",'maxlength'=>"100",'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('owner_id', 'Origem', array('class' => 'col-form-label'))) !!}
                                {{Form::select('owner_id', $Page->auxiliar['users'], old('owner_id', Request::get('owner_id')), ['id'=>'owner_id','placeholder' => 'Escolha o Usuário', 'class'=>'form-control show-tick'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('status', 'Status *', array('class' => 'col-form-label'))) !!}
                                {{Form::select('status', $Page->auxiliar['status'], old('status', Request::get('status')), ['id'=>'status','placeholder' => 'Escolha o Status', 'class'=>'form-control show-tick', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('cnpj', 'CNPJ', array('class' => 'col-form-label'))) !!}
                                {{Form::text('cnpj', old('cnpj',Request::get('cnpj')), ['placeholder'=>'CNPJ','minlength'=>"3",'maxlength'=>"100",'class'=>'form-control show-cnpj'])}}
                                <div class="invalid-feedback"></div>

                            </div>

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('cnpj', 'ID Ordem de Serviço', array('class' => 'col-form-label'))) !!}
                                {{Form::text('order_id', old('order_id',Request::get('order_id')), ['placeholder'=>'ID da Ordem de Serviço','minlength'=>"1",'maxlength'=>"100",'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('serial_number', 'Nº Série', array('class' => 'col-form-label'))) !!}
                                {{Form::text('serial_number', old('serial_number',Request::get('serial_number')), ['placeholder'=>'Nº SÉRIE','minlength'=>"3",'maxlength'=>"100",'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                {!! Html::decode(Form::label('inventory', 'Nº Inventário', array('class' => 'col-form-label'))) !!}
                                {{Form::text('inventory', old('inventory',Request::get('inventory')), ['placeholder'=>'Nº Inventário','minlength'=>"3",'maxlength'=>"100",'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <footer class="card-footer text-right">
                            <button class="btn btn-primary" name="search" type="submit">Filtrar</button>

                        </footer>

                    {{Form::close()}}

                </div>


            </div>

        </div>

        <div class="card">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> Registros</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered table-responsive-sm" cellspacing="0"
                           data-provide="datatables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Nº</th>
                            <th>Cliente</th>
                            <th>Fixado</th>
                            <th>Retirado</th>
                            <th>Nº Série</th>
                            <th>Nº Inventário</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Nº</th>
                            <th>Cliente</th>
                            <th>O.S. Fixada</th>
                            <th>O.S. Retirada</th>
                            <th>Nº Série</th>
                            <th>Nº Inventário</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td>
                                    {{$sel['id']}}
                                </td>
                                <td>
                                    <span class="badge badge-{{$sel['status_color']}}">{{$sel['status_text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>

                                <td>{{$sel['owner_name']}}</td>
                                <td data-order="{{$sel['number']}}">
                                    @if($sel['is_external'])
                                        <span class="badge badge-danger"
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              title="Externo"
                                        ><i class="fa fa-exclamation-triangle"></i></span>
                                    @endif
                                    {{$sel['number']}}
                                </td>
                                <td>
                                    @if($sel['client_id']!=NULL)
                                        <a target="_blank" href="{{route('clients.show',$sel['client_id'])}}">{{$sel['client_text']}}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($sel['order_setted_id']!=NULL)
                                        <a target="_blank" href="{{route('orders.show',$sel['order_setted_id'])}}">{{$sel['order_setted_id']}}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($sel['order_unsetted_id']!=NULL)
                                        <a target="_blank" href="{{route('orders.show',$sel['order_unsetted_id'])}}">{{$sel['order_unsetted_id']}}</a>
                                    @endif
                                </td>
                                <td>{{$sel['serial_number']}}</td>
                                <td>{{$sel['inventory']}}</td>

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

    {{--Jquery InputMask Js--}}
    @include('layouts.inc.inputmask.js')

    {{--Jquery MaskMoney Js--}}
    @include('layouts.inc.maskmoney.js')

@endsection
