<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do NCM</strong></h4>
@endif

<div class="card-body">

    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('code', 'Código *', array('class' => 'col-form-label'))) !!}
            {{Form::text('code', old('code',(isset($Data) ? $Data->code : "")), ['id'=>'code','placeholder'=>'Código','class'=>'form-control','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['id'=>'title','placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('ipi', 'IPI *', array('class' => 'col-form-label'))) !!}
            {{Form::text('ipi', old('ipi',(isset($Data) ? $Data->ipi_formatted : "")), ['id'=>'ipi','placeholder'=>'IPI','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('pis', 'PIS *', array('class' => 'col-form-label'))) !!}
            {{Form::text('pis', old('pis',(isset($Data) ? $Data->pis_formatted : "")), ['id'=>'pis','placeholder'=>'PIS','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('cofins', 'COFINS *', array('class' => 'col-form-label'))) !!}
            {{Form::text('cofins', old('cofins',(isset($Data) ? $Data->cofins_formatted : "")), ['id'=>'cofins','placeholder'=>'COFINS','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('nacional', 'Alíquota Nacional *', array('class' => 'col-form-label'))) !!}
            {{Form::text('nacional', old('nacional',(isset($Data) ? $Data->nacional_formatted : "")), ['id'=>'nacional','placeholder'=>'Alíquota Nacional','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('importacao', 'Alíquota Importação *', array('class' => 'col-form-label'))) !!}
            {{Form::text('importacao', old('importacao',(isset($Data) ? $Data->importacao_formatted : "")), ['id'=>'importacao','placeholder'=>'Alíquota Importação','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>