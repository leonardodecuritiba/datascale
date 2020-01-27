@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="#">ACRAS API FISCAL</a>
    <a class="nav-link" href="#">VALIDADE DE CERTIFICADO</a>
    <a class="nav-link" href="#">TABELA CÓDIGO IBGE</a>
    {{--<a class="nav-link" href="#">RELATÓRIO DE FATURADOS</a>--}}
    {{--<a class="nav-link" href="icons-fontawesome.html">Font Awesome</a>--}}
    {{--<a class="nav-link d-none d-md-block" href="icons-flat-color.html">Flat color</a>--}}

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection

