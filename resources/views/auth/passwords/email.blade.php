@extends('layout.extras.app')
@section('body_content')

    <div class="row no-gutters min-h-fullscreen bg-white">

        @include('layouts.extras.left')

        <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
            <div class="px-80 py-30">

                <h4>Recuperar Senha</h4>
                <p>
                    <small>Mandaremos um email com a sua senha!</small>
                </p>
                @include('layout.inc.alerts')
                <br>

                <form class="form-horizontal" data-provide="validation" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ old('email') }}" required>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <br>
                    <button class="btn btn-bold btn-block btn-info" type="submit">Recuperar</button>
                </form>

                <hr class="w-30px">

                <p class="text-center text-muted fs-13 mt-20">ou clique em <a class="text-info fw-500"
                                                                                      href="{{route('login')}}">Entrar</a>
                </p>
                {{--<hr class="w-30px">--}}

                {{--<p class="text-center text-muted fs-13 mt-20">Não tem conta? <a class="text-info fw-500"--}}
                                                                                {{--href="{{route('register')}}">Registrar</a>--}}
                {{--</p>--}}
            </div>
        </div>
    </div>
@endsection
