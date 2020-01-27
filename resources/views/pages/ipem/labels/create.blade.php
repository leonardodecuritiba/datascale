@extends('layouts.admin.app')

@section('title', $Page->title)

@section('style_content')

    <!-- Select2 -->
    @include('layouts.inc.select2.css')

@endsection


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

                    <div class="alert alert-danger" role="alert">
                        <strong><i class="fa fa-exclamation-triangle"></i> Atenção!</strong>
                        NÃO DIGITAR ÚLTIMO DÍGITO DA {{$Page->names}}!
                    </div>
                    {{Form::open(array(
                        'route' => ['labels.store'],
                        'method'=>'POST',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}

                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('user_id', 'Usuário *', array('class' => 'col-form-label'))) !!}
                            {{Form::select('user_id', $Page->auxiliar['users'], old('user_id', Request::get('user_id')), ['id'=>'user_id','placeholder' => 'Escolha o Usuário', 'class'=>'form-control select2_single', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('num_begin', 'Númeração Inicial *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('num_begin', '', ['id'=>'num_begin','placeholder'=>'Númeração Inicial','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Html::decode(Form::label('num_end', 'Númeração Final *', array('class' => 'col-form-label'))) !!}
                            {{Form::text('num_end', '', ['id'=>'num_end','placeholder'=>'Númeração Final','class'=>'form-control show-int','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                            <div class="invalid-feedback"></div>
                        </div>
                         
                        <footer class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </footer>

                    {{Form::close()}}

                </div>

            </div>

        </div>

    </div><!--/.main-content -->

@endsection


@section('script_content')

    {{--Jquery MaskMoney Js--}}
    @include('layouts.inc.maskmoney.js')

    <!-- Select2 -->
    @include('layouts.inc.select2.js')

@endsection

