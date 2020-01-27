@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link active" href="#">CONTAS A RECEBER CLIENTES</a>
    <a class="nav-link" href="#">CONTAS A PAGAR FRANQUEADOS</a>
    <a class="nav-link" href="#">CONTAS A PAGAR FORNECEDORES</a>
    <a class="nav-link" href="#">CONTAS A RECEBER FRANQUEADOS</a>

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection