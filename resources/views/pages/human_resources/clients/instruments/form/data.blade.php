<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do Instrumento</strong></h4>
@endif

<div class="card-body">
    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('setor', 'Setor *', array('class' => 'col-form-label'))) !!}
            {{Form::select('instrument_setor_id',$instrument_setors,(isset($instrument_setor_id)? $instrument_setor_id:''),['id'=>'setor','class'=>'custom-select'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('description', 'Base *', array('class' => 'col-form-label'))) !!}
            {{Form::select('pam_id',$pams,(isset($pam_id)? $pam_id:''),['id'=>'bases','class'=>'custom-select'])}}
            <div class="invalid-feedback"></div>
        </div>
        @if(isset($client_id))
            <input type="hidden" name="client_id" value="{{$client_id}}">
        @endif
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('serial_number', 'Serial *', array('class' => 'col-form-label'))) !!}
            {{Form::text('serial_number', old('serial_number',(isset($Data) ? $Data->serial_number : "")), ['id'=>'serial_number','placeholder'=>'Serial','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('inventory', 'Inventário *', array('class' => 'col-form-label'))) !!}
            {{Form::text('inventory', old('inventory',(isset($Data) ? $Data->inventory : "")), ['id'=>'inventory','placeholder'=>'Inventário','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('patrimony', 'Patrimonio *', array('class' => 'col-form-label'))) !!}
            {{Form::text('patrimony', old('patrimony',(isset($Data) ? $Data->patrimony : "")), ['id'=>'patrimony','placeholder'=>'Patrimonio','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('year', 'Ano *', array('class' => 'col-form-label'))) !!}
            {{Form::text('year', old('year',(isset($Data) ? $Data->year : "")), ['id'=>'year','placeholder'=>'Ano','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('address', 'Endereço *', array('class' => 'col-form-label'))) !!}
            {{Form::text('address', old('address',(isset($Data) ? $Data->address : "")), ['id'=>'address','placeholder'=>'Endereço','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('ip', 'IP', array('class' => 'col-form-label'))) !!}
            {{Form::text('ip', old('ip',(isset($Data) ? $Data->ip : "")), ['id'=>'ip','placeholder'=>'IP','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>