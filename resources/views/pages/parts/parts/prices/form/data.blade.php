<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do Equipamento</strong></h4>
@endif

<div class="card-body">
    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">
        @if(isset($client_id))
            <input type="hidden" name="client_id" value="{{$client_id}}">
        @endif
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('setor', 'Marca *', array('class' => 'col-form-label'))) !!}
            {{Form::select('brand_id',$brands,(isset($brand_id)? $brand_id:''),['id'=>'brand','class'=>'custom-select'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->name : "")), ['id'=>'description','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('serial_number', 'Serial *', array('class' => 'col-form-label'))) !!}
            {{Form::text('serial_number', old('serial_number',(isset($Data) ? $Data->serial_number : "")), ['id'=>'serial_number','placeholder'=>'Serial','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


