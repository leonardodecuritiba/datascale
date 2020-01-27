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
                {{Form::model($Data,
                array(
                    'route' => ['providers.update', $Data->id],
                    'method'=>'PATCH',
                    'files'=>'true',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
            @else
                {{Form::open(array(
                    'route' => ['providers.store'],
                    'method'=>'POST',
                    'files'=>'true',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
            @endif
                @include('pages.human_resources.providers.form.data')
            {{Form::close()}}
        </div>


    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Address Layout Js -->
    @include('layouts.part.address.js')

    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- LegalPeople Layout Js -->
    @include('layouts.part.legal_person.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

@endsection