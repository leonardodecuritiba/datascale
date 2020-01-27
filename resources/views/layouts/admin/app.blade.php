<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Datascale') }} - @yield('title')</title>

    @include('layouts.inc.head')
</head>

<body>

<!-- Preloader -->
<div class="preloader">
    <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>

{{--@role('admin')--}}
    @include('layouts.admin.sidebar')
    @include('layouts.admin.topbar')
{{--@endrole--}}


<main class="main-container">

    @include('layouts.inc.modal.change-password')

    @yield('page_modals')


    <header class="header bg-ui-general">

        <div class="header-info">
            <h1 class="header-title">
                <strong>@yield('page_header-title')</strong>
                <small>@yield('page_header-subtitle')</small>
            </h1>
            @if($Page->create_option)
                <button onclick="window.location.href='{{route($Page->entity.'.create')}}'" class="btn btn-outline btn-purple">
                    {{trans('pages.view.CREATE', [ 'name' => $Page->name ])}}
                </button>
            @endif
        </div>
        <div class="header-action">
            <nav class="nav">
                @yield('page_header-nav')
            </nav>
        </div>

        <div class="header-action">
            <nav class="nav">
                @yield('page_header-nav2')
            </nav>
        </div>
    </header><!--/.header -->



    @yield('page_content')

    @include('layouts.inc.footer')

</main>

<!-- Global quickview -->
<div id="qv-global" class="quickview" data-url="../assets/data/quickview-global.html">
    <div class="spinner-linear">
        <div class="line"></div>
    </div>
</div>
<!-- END Global quickview -->

@include('layouts.inc.foot')
@yield('script_content')


</body>
</html>
