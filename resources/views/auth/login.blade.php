@extends('layouts.extras.app')
@section('body_content')
    <div class="row no-gutters min-h-fullscreen bg-white">

        @include('layouts.extras.left')

        <div class="col-md-6 col-lg-5 col-xl-4 align-self-center" >
            <div class="px-80 py-30">
                <div class="d-flex flex-column align-items-center">
                 <h4>Entrar</h4>
                <p>
                    <small>Entre com sua conta</small>
                </p> 
                
                <!--<img class="img-fluid" src="{{asset('assets/images/logo/logo-current.png')}}">-->
                
                </div>
                {{--<p>--}}
                    {{--<small>ADMIN: admin@email.com</small>--}}
                    {{--<br>--}}
                    {{--<small>SENHA: 123</small>--}}
                {{--</p>--}}
                @include('layouts.inc.alerts')
                <br>

                <form class="form-horizontal" data-provide="validation" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                        <label for="email">E-Mail</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ old('email') }}" required autofocus>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Senha</label>
                        <input id="password" type="password" class="form-control" name="password"
                               required>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group flexbox">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Lembrar</span>
                        </label>

                        <a class="text-muted hover-primary fs-13" href="{{ route('password.request') }}">
                            Esqueceu a Senha?
                        </a>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-bold btn-block btn-info" type="submit">Entrar</button>
                    </div>
                </form>

                {{--<div class="divider">Ou entre com</div>--}}
                {{--<div class="text-center">--}}
                    {{--<a class="btn btn-square btn-facebook" href="#"><i class="fa fa-facebook"></i></a>--}}
                    {{--<a class="btn btn-square btn-google" href="#"><i class="fa fa-google"></i></a>--}}
                    {{--<a class="btn btn-square btn-twitter" href="#"><i class="fa fa-twitter"></i></a>--}}
                {{--</div>--}}

                {{--<hr class="w-30px">--}}

                {{--<p class="text-center text-muted fs-13 mt-20">Não tem conta? <a class="text-info fw-500"--}}
                                                                                {{--href="{{route('register')}}">Registrar</a>--}}
                {{--</p>--}}
            </div>
        </div>
    </div>
@endsection
