<h6 class="text-uppercase mt-3">Dados de Contato</h6>
<hr class="hr-sm mb-2">
<div class="form-row">
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('phone', 'Telefone', array('class' => 'col-form-label'))) !!}
        {{Form::text('phone', old('phone',((isset($Contact)) ? $Contact->phone : '')), ['id' => 'phone', 'placeholder' => 'Telefone', 'class'=>'form-control show-phone'])}}
    </div>
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('cellphone', 'Celular', array('class' => 'col-form-label'))) !!}
        {{Form::text('cellphone', old('cellphone',((isset($Contact)) ? $Contact->cellphone : '')), ['id' => 'cellphone', 'placeholder' => 'Celular', 'class'=>'form-control show-cellphone'])}}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('skype', 'Skype', array('class' => 'col-form-label'))) !!}
        {{Form::text('skype', old('skype',((isset($Contact)) ? $Contact->skype : '')), ['id' => 'skype', 'placeholder' => 'Skype', 'maxlength'=>'100','class'=>'form-control'])}}
    </div>
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('email', 'Email', array('class' => 'col-form-label'))) !!}
        {{Form::text('email', old('email',((isset($Contact)) ? $Contact->email : '')), ['id' => 'email', 'placeholder' => 'Email', 'maxlength'=>'100','class'=>'form-control'])}}
    </div>
</div>