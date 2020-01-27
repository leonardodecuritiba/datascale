<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do Grupo</strong></h4>
@endif

<div class="card-body">

    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'col-form-label'))) !!}
            {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['placeholder'=>'Nome','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['id'=>'title','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'255', 'required'])}}

            <div class="invalid-feedback"></div>
        </div>
    </div>
    
    

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('group_id', 'Grupo *', array('class' => 'col-form-label'))) !!}
            {{Form::select('group_id', $Page->auxiliar['groups'], old('group_id',(isset($Data) ? $Data->group_id : "")), ['placeholder' => 'Escolha o Grupo', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('unity_id', 'Unidade *', array('class' => 'col-form-label'))) !!}
            {{Form::select('unity_id', $Page->auxiliar['unities'], old('unity_id',(isset($Data) ? $Data->unity_id : "")), ['placeholder' => 'Escolha a Unidade', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('value', 'Valor (R$)', array('class' => 'col-form-label'))) !!}
            {{Form::text('value', old('value',(isset($Data) ? $Data->value_formatted : "")), ['placeholder'=>'Valor (R$)','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


   
@section('script_content')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

@endsection