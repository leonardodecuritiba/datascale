
<h6 class="text-uppercase mt-3">Tributação</h6>
<hr class="hr-sm mb-2">

<div class="form-row">
    <div class="form-group col-md-2">
        {!! Html::decode(Form::label('cfop_id', 'CFOP *', array('class' => 'col-form-label'))) !!}
        {{Form::select('cfop_id', $Page->auxiliar['cfops'], old('cfop_id',(isset($Data) ? $Data->cfop_id : "")), ['placeholder' => 'Escolha o CFOP', 'class'=>'form-control show-tick', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-2">
        {!! Html::decode(Form::label('cst_id', 'CST *', array('class' => 'col-form-label'))) !!}
        {{Form::select('cst_id', $Page->auxiliar['csts'], old('cst_id',(isset($Data) ? $Data->cst_id : "")), ['placeholder' => 'Escolha o CST', 'class'=>'form-control show-tick', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('cest', 'CEST *', array('class' => 'col-form-label'))) !!}
        {{Form::text('cest', old('cest',(isset($Data) ? $Data->cest : "")), ['placeholder'=>'CEST','class'=>'form-control','minlength'=>'3', 'maxlength'=>'10', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-5">
        {!! Html::decode(Form::label('nature_operation_id', 'Natureza de Operação *', array('class' => 'col-form-label'))) !!}
        {{Form::select('nature_operation_id', $Page->auxiliar['nature_operations'], old('nature_operation_id',(isset($Data) ? $Data->nature_operation_id : "")), ['placeholder' => 'Escolha a Natureza de Operação', 'class'=>'form-control show-tick', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        {!! Html::decode(Form::label('ncm_id', 'NCM *', array('class' => 'col-form-label'))) !!}
        {{Form::select('ncm_id', $Page->auxiliar['ncms'], old('ncm_id',(isset($Data) ? $Data->group_id : "")), ['placeholder' => 'Escolha o NCM', 'class'=>'form-control show-tick', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_origem', 'ICMS Origem', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_origem', old('icms_origem',(isset($Data) ? $Data->icms_origem : "")), ['placeholder'=>'ICMS Origem','class'=>'form-control', 'maxlength'=>'1', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_situacao_tributaria', 'ICMS Situação Tributária', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_situacao_tributaria', old('icms_situacao_tributaria',(isset($Data) ? $Data->icms_situacao_tributaria : "")), ['placeholder'=>'ICMS Situação Tributária','class'=>'form-control', 'maxlength'=>'3', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('pis_situacao_tributaria', 'Cód. PIS Situação Tributária', array('class' => 'col-form-label'))) !!}
        {{Form::text('pis_situacao_tributaria', old('pis_situacao_tributaria',(isset($Data) ? $Data->pis_situacao_tributaria : "")), ['placeholder'=>'Cód. PIS Situação Tributária','class'=>'form-control', 'maxlength'=>'2','required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('cofins_situacao_tributaria', 'Cód. COFINS Situação Tributária', array('class' => 'col-form-label'))) !!}
        {{Form::text('cofins_situacao_tributaria', old('cofins_situacao_tributaria',(isset($Data) ? $Data->cofins_situacao_tributaria : "")), ['placeholder'=>'Cód. COFINS Situação Tributária','class'=>'form-control', 'maxlength'=>'2','required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>



<div class="form-row">
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_base_calculo', 'ICMS Base Cálculo (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_base_calculo', old('icms_base_calculo',(isset($Data) ? $Data->icms_base_calculo_formatted : "")), ['placeholder'=>'ICMS Base Cálculo (%)','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_base_calculo_st', 'ICMS Base Cálculo ST (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_base_calculo_st', old('icms_base_calculo_st',(isset($Data) ? $Data->icms_base_calculo_st_formatted : "")), ['placeholder'=>'ICMS Base Cálculo ST (%)','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_valor_total', 'ICMS Valor Total (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_valor_total', old('icms_valor_total',(isset($Data) ? $Data->icms_valor_total_formatted : "")), ['placeholder'=>'ICMS Valor Total (%)','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('icms_valor_total_st', 'ICMS Valor Total ST (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('icms_valor_total_st', old('icms_valor_total_st',(isset($Data) ? $Data->icms_valor_total_st_formatted : "")), ['placeholder'=>'ICMS Valor Total ST (%)','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('valor_ipi', 'Valor IPI (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_ipi', old('valor_ipi',(isset($Data) ? $Data->valor_ipi_formatted : "")), ['placeholder'=>'Valor IPI (%)','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('valor_unitario_comercial', 'Valor Unitário Comercial (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_unitario_comercial', old('valor_unitario_comercial',(isset($Data) ? $Data->valor_unitario_comercial_formatted : "")), ['placeholder'=>'Valor Unitário Comercial (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('unidade_tributavel', 'Unidade Tributável (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('unidade_tributavel', old('unidade_tributavel',(isset($Data) ? $Data->unidade_tributavel_formatted : "")), ['placeholder'=>'Unidade Tributável (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('valor_unitario_tributavel', 'Valor Unitário Tributável (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_unitario_tributavel', old('valor_unitario_tributavel',(isset($Data) ? $Data->valor_unitario_tributavel_formatted : "")), ['placeholder'=>'Valor Unitário Tributável (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>


@section('script_content')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

@endsection


