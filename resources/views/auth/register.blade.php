@extends('layout.extras.app')
@section('body_content')
    @include('layouts.inc.modal.terms')
    <div class="row no-gutters min-h-fullscreen bg-white">

        @include('layouts.extras.left')

        <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
            <div class="px-80 py-30">
                <h4>Faça um Cadastro</h4>
                <p>
                    <small>Todos os campos são obrigatórios.</small>
                </p>
                @include('layout.inc.alerts')
                <br>
                {{Request::get('plan_id')}}

                <form class="form-horizontal" data-provide="validation" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    @if(isset($Plan))
                        {{Form::hidden('plan_id', $Plan->id)}}
                        <div class="form-group">
                            <label for="plan">Plano Selecionado</label>
                            <input id="plan" type="text" class="form-control"
                                   value="{{$Plan->getNameValueFormatted()}}" disabled>
                        </div>
                    @endif

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="require">Nome</label>
                        <input id="name" type="text" class="form-control" name="name"
                               value="{{ old('name') }}" required autofocus>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-Mail</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ old('email') }}" required>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Senha</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirmar Senha</label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" required>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Concordar com os <a class="text-info" data-toggle="modal" data-target="#showTerms">termos</a></span>
                        </label>
                    </div>

                    <br>
                    <button class="btn btn-bold btn-block btn-info" type="submit">Registrar</button>
                </form>

                <hr class="w-30px">

                <p class="text-center text-muted fs-13 mt-20">Já possui uma conta? <a class="text-info fw-500"
                                                                                      href="{{route('login')}}">Entrar</a>
                </p>
            </div>
        </div>
    </div>
@endsection
