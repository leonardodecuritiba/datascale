@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="#">METAS</a>
    <a class="nav-link" href="#">FATURAMENTO</a>
    <a class="nav-link" href="#">INADIMPLÊNCIA</a>
    <a class="nav-link" href="#">CHAMADOS</a>
    {{--<a class="nav-link" href="icons-fontawesome.html">Font Awesome</a>--}}
    {{--<a class="nav-link d-none d-md-block" href="icons-flat-color.html">Flat color</a>--}}

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection
