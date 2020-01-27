<div class="p-2 mb-3" style="border: 2px dashed #e0e0e0; ">

    <div class="d-flex justify-content-between">
        <span>Total em Serviços:</span>
        <span class="data-info" id="services">{{optional(optional($values))['services']}}</span>
    </div>

    <div class="d-flex justify-content-between">
        <span>Total em Peças/Produtos:</span>
        <span class="data-info" id="parts">{{optional($values)['parts']}}</span>
    </div>

    <div class="d-flex justify-content-between text-danger">
        <span class="text-info">Descontos:</span>
        <span class="text-info data-info" id="discount_tec">{{optional($values)['increase_tec']}}</span>
    </div>

    <div class="d-flex justify-content-between text-primary">
        <span class="text-danger">Acréscimos:</span>
        <span class="text-danger data-info" id="increase_tec">{{optional($values)['discount_tec']}}</span>
    </div>

    <hr class="hr-sm mb-2">

    <div class="d-flex justify-content-between">
        <span class="fw-500">Valor Total:</span>
        <span class="data-info fw-500" id="total_value">{{optional($values)['total_value']}}</span>
    </div>

</div>

<div class="p-2 mb-3" style="border: 2px dashed #e0e0e0; ">

    <div class="d-flex justify-content-between">
        <span>Deslocamentos:</span>
        <span class="data-info" id="travel_cost">{{optional($values)['travel_cost']}}</span>
    </div>

    <div class="d-flex justify-content-between">
        <span>Pedágios:</span>
        <span class="data-info" id="tolls">{{optional($values)['tolls']}}</span>
    </div>

    <div class="d-flex justify-content-between">
        <span>Outros Custos:</span>
        <span class="data-info" id="other_cost">{{optional($values)['other_cost']}}</span>
    </div>

</div>

<div class="p-2" style="border: 2px dashed #e0e0e0; ">
    <div class="d-flex justify-content-between">
        <span class="fw-500">Valor Final:</span>
        <span class="fw-500 text-success data-info" id="final_value">{{optional($values)['final_value']}}</span>
    </div>
</div>