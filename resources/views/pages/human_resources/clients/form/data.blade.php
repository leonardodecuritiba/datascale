

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!--> 


<div class="card-body">
   <hr class="hr-sm mb-2">

    {{--Picture--}}
    @include('layouts.part.picture')

    <div class="form-row">
        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('responsible_name', 'Nome Responsável', array('class' => 'col-form-label'))) !!}
            {{Form::text('responsible_name', old('responsible_name',(isset($Data) ? $Data->responsible_name : "")), ['id'=>'responsible_name','placeholder'=>'Nome Responsável','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('cpf', 'CPF', array('class' => 'col-form-label'))) !!}
            {{Form::text('cpf', old('cpf',(isset($Data) ? $Data->cpf : "")), ['id'=>'cpf','placeholder'=>'CPF','class'=>'form-control show-cpf','minlength'=>'3', 'maxlength'=>'16'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('budget_email', 'Email Orçamento', array('class' => 'col-form-label'))) !!}
            {{Form::text('budget_email', old('budget_email',(isset($Data) ? $Data->budget_email : "")), ['id'=>'budget_email','placeholder'=>'Email Orçamento','class'=>'form-control','minlength'=>'3', 'maxlength'=>'60'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('segment_id', 'Segmento *', array('class' => 'col-form-label'))) !!}
            {{Form::select('segment_id', $Page->auxiliar['segments'], old('segment_id',(isset($Data) ? $Data->segment_id : "")), ['placeholder' => 'Escolha o Segmento', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('group', 'Grupo', array('class' => 'col-form-label'))) !!}
            {{Form::text('group', old('group',(isset($Data) ? $Data->group : "")), ['id'=>'group','placeholder'=>'Grupo','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    
    

    <h6 class="text-uppercase mt-3">Tipo de Cadastro</h6>
    <hr class="hr-sm mb-2">

    <div class="form-row">
        <div class="custom-controls-stacked">

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="0" @if(isset($Data) && ($Data->isLegalPerson() == 0)) checked="" @endif>
                <label class="custom-control-label" for="type">Pessoa Física</label>
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="type" value="1" id="juridico" @if(!isset($Data)) checked="" @elseif($Data->isLegalPerson() == 1)  checked=""  @endif>
                <label class="custom-control-label" for="type">Pessoa Jurídica</label>
            </div>
        </div>
    </div>

    @include('pages.human_resources.settings.legal_person.form', ['LegalPerson' => (isset($Data) ? $Data->legal_person : NULL)])

    @include('pages.human_resources.forms.address', ['Address' => (isset($Data) ? $Data->address : NULL)])

    @include('pages.human_resources.forms.contact', ['Contact' => (isset($Data) ? $Data->contact : NULL)])


</div>

<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>


