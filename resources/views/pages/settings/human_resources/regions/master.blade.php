@extends('layouts.admin.app')

@section('title', $Page->title)

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
                    'route' => ['regions.update', $Data->id],
                    'method'=>'PATCH',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
            @else
                {{Form::open(array(
                    'route' => ['regions.store'],
                    'method'=>'POST',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
            @endif
                @include('pages.settings.human_resources.regions.form.data')
            {{Form::close()}}
        </div>


    </div><!--/.main-content -->
@endsection
