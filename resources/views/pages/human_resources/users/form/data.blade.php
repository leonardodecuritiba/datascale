<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
@if(isset($Data))
    <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong></h4>
@else
    <h4 class="card-title"><strong>Dados do Administrador</strong></h4>
@endif

<div class="card-body">

    <h6 class="text-uppercase mt-3">Dados de Acesso</h6>
    <hr class="hr-sm mb-2">

    @if(isset($Data))

        <div class="form-row">
            <label class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10">
                <p class="form-control-plaintext">{{$Data->id}}</p>
            </div>
        </div>
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <p class="form-control-plaintext">{{$Data->getShortEmail()}}</p>
            </div>
        </div>
    @else

        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('email', 'Email *', array('class' => 'col-form-label'))) !!}
                {{Form::email('email', '', ['id'=>'email','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-md-6">
                {!! Html::decode(Form::label('password', 'Senha *', array('class' => 'col-form-label'))) !!}
                {{Form::text('password', '', ['id'=>'password','placeholder'=>'Senha','class'=>'form-control','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
                <div class="invalid-feedback"></div>
            </div>
        </div>

    @endif


    <h6 class="text-uppercase mt-3">Dados Pessoais</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('name', 'Nome *', array('class' => 'col-form-label'))) !!}
            {{Form::text('name', old('name',(isset($Data) ? $Data->name : "")), ['id'=>'name','placeholder'=>'Nome','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <h6 class="text-uppercase mt-3">Pessoa Física</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">

        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('cpf', 'CPF *', array('class' => 'col-form-label'))) !!}
            {{Form::text('cpf', old('cpf',(isset($Data) ? $Data->cpf_formatted : "")), ['id'=>'cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('rg', 'RG *', array('class' => 'col-form-label'))) !!}
            {{Form::text('rg', old('rg',(isset($Data) ? $Data->rg_formatted: "")), ['id'=>'rg','placeholder'=>'RG','class'=>'form-control show-rg','minlength'=>'3', 'maxlength'=>'20', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>


<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>