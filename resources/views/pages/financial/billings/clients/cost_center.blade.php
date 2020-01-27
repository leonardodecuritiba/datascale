@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('pages.financial.billings.clients.menu.data')

@endsection

@section('style_content')

    @include('layouts.inc.select2.css')

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection

@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

    @include('layouts.inc.select2.js')

@endsection
