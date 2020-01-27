@extends('layouts.admin.app')

@section('title', $Page->title)

@section('style_content')
    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}
@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layouts.inc.breadcrumb')

@endsection

@section('page_content')
    <!-- Main container -->
    <div class="main-content">


    @include('layouts.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            @if(isset($Data))
                <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong></h4>
            @else
                <h4 class="card-title"><strong>Dados do {{$Page->name}}</strong></h4>
            @endif
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="informations-tab" data-toggle="tab" href="#informations" role="tab" aria-controls="informations" aria-selected="true">Informações</a>
                    </li>
                    @if(isset($Data))
                        <li class="nav-item">
                            <a class="nav-link" id="equipments-tab" data-toggle="tab" href="#equipments" role="tab" aria-controls="equipments" aria-selected="false">Equipamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="instruments-tab" data-toggle="tab" href="#instruments" role="tab" aria-controls="instruments" aria-selected="false">Instrumentos</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">
                        @if(isset($Data))
                            {{Form::model($Data,
                            array(
                                'route' => ['clients.update', $Data->id],
                                'method'=>'PATCH',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @else
                            {{Form::open(array(
                                'route' => ['clients.store'],
                                'method'=>'POST',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @endif
                        @include('pages.human_resources.clients.form.data')
                        {{Form::close()}}
                    </div>
                    @if(isset($Data))
                        <div class="tab-pane fade" id="equipments" role="tabpanel" aria-labelledby="equipaments-tab">
                            @include('pages.human_resources.clients.equipments.index')
                        </div>
                        <div class="tab-pane fade" id="instruments" role="tabpanel" aria-labelledby="instruments-tab">
                            @include('pages.human_resources.clients.instruments.index')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}

    <!-- Address Layout Js -->
    @include('layouts.part.address.js')

    <!-- Jquery Validation Plugin Js -->
    @include('layouts.inc.validation.js')

    <!-- LegalPeople Layout Js -->
    @include('layouts.part.legal_person.js')

    <!-- Jquery InputMask Js -->
    @include('layouts.inc.inputmask.js')

    <script>

        $("div#modal-equipment").on("hide.bs.modal", function (event) {
            $(this).find('input#description').val('');
            $(this).find('input#serial_number').val('');
            $(this).find('input#model').val('');
            $(this).find('select#brand_id').val('');
            $(this).find('img#image').attr('src', '');
            $(this).find('div#image-div').removeClass('d-flex').addClass('d-none');
        });

        $("div#modal-equipment").on("show.bs.modal", function (event) {
            var $button = $(event.relatedTarget);
            var $parent = $(this).find('div.modal-body');
            var $url = "{{route('equipments.store')}}";

            if($($button).data('type') == 'edit'){
                var $url = "{{route('equipments.update')}}";
                $.ajax({
                    url: "{{route('ajax.equipments.values')}}",
                    type: 'GET',
                    dataType: "json",
                    data: {id : $($button).data('id')},
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    beforeSend: function () {
                        loadingCard('show', $($parent));
                    },
                    complete: function () {
                        loadingCard('hide', $($parent));
                    },
                    success: function (result) {

                        //IMPRIMINDO NO LOG DO BROWSER OS DADOS DO EQUIPAMENTO
                        console.log(result);

                        //PEGANDO OS DADOS DO EQUIPAMENTO DO AJAX
                        var equipment = result.data.equipment;

                        //PROCURANDO O CAMPO NO MODAL, E DEFININDO O VALOR POR MEIO DO RESULTADO DO AJAX
                        $($parent).find('input#description').val(equipment.description);
                        $($parent).find('input#serial_number').val(equipment.serial_number);
                        $($parent).find('input#model').val(equipment.model);
                        $($parent).find('select#brand_id').val(equipment.brand_id);

                        if(equipment.image != null){
                            $($parent).find('img#image').attr('src', equipment.image); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#image').show();
                            $($parent).find('div#image-div').removeClass('d-none').addClass('d-flex');
                        } else {
                            $($parent).find('img#image').attr('src', ''); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#image').hide();
                        }

                        //ATUALIZANDO O FORM

                        $($parent).closest('form').attr('action', $url);
                        $($parent).closest('form').find('input[name=id]').val(equipment.id);
                    }
                });
            } else {
                $($parent).closest('form').attr('action', $url);
                $($parent).closest('form').find('input[name=id]').val(0);
            }

        });

    </script>

    <script>

        $("div#modal-instrument").on("hide.bs.modal", function (event) {
            $(this).find('select#pam_id').val('');
            $(this).find('select#instrument_setor_id').val('');
            $(this).find('input#serial_number').val('');
            $(this).find('input#year').val('');
            $(this).find('input#inventory').val('');
            $(this).find('input#patrimony').val('');
            $(this).find('input#ip').val('');
            $(this).find('input#address').val('');
            $(this).find('input[name=label_inventory]').val('');
            $(this).find('input[name=identification_label]').val('');

            $(this).find('img#image').attr('src', '');

            $(this).find('div#image-div').removeClass('d-flex').addClass('d-none');

            $(this).find('div#label_inventory_image-div').removeClass('d-flex').addClass('d-none');
            $(this).find('div#label_identification_image-div').removeClass('d-flex').addClass('d-none');
        });

        $("div#modal-instrument").on("show.bs.modal", function (event) {
            var $button = $(event.relatedTarget);
            var $parent = $(this).find('div.modal-body');
            var $url = "{{route('instruments.store')}}";

            if($($button).data('type') == 'edit'){
                var $url = "{{route('instruments.update')}}";
                $.ajax({
                    url: "{{route('ajax.instruments.values')}}",
                    type: 'GET',
                    dataType: "json",
                    data: {id: $($button).data('id')},
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    beforeSend: function () {
                        loadingCard('show', $($parent));
                    },
                    complete: function () {
                        loadingCard('hide', $($parent));
                    },
                    success: function (result) {
                        // loadingCard('hide',$($parent).find('dl.row'));

                        //IMPRIMINDO NO LOG DO BROWSER OS DADOS DO INSTRUMENTO
                        console.log(result);

                        //PEGANDO OS DADOS DO INSTRUMENTO DO AJAX
                        var instrument = result.data.instrument;

                        //PROCURANDO O CAMPO NO MODAL, E DEFININDO O VALOR POR MEIO DO RESULTADO DO AJAX
                        $($parent).find('select#pam_id').val(instrument.pam_id);
                        $($parent).find('select#instrument_setor_id').val(instrument.instrument_setor_id);
                        $($parent).find('input#serial_number').val(instrument.serial_number);
                        $($parent).find('input#year').val(instrument.year);
                        $($parent).find('input#inventory').val(instrument.inventory);
                        $($parent).find('input#patrimony').val(instrument.patrimony);
                        $($parent).find('input#ip').val(instrument.ip);
                        $($parent).find('input#address').val(instrument.address);

                        if (instrument.image != null) {
                            $($parent).find('img#image').attr('src', instrument.image); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#image').removeClass('hidex');
                            $($parent).find('div#image-div').removeClass('d-none').addClass('d-flex');
                        } else {
                            $($parent).find('img#image').attr('src', ''); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#image').addClass('hidex');
                        }


                        if (instrument.label_inventory_image != null) {
                            $($parent).find('img#label_inventory_image').attr('src', instrument.label_inventory_image); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#label_inventory_image').removeClass('hidex');
                            $($parent).find('div#label_inventory_image-div').removeClass('d-none').addClass('d-flex');
                        } else {
                            $($parent).find('img#label_inventory_image').attr('src', ''); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#label_inventory_image').addClass('hidex');
                            $($parent).find('div#label_inventory_image-div').removeClass('d-flex').addClass('d-none');
                        }


                        if (instrument.label_identification_image != null) {
                            $($parent).find('img#label_identification_image').attr('src', instrument.label_identification_image); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#label_identification_image').removeClass('hidex');
                            $($parent).find('div#label_identification_image-div').removeClass('d-none').addClass('d-flex');
                        } else {
                            $($parent).find('img#label_identification_image').attr('src', ''); //VERIFICAR QUE A IMAGEM VEM NO RETORNO DO JSON
                            $($parent).find('img#label_identification_image').addClass('hidex');
                            $($parent).find('div#label_identification_image-div').removeClass('d-flex').addClass('d-none');
                        }

                        //ATUALIZANDO O FORM
                        $($parent).closest('form').attr('action', $url);
                        $($parent).closest('form').find('input[name=id]').val(instrument.id);
                    }
                });
            } else {
                $($parent).closest('form').attr('action', $url);
                $($parent).closest('form').find('input[name=id]').val(0);
            }

        });

    </script>

@endsection