@extends('layouts.admin.app')

@section('title', 'Home')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   'Home')

@section('page_header-subtitle', 'Bem-Vindo')

@section('page_header-nav')

    <a class="nav-link active" href="icons.html">List</a>
    <a class="nav-link" href="icons-fontawesome.html">Font Awesome</a>
    <a class="nav-link" href="icons-themify.html">Themify</a>
    <a class="nav-link" href="icons-material.html">Material</a>
    <a class="nav-link d-none d-md-block" href="icons-ionicons.html">Ionicons</a>
    <a class="nav-link d-none d-md-block" href="icons-7stroke.html">7stroke</a>
    <a class="nav-link d-none d-md-block" href="icons-emojione.html">Emojione</a>
    <a class="nav-link d-none d-md-block" href="icons-flat-color.html">Flat color</a>

@endsection

@section('page_content')

    <div class="main-content">
        <h1>Bem Vindo</h1>
    </div><!--/.main-content -->

@endsection
