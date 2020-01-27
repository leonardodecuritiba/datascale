@extends('layouts.admin.app')

@section('title', $Page->title)

@section('style_content')
    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}
@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layouts.inc.breadcrumb')

@endsection

@section('page_content')
    <!-- Main container -->
    <div class="main-content">


    @include('layouts.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">


            @if(isset($Data))
                <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getName()}} - R$ {{$Data->valor_total_formatted}}</strong></h4>
            @else
                <h4 class="card-title"><strong>Dados da {{$Page->name}}</strong></h4>
            @endif
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="informations-tab" data-toggle="tab" href="#informations" role="tab" aria-controls="informations" aria-selected="true">Informações</a>
                    </li>
                    
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" id="prices-tab" data-toggle="tab" href="#prices" role="tab" aria-controls="prices" aria-selected="false">Preços</a>
                    </li>
                    -->
                    
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">

                        @if(isset($Data))
                            {{Form::model($Data,
                            array(
                                'route' => ['parts.update', $Data->id],
                                'method'=>'PATCH',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @else
                            {{Form::open(array(
                                'route' => ['parts.store'],
                                'method'=>'POST',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @endif
                         @include('pages.parts.parts.form.data')
                        {{Form::close()}}
                    </div>
                    
                    <!--
                    <div class="tab-pane fade" id="prices" role="tabpanel" aria-labelledby="prices-tab">
                        @include('pages.parts.parts.prices.index',['prices' => isset($Data) ? $Data->prices : []])
                    </div>
                    -->
                    
              



                </div>
            </div>
        </div>


    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery Validation Plugin Js -->

    @include('layouts.inc.validation.js')


    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')


@endsection