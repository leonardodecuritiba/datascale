@if($apparatu->hasLabelSetted())

    <div class="row">
        <dt class="col-md-3 fs-14">Marca de Reparo Retirada</dt>
        <dd class="col-md-3 fw-500 text-info">{{$apparatu->getNumberLabelUnsetted()['text']}}</dd>
        <dt class="col-md-3 fs-14">Marca de Reparo Afixada</dt>
        <dd class="col-md-3 fw-500 text-info">{{$apparatu->getNumberLabelSetted()['text']}}</dd>
    </div>

@else

    <div class="row">
        <dt class="col-md-3 fs-14">Marca de Reparo</dt>
        <dd class="col-md-9"><span class="badge badge-xl badge-danger btn-block"><b>Atenção!</b> Nenhuma Marca de Reparo Retirada</span></dd>
    </div>

@endif

@if($apparatu->hasSealsSetted())

    <div class="row">
        <dt class="col-md-3 fs-14">Lacres Retirados</dt>
        <dd class="col-md-3 fw-500 text-info">{{$apparatu->getNumberSealsUnsetted()['text']}}</dd>
        <dt class="col-md-3 fs-14">Lacres Afixados</dt>
        <dd class="col-md-3 fw-500 text-info">{{$apparatu->getNumberSealsSetted()['text']}}</dd>
    </div>

@else

    <div class="row">
        <dt class="col-md-3 fs-14">Lacres</dt>
        <dd class="col-md-9"><span class="badge badge-xl badge-danger btn-block"><b>Atenção!</b> Nenhum Lacre Retirado</span></dd>
    </div>

@endif