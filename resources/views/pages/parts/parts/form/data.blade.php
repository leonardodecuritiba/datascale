<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

    <h6 class="text-uppercase mt-3">Informações</h6>
    <hr class="hr-sm mb-2">

    {{--Picture--}}
    @include('layouts.part.picture')

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('description', 'Descrição Principal *', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('technical_description', 'Descrição Tecnica *', array('class' => 'col-form-label'))) !!}
            {{Form::text('technical_description', old('technical_description',(isset($Data) ? $Data->technical_description : "")), ['placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('provider_id', 'Fornecedor *', array('class' => 'col-form-label'))) !!}
            {{Form::select('provider_id', $Page->auxiliar['providers'], old('provider_id',(isset($Data) ? $Data->provider_id : "")), ['placeholder' => 'Escolha o Fornecedor', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('group_id', 'Grupo *', array('class' => 'col-form-label'))) !!}
            {{Form::select('group_id', $Page->auxiliar['groups'], old('group_id',(isset($Data) ? $Data->group_id : "")), ['placeholder' => 'Escolha o Grupo', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('sub_group', 'Subgrupo', array('class' => 'col-form-label'))) !!}
            {{Form::text('sub_group', old('sub_group',(isset($Data) ? $Data->sub_group : "")), ['placeholder'=>'Subgrupo','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('bar_code', 'Código de Barras *', array('class' => 'col-form-label'))) !!}
            {{Form::text('bar_code', old('bar_code',(isset($Data) ? $Data->bar_code : "")), ['placeholder'=>'Código de Barras','class'=>'form-control','minlength'=>'3', 'maxlength'=>'50', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-5">
            {!! Html::decode(Form::label('auxiliar_code', 'Código Auxiliar', array('class' => 'col-form-label'))) !!}
            {{Form::text('auxiliar_code', old('auxiliar_code',(isset($Data) ? $Data->auxiliar_code : "")), ['placeholder'=>'Código Auxiliar','class'=>'form-control','minlength'=>'3', 'maxlength'=>'50', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-2">
            {!! Html::decode(Form::label('type', 'Tipo*', array('class' => 'col-form-label'))) !!}
            {{Form::select('type', $Page->auxiliar['types'], old('type',(isset($Data) ? $Data->type : "")), ['placeholder' => 'Escolha o Tipo', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('brand_id', 'Marca *', array('class' => 'col-form-label'))) !!}
            {{Form::select('brand_id', $Page->auxiliar['brands'], old('brand_id',(isset($Data) ? $Data->brand_id : "")), ['placeholder' => 'Escolha a Marca', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('unity_id', 'Unidade *', array('class' => 'col-form-label'))) !!}
            {{Form::select('unity_id', $Page->auxiliar['unities'], old('unity_id',(isset($Data) ? $Data->unity_id : "")), ['placeholder' => 'Escolha a Unidade', 'class'=>'form-control show-tick', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('warranty', 'Garantia', array('class' => 'col-form-label'))) !!}
            {{Form::text('warranty', old('warranty',(isset($Data) ? $Data->warranty : "")), ['placeholder'=>'Garantia','class'=>'form-control','minlength'=>'1', 'maxlength'=>'3', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    @include('pages.parts.parts.form.taxation')

    @include('pages.parts.parts.form.values')


<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>
 

   
@section('script_content')

    <!-- MaskMoney Js -->
    @include('layouts.inc.maskmoney.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

@endsection