<h6 class="text-uppercase mt-3">Dados de Endereço {{(isset($Address) ? '(#' . $Address->id . ')' : '')}}</h6>
<hr class="hr-sm mb-2">
<div class="form-row">
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('street', 'Logradouro', array('class' => 'col-form-label'))) !!}
        {{Form::text('street', old('street', (($Address != null) ? $Address->street : '')), ['class'=>'form-control', 'placeholder'=>'Logradouro', 'maxlength'=>'125',  'required'])}}
    </div>
    <div class="form-group col-md-2">
        {!! Html::decode(Form::label('number', 'Número', array('class' => 'col-form-label'))) !!}
        {{Form::text('number', old('number', (($Address != null) ? $Address->number : '')), ['class'=>'form-control show-only-numbers', 'placeholder'=>'Número', 'maxlength'=>'30',  'required'])}}
    </div>
    <div class="form-group col-md-4">
        {!! Html::decode(Form::label('complement', 'Complemento', array('class' => 'col-form-label'))) !!}
        {{Form::text('complement', old('complement', (($Address != null) ? $Address->complement : '')), ['class'=>'form-control', 'placeholder'=>'Complemento', 'maxlength'=>'50', ])}}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-8">
        {!! Html::decode(Form::label('district', 'Bairro', array('class' => 'col-form-label'))) !!}
        {{Form::text('district', old('district', (($Address != null) ? $Address->district : '')), ['class'=>'form-control', 'placeholder'=>'Bairro', 'maxlength'=>'72',  'required'])}}
    </div>
    <div class="form-group col-md-4">
        {!! Html::decode(Form::label('zip', 'CEP', array('class' => 'col-form-label'))) !!}
        {{Form::text('zip', old('zip', (($Address != null) ? $Address->getFormatedZip() : '')), ['class'=>'form-control show-cep', 'placeholder'=>'CEP', 'maxlength'=>'16',  'required'])}}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-4">
        {!! Html::decode(Form::label('state', 'Estado', array('class' => 'col-form-label'))) !!}
        {{Form::select('state_id', $Page->auxiliar['states'], old('state_id',(isset($Address) ? $Address->state_id : '')), ['placeholder' => 'Escolha o Estado', 'class'=>'form-control show-tick','id' => 'select-state', 'required'])}}
    </div>
    <div class="form-group col-md-4">
        {!! Html::decode(Form::label('city', 'Cidade', array('class' => 'col-form-label'))) !!}
        {{Form::select('city_id', [], '', ['placeholder' => 'Escolha a Cidade', 'class'=>'form-control show-tick','id' => 'select-city', 'required'])}}
    </div>
    <div class="form-group col-md-4">
        {!! Html::decode(Form::label('city_code', 'Código IBGE', array('class' => 'col-form-label'))) !!}
        {{Form::text('city_code', old('city_code', (($Address != null) ? $Address->city_code : '')), ['class'=>'form-control', 'maxlength'=>'10', 'required'])}}
    </div>
</div>


<script>
    var _STATE_ID_ = "{{old('state_id',((isset($Address)) ? $Address->state_id : ''))}}";
    var _CITY_ID_ = "{{old('city_id', ((isset($Address)) ? $Address->city_id : ''))}}";
</script>