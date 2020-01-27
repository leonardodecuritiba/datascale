<div class="modal modal-fill" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePassword">Alterar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{Form::open(
            array(
                'route' => 'change.password',
                'method'=>'POST',
                'id' => 'form_validation',
                'class'=>'form-horizontal'
            )
            )}}
            <div class="modal-body">
                <div class="text-right">
                    <img src="{{asset('assets/images/logos/logo-b-p.png')}}"
                         alt="logo icon">
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Html::decode(Form::label('password', 'Nova Senha *', array('class' => 'col-md-4 control-label'))) !!}
                    <div class="col-md-12">
                        {{Form::password('password', ['id'=>'password','class'=>'form-control','minlength'=>'3', 'required'])}}
                        @if ($errors->has('password'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Html::decode(Form::label('password_confirmation', 'Confirmar Senha *', array('class' => 'col-md-4 control-label'))) !!}
                    <div class="col-md-12">
                        {{Form::password('password_confirmation', ['id'=>'password_confirmation','class'=>'form-control','minlength'=>'3', 'required'])}}
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>