@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

@endsection

@section('page_content')

    <div class="main-content">

        @include('layouts.inc.alerts')

        <div class="card">
            <h4 class="card-title"><strong>{{$Page->title}}</strong></h4>

            <div class="card-content">

                <div class="card-body">

                    {{Form::open(array(
                        'route' => ['requestions.seals.store'],
                        'method'=>'POST',
                        'data-provide'=> "validation",
                        'data-disable'=>'false'
                    )
                    )}}
                    <div class="form-group col-md-12">
                        {!! Html::decode(Form::label('num_begin', 'Quantidade *', array('class' => 'col-form-label'))) !!}
                        {{Form::text('quantity', '', ['id'=>'quantity','placeholder'=>'Quantidade','class'=>'form-control show-inteiro','minlength'=>'1', 'maxlength'=>'20', 'required'])}}
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group col-md-12">
                        {!! Html::decode(Form::label('reason', 'Razão *', array('class' => 'col-form-label'))) !!}
                        {{Form::textarea('reason', '', ['id'=>'reason','placeholder'=>'Razão','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
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

