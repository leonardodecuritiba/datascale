@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.ipem.seals.menu.data')

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">
                
                <div class="card-body">

                    {{Form::open(array(
                        'route' => ['labels.store'],
                        'method'=>'POST',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}

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

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    {{--Jquery InputMask Js --}}
    @include('layouts.inc.inputmask.js')

    {{--Jquery MaskMoney Js --}}
    @include('layouts.inc.maskmoney.js')

@endsection

