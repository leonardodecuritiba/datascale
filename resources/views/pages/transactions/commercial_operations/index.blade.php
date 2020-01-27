@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="#"><del>ABRIR ORÇAMENTO</del></a>
    <a class="nav-link" href="#"><del>LISTAR ORÇAMENTO</del></a>
    <a class="nav-link" href="#"><del>LISTAR VENDAS</del></a>
    <a class="nav-link" href="#"><del>FATURAMENTO DIRETO</del></a>
    <a class="nav-link" href="#"><del>CONSULTA PREÇOS</del></a>

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection
