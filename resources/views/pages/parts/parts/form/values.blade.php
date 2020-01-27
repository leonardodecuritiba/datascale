
<h6 class="text-uppercase mt-3">Valores</h6>
<hr class="hr-sm mb-2">

<div class="form-row">
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('valor_frete', 'Valor Frete (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_frete', old('valor_frete',(isset($Data) ? $Data->valor_frete_formatted : "")), ['placeholder'=>'Valor Frete (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('valor_seguro', 'Valor Seguro (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_seguro', old('valor_seguro',(isset($Data) ? $Data->valor_seguro_formatted : "")), ['placeholder'=>'Valor Seguro (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('technical_commission', 'Comissão Técnica (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('technical_commission', old('technical_commission',(isset($Data) ? $Data->technical_commission_formatted : "")), ['placeholder'=>'Comissão Técnica','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('seller_commission', 'Comissão Venda (%)', array('class' => 'col-form-label'))) !!}
        {{Form::text('seller_commission', old('seller_commission',(isset($Data) ? $Data->seller_commission_formatted : "")), ['placeholder'=>'Comissão Venda','class'=>'form-control show-percent', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group col-md-6">
        {!! Html::decode(Form::label('valor_total', 'Valor Total (R$)', array('class' => 'col-form-label'))) !!}
        {{Form::text('valor_total', old('valor_total',(isset($Data) ? $Data->valor_total_formatted : "")), ['placeholder'=>'valor_total (R$)','class'=>'form-control show-price', 'required'])}}
        <div class="invalid-feedback"></div>
    </div>
</div>


<h6 class="text-uppercase mt-3 mb-5">Tabela Preço</h6>

<?php $prices = isset($Data) ? $Data->prices : $Page->extras['prices'];?>
@foreach($prices as $price)
    <h5 class="text-uppercase mt-3 text-muted">{{$price->getPriceTableName()}}</h5>
    <hr class="hr-sm mb-2">

    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('range', 'Margem', array('class' => 'col-form-label'))) !!}
            {{Form::text('range', old('range',(isset($Data) ? $price->range_field : "")), ['placeholder'=>'0,00 %','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('price', 'Preço Venda (R$)', array('class' => 'col-form-label'))) !!}
            {{Form::text('price', old('price',(isset($Data) ? $price->price_field : "")), ['placeholder'=>'R$ 0,00','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>


    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('range_min', 'Margem Mínima', array('class' => 'col-form-label'))) !!}
            {{Form::text('range_min', old('range_min',(isset($Data) ? $price->range_min_field : "")), ['placeholder'=>'0,00 %','class'=>'form-control show-percent', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('price_min', 'Preço Venda Mínimo (R$)', array('class' => 'col-form-label'))) !!}
            {{Form::text('price_min', old('price_min',(isset($Data) ? $price->price_min_field : "")), ['placeholder'=>'R$ 0,00','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>


@endforeach
