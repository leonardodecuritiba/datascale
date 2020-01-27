<section class="section-pj">

    <h6 class="text-uppercase mt-3">Dados de Pessoa Jurídica {{(isset($LegalPerson) ? '(#' . $LegalPerson->id . ')' : '')}}</h6>
    <hr class="hr-sm mb-2">
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('cnpj', 'CNPJ *', array('class' => 'col-form-label'))) !!}
            {{Form::text('cnpj', old('cnpj',(isset($LegalPerson) ? $LegalPerson->cnpj : "")), ['id'=>'cnpj','placeholder'=>'CNPJ','class'=>'form-control show-cnpj','minlength'=>'3', 'maxlength'=>'60', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('ie', 'Inscrição Estadual', array('class' => 'col-form-label'))) !!}
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"  name="exemption_ie" id="exemption_ie"
                        {{((isset($LegalPerson) && ($LegalPerson->exemption_ie)) ? "checked" : "")}}>
                <label class="custom-control-label" for="exemption_ie">Isento?</label>
            </div>

            {{Form::text('ie', old('ie',(isset($LegalPerson) ? $LegalPerson->ie : "")), ['id'=>'ie','class'=>'form-control show-ie','minlength'=>'3', 'maxlength'=>'20', (isset($LegalPerson) && ($LegalPerson->exemption_ie == 0)) ? 'required' : ''])}}
            <div class="invalid-feedback"></div>

        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('social_reason', 'Razão Social *', array('class' => 'col-form-label'))) !!}
            {{Form::text('social_reason', old('social_reason',(isset($LegalPerson) ? $LegalPerson->social_reason : "")), ['id'=>'social_reason','placeholder'=>'Razão Social','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('fantasy_name', 'Nome Fantasia *', array('class' => 'col-form-label'))) !!}
            {{Form::text('fantasy_name', old('fantasy_name',(isset($LegalPerson) ? $LegalPerson->fantasy_name : "")), ['id'=>'fantasy_name','placeholder'=>'Nome Fantasia','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

</section>