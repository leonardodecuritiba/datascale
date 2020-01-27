@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

{{--@section('page_header-nav')--}}

{{--@include('pages.financial.billings.clients.menu.data')--}}

{{--@endsection--}}

@section('page_modals')

    <div class="modal fade in bg-danger" id="modal-billing-alert-delete" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Atenção! Deseja excluir o Faturamento?</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body"><h5>Esta ação é irreversível!</h5></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <a class="btn btn-label btn-primary"
                       href="{{route('billings.destroy', $Data->id)}}"><label><i class="ti-check"></i></label> Continuar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in bg-danger" id="modal-billing-alert" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Atenção! Deseja finalizar o Faturamento?</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body"><h5>Certifique que as notas e boletos foram geradas! Verifique também se as mesmas foram enviadas para o cliente!</h5></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                    <a class="btn btn-label btn-primary"
                       href="{{route('billings.close', $Data->id)}}"><label><i class="ti-check"></i></label> Continuar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show " id="modal-pay-portion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {!! Form::open(['route' => ['billings.set.portion'],
                    'method' => 'POST',
                    'class' => 'form-horizontal form-label-left', 'data-parsley-validate']) !!}

                    <div class="modal-header">
                        <h4 class="modal-title">Pagamento de parcela</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {{Form::hidden('id', NULL)}}

                        <div class="row">
                            <div class="col-md-12">
                                <dl class="row">
                                    <dt class="col-sm-9">Valor</dt>
                                    <dd class="col-sm-3 text-success" id="value">R$ 100,00</dd>

                                    <dt class="col-sm-9">Vencimento</dt>
                                    <dd class="col-sm-3" id="due_at">25/05/1987</dd>

                                    <dt class="col-sm-9">Forma de Pagamento</dt>
                                    <dd class="col-sm-3" id="payment_form"></dd>
                                </dl>
                            </div>
                        </div>

                        <hr class="hr-sm mb-2">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('paid_at', 'Data de Pagamento', array('class' => 'col-form-label'))) !!}
                                    {{Form::text('paid_at', \Carbon\Carbon::now()->format('d/m/Y'), ['id'=>'paid_at','placeholder'=>'Data de Pagamento','class'=>'form-control data-every', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                        <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Confirmar</button>
                    </div>


                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade show " id="modal-view-nf" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Consultar <b></b> - <i></i></h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <ul class="list-unstyled listas_nf">
                            <li><i class="fa fa-info"></i> Ref.: <b id="ref"></b></li>
                            <li><i class="fa fa-info"></i> Status: <b id="status"></b></li>

                            <div id="sefaz">
                                <li><i class="fa fa-info"></i> Status SEFAZ: <b id="status_sefaz"></b></li>
                                <li><i class="fa fa-info"></i> Mensagem SEFAZ: <b id="mensagem_sefaz"></b></li>
                            </div>

                            <div id="nfe">
                                <li><i class="fa fa-info"></i> Chave: <b id="chave_nfe"></b></li>
                                <li><i class="fa fa-info"></i> Número/Série: <b id="numero_serie"></b></li>
                                <li>
                                    <a target="_blank" id="url_pdf" class="btn btn-info btn-xs"><i class="fa fa-file"></i> Abrir PDF</a>
                                    <a target="_blank" id="url_xml" class="btn btn-info btn-xs"><i class="fa fa-file-text"></i> Abrir XML</a>
                                </li>
                            </div>

                            <div id="nfse">
                                <li><i class="fa fa-info"></i> Código Verificação: <b
                                            id="codigo_verificacao"></b></li>
                                <li><i class="fa fa-info"></i> Data Emissão: <b id="data_emissao"></b></li>
                                <li><i class="fa fa-info"></i> Número: <b id="numero"></b></li>
                                <li>
                                    <a target="_blank" id="url_pdf" class="btn btn-info btn-xs"><i class="fa fa-file"></i> Abrir PDF</a>
                                    <a target="_blank" id="url_xml" class="btn btn-info btn-xs"><i class="fa fa-file-text"></i> Abrir XML</a>
                                </li>
                            </div>

                            {{--<span id="email">--}}
                                {{--{!! Form::open(array('route'=>['fiscals.nf.send-email', 'XXX'] ))!!}--}}
                                    {{--<a class="btn btn-a btn-label btn-success btn-xs btn-enviar-nota-cliente"><i--}}
                                            {{--class="fa fa-envelope"></i> Enviar Para Cliente</a>--}}
                                {{--{!!Form::close()!!}--}}
                            {{--</span>--}}
                        </ul>
                        <ul class="list-unstyled erros_nf">
                            <li><i class="fa fa-info"></i> Ref.: <b id="ref"></b></li>
                            <li><i class="fa fa-info"></i> Código: <b id="codigo"></b></li>
                            <li><i class="fa fa-info"></i> Mensagem: <b id="mensagem"></b></li>
                        </ul>

                        <div id="cancelamento" class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => ['fiscals.nf.cancel','_ID_','_DEBUG_','_TYPE_'],
                                    'method' => 'POST', 'data-parsley-validate']) !!}
                                    <label>Justificativa: <span class="required">*</span></label>
                                    <textarea required="required" class="form-control"
                                              name="reason"
                                              rows="3"
                                              placeholder="Justificativa de cancelamento"
                                    ></textarea>
                                    <button class="btn btn-danger pull-right"><i class="fa fa-times fa-2"></i>
                                        Confirmar Cancelamento
                                    </button>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <a id="btn-refresh" class="btn btn-a btn-label btn-success pull-left"><label><i class="fa fa-refresh"></i></label> Reenviar</a>
                        <button id="btn-cancel" class="btn btn-label btn-warning pull-left"><label><i class="fa fa-times fa-2"></i></label> Cancelar Nota</button>
                        <button class="btn btn-secondary pull-right" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
                @include('layouts.inc.loading')
            </div>
        </div>
    </div>

@endsection
@section('page_content')

    <div class="main-content">

    @include('layouts.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">

            <h4 class="card-title"><strong>Faturamento #{{$Data->id}}</strong>
                @if($Data->canShowDeleteBtn())
                    <button data-toggle="modal"
                            data-target="#modal-billing-alert-delete"
                            class="btn btn-a btn-danger pull-right ml-2">
                        <i class="fa fa-trash fa-2"></i> Excluir Faturamento</button>
                @endif
                @if($Data->canShowFinishBtn())
                    <button data-toggle="modal"
                            data-target="#modal-billing-alert"
                            class="btn btn-a btn-success pull-right ml-2">
                        <i class="fa fa-check"></i> Finalizar Faturamento</button>
                @endif
                @if($Data->canShowNFBtn())
                    <div class="btn-group pull-right ml-2">
                        <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">NFe</button>
                        <div class="dropdown-menu">
                            @if($Data->canShowGenerateHomologationNFeBtn())
                                <a class="dropdown-item" href="{{route('fiscals.nf.send',[$Data->id,$debug = true, 'nfe'])}}">
                                    <i class="fa fa-info fa-2"></i> Gerar NFe (Homologação)</a>
                            @endif
                            @if($Data->canShowViewHomologationNFeBtn())
                                <a class="dropdown-item" href="#"
                                   data-toggle="modal"
                                   data-billing_id="{{$Data->id}}"
                                   data-type="nfe"
                                   data-target="#modal-view-nf"
                                   data-debug="1"><i class="fa fa-search fa-2"></i> Consultar NFe (Homologação)</a>
                            @endif
                            @if($Data->canShowGenerateNFeBtn())
                                <a class="dropdown-item" href="{{route('fiscals.nf.send',[$Data->id,$debug = 0, 'nfe'])}}">
                                    <i class="fa fa-info fa-2"></i> Gerar NFe</a>
                            @endif
                            @if($Data->canShowViewNFeBtn())
                                <a class="dropdown-item" href="#"
                                   data-toggle="modal"
                                   data-billing_id="{{$Data->id}}"
                                   data-type="nfe"
                                   data-target="#modal-view-nf"
                                   data-debug="0"><i class="fa fa-search fa-2"></i> Consultar NFe</a>
                            @endif
                        </div>
                    </div>
                @endif
                @if($Data->canShowNFBtn())
                    <div class="btn-group pull-right ml-2">
                        <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">NFSe</button>
                        <div class="dropdown-menu">
                            @if($Data->canShowGenerateHomologationNFSeBtn())
                                <a class="dropdown-item" href="{{route('fiscals.nf.send',[$Data->id,$debug = true, 'nfse'])}}">
                                    <i class="fa fa-info fa-2"></i> Gerar NFSe (Homologação)</a>
                            @endif
                            @if($Data->canShowViewHomologationNFSeBtn())
                                <a class="dropdown-item" href="#"
                                   data-toggle="modal"
                                   data-billing_id="{{$Data->id}}"
                                   data-type="nfse"
                                   data-target="#modal-view-nf"
                                   data-debug="1"><i class="fa fa-search fa-2"></i> Consultar NFSe (Homologação)</a>
                            @endif
                            @if($Data->canShowGenerateNFSeBtn())
                                    <a class="dropdown-item" href="{{route('fiscals.nf.send',[$Data->id,$debug = 0, 'nfse'])}}">
                                        <i class="fa fa-info fa-2"></i> Gerar NFSe</a>
                            @endif
                            @if($Data->canShowViewNFSeBtn())
                                <a class="dropdown-item" href="#"
                                   data-toggle="modal"
                                   data-billing_id="{{$Data->id}}"
                                   data-type="nfse"
                                   data-target="#modal-view-nf"
                                   data-debug="0"><i class="fa fa-search fa-2"></i> Consultar NFSe</a>
                            @endif
                        </div>
                    </div>
                @endif
            </h4>

            <div class="card-body">

                <div class="alert alert-{{$Data->status_color}}" role="alert">
                    Situação: <strong>{{$Data->status_text}}</strong>
                </div>

                <h6 class="text-uppercase mt-3">Informações</h6>
                <hr class="hr-sm mb-2">
                <dl class="row">
                    <dt class="col-sm-2">ID</dt>
                    <dd class="col-sm-4">{{$Data->id}} ({{$Data->idfaturamentos}})</dd>

                    <dt class="col-sm-2">Cliente</dt>
                    <dd class="col-sm-4"><a href="{{route('clients.edit',$Data->client_id)}}"
                                            target="_blank">{{$Data->client->fantasy_name_text}}</a></dd>

                    <dt class="col-sm-2">Data de Fechamento</dt>
                    <dd class="col-sm-4">{{$Data->created_at_full_formatted}}</dd>

                    <dt class="col-sm-2">Tipo de Emissão (Técnica)</dt>
                    <dd class="col-sm-4">{{$Data->client->getTechnicalBillingIssueTypeText()}}</dd>

                    <dt class="col-sm-2">Forma de Pagamento (Técnica)</dt>
                    <dd class="col-sm-4">{{$Data->client->getTechnicalPaymentFormText()}}</dd>

                    <dt class="col-sm-2">Pagamento</dt>
                    <dd class="col-sm-4"><b
                                class="text-{{$Data->getPaymentStatusColor()}}">{{$Data->getPaymentStatusText()}}</b>
                    </dd>

                    <dt class="col-sm-2">Total Pendente</dt>
                    <dd class="col-sm-4"><b class="text-danger">{{$Data->getTotalPendentFormatted()}}</b></dd>

                    <dt class="col-sm-2">Total Recebido</dt>
                    <dd class="col-sm-4"><b class="text-success">{{$Data->getTotalReceivedFormatted()}}</b></dd>


                </dl>

                <h6 class="text-uppercase mt-3">Valores</h6>
                <hr class="hr-sm mb-2">


                @include('pages.transactions.technical_operations.orders.list.values', ['values' => $Data->getResumedValuesArray()])

            </div>
        </div>

        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Portions
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            <h4 class="card-title"><strong>{{$Data->payment->portions->count()}}</strong> Parcela</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Situação</th>
                            <th>Parcela</th>
                            <th>Forma de Pagamento</th>
                            <th>Data de Vencimento</th>
                            <th>Data de Pagamento</th>
                            <th>Data de Baixa</th>
                            <th>Valor</th>
                            <th width="30px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Situação</th>
                            <th>Parcela</th>
                            <th>Forma de Pagamento</th>
                            <th>Data de Vencimento</th>
                            <th>Data de Pagamento</th>
                            <th>Data de Baixa</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse($Data->payment->portions as $sel)
                            <tr>
                                <td>{{$sel['id']}}</td>
                                <td><span class="badge badge-{{$sel['status_color']}} badge-md">
                                    {{$sel['status_text']}}</span>
                                </td>
                                <td>{{$sel->getPortionNumberText()}}</td>
                                <td>{{$sel['payment_form_text']}}</td>
                                <td>{{$sel['due_at_formatted']}}</td>
                                <td>{{$sel['paid_at_formatted']}}</td>
                                <td>{{$sel['setted_at_formatted']}}</td>
                                <td>{{$sel['portion_value_formatted']}}</td>
                                <td>
                                    @if(!$sel->received())
                                        <button data-toggle="modal"
                                           data-portion="{{$sel}}"
                                           data-value_formatted="{{$sel['portion_value_formatted']}}"
                                           data-target="#modal-pay-portion"
                                           class="btn btn-square btn-xs btn-outline btn-info"><i class="fa fa-money"></i></button>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('layouts.inc.loading')
        </div>

        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | O.S
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->

        @include('pages.financial.billings.list.orders', ['Orders' => $Data->orders])
    </div><!--/.main-content -->

@endsection

@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

    <script type="text/javascript">
        $(document).ready(function () {
            //MODAL DA FORMA DE PAGAMENTO
            $('#modal-pay-portion').on('show.bs.modal', function (event) {
                var $button = $(event.relatedTarget);
                var $parent = $(this).find('div.modal-body');
                var $portion = $($button).data('portion');
                console.log($portion);
                $($parent ).find('input[name=id]').val($portion.id);
                $($parent ).find('dd#value').html($($button).data('value_formatted'));
                $($parent ).find('dd#due_at').html($portion.due_at_formatted);
                $($parent ).find('dd#payment_form').html($portion.payment_form_text);
            });
        });
    </script>

    <!-- Fiscals -->
    @include('layouts.inc.fiscal.nf')

@endsection
