@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    <a class="nav-link" href="{{route('orders.index')}}">LISTAR ORDEM SERVIÇO</a>
    <a class="nav-link" href="{{route('orders.create')}}" href="#">ABRIR ORDEM SERVIÇO</a>
    <a class="nav-link" href="#"><del>ABRIR ORÇAMENTO O.S</del></a>
    <a class="nav-link" href="#"><del>LISTAR ORÇAMENTO O.S</del></a>
    <a class="nav-link" href="#"><del>FATURAMENTO DIRETO</del></a>

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection