<div class="modal modal-fill" id="changePrice" tabindex="-1" role="dialog" aria-labelledby="changePrice"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Preço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{Form::open(
            array(
                'route' => 'prices.parts.update',
                'method'=>'POST',
                'class'=>'form-horizontal'
            )
            )}}
            <div class="modal-body">
                {{Form::hidden('id', '')}}
                <div class="row">
                    <div class="col-md-8">
                        <h5>Peça</h5>
                        <span id="part-name">
                            <a href="#">PEÇASDASD</a>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <h5>Preço</h5>
                        <span id="part-price">
                            <p>R$</p>
                        </span>
                    </div>
                </div>

                <hr>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Html::decode(Form::label('price', 'Preço *', array('class' => 'col-form-label'))) !!}
                        {{Form::text('price', "", ['placeholder'=>'Preço','class'=>'form-control show-price','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Html::decode(Form::label('range', 'Margem *', array('class' => 'col-form-label'))) !!}
                        {{Form::text('range', "", ['placeholder'=>'Margem','class'=>'form-control show-percent','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        {!! Html::decode(Form::label('price_min', 'Preço Mínimo *', array('class' => 'col-form-label'))) !!}
                        {{Form::text('price_min', "", ['placeholder'=>'Preço Mínimo','class'=>'form-control show-price','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Html::decode(Form::label('range_min', 'Margem Mínima *', array('class' => 'col-form-label'))) !!}
                        {{Form::text('range_min', "", ['placeholder'=>'Margem Mínima','class'=>'form-control show-percent','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                        <div class="invalid-feedback"></div>
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>