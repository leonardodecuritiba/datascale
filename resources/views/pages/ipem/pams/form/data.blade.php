<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados da Região</strong></h4>
@endif

<div class="card-body">

    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">

    {{--Picture--}}
    @include('layouts.part.picture')

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Modelo *', array('class' => 'col-form-label'))) !!}
            {{Form::select('instrument_model_id',$Page->auxiliar['instrument_models'],(isset($Data)? $Data->instrument_model->id:''),['id'=>'models','class'=>'custom-select'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['id'=>'title','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('division', 'Divisão *', array('class' => 'col-form-label'))) !!}
            {{Form::text('division', old('division',(isset($Data) ? $Data->division : "")), ['id'=>'division','placeholder'=>'Divisão','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('ordinance', 'Portaria *', array('class' => 'col-form-label'))) !!}
            {{Form::text('ordinance', old('ordinance',(isset($Data) ? $Data->ordinance : "")), ['id'=>'ordinance','placeholder'=>'Portaria','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('capacity', 'Capacidade *', array('class' => 'col-form-label'))) !!}
            {{Form::text('capacity', old('capacity',(isset($Data) ? $Data->capacity : "")), ['id'=>'capacity','placeholder'=>'Capacidade','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>