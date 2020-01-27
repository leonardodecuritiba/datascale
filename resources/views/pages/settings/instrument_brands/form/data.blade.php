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
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['id'=>'title','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>