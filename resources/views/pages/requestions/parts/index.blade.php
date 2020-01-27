@extends('layouts.admin.app')

@section('title', 'Metas')

{{--@section('route', route('cliente'))--}}

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

@endsection

@section('page_modals')

    <div id="janela1" class="modal fade">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Requerer Peça</h5>

                    <button class="close" data-dismiss="modal"><span>&times;</span></button>

                </div>

                <div class="modal-body">

                    <div class="form-group col-md-12">
                        <label for="peca" class="col-form-label">Peça:*</label>
                        <select name="peca" class="custom-select">
                            <option>Selecione</option>
                            <option>PCI PRINCIPAL IDM LED - LCD REV - FIZIOLA</option>

                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="razao" class="col-form-label">Razão:*</label>
                        <textarea name="razao" class="form-control" rows="5" placeholder="Razão"></textarea>
                    </div>


                </div>

                <div class="modal-footer">

                    <button class="btn btn-success" onClick="salvar()">Salvar
                    </button>

                </div>


            </div>

        </div>


    </div>

    <div id="janela2" class="modal fade">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Requerer Peça</h5>

                    <button class="close" data-dismiss="modal"><span>&times;</span></button>

                </div>

                <div class="modal-body">

                    <div class="form-group col-md-12">
                        <label for="peca" class="col-form-label">Peça:*</label>
                        <select name="peca" class="custom-select">
                            <option>Selecione</option>
                            <option>PCI PRINCIPAL IDM LED - LCD REV - FIZIOLA</option>

                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="razao" class="col-form-label">Razão:*</label>
                        <textarea name="razao" class="form-control" rows="5" placeholder="Razão"></textarea>
                    </div>


                </div>

                <div class="modal-footer">

                    <button class="btn btn-success" onClick="salvar()">Salvar
                    </button>

                </div>


            </div>

        </div>


    </div>

@endsection

@section('page_content')

    <div class="main-content"><!--/.main-content -->

        <div class="card">

            <div class="card-title d-flex justify-content-between">
                <h4><strong>{{'0'}}</strong> Peças encontradas</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#janela1">Requerer</button>
            </div>
            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Responsável</th>
                            <th>Custo</th>
                            <th width="150px">Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Responsável</th>
                            <th>Custo</th>
                            <th width="150px">Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        {{--@forelse($Page->response as $sel)--}}
                            <tr>
                                <td>{{'1'}}</td>
                                <td>{{'Descrição'}}</td>
                                <td>{{'Responsável'}}</td>
                                <td>{{'Custo'}}</td>

                                <td>
                                    <a href="#"
                                       class="btn btn-simple btn-success btn-xs btn-icon"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="Faturar"
                                    ><i class="material-icons">edit</i>
                                    </a>
                                </td>
                            </tr>
                            {{--@endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
            @include('layouts.inc.loading')

        </div>

        <div class="card">

            <div class="card-title d-flex justify-content-between">

            <h4><strong>{{'2'}} Requisições de Peças encontrados!</strong></h4>

            </div>

                <div class="card-content">

                    <div class="card-body">


                        <table class="table table-striped table-responsive-xl table-bordered text-dark" cellspacing="0" data-provide="datatables"">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Tipo Requisição</th>
                                    <th>Requisição</th>
                                    <th>Razão</th>
                                    <th>Gestor</th>
                                    <th>Retorno</th>
                                </tr>

                            </thead>
                            <tfoot>

                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Tipo Requisição</th>
                                    <th>Requisição</th>
                                    <th>Razão</th>
                                    <th>Gestor</th>
                                    <th>Retorno</th>
                                </tr>

                            </tfoot>

                            <tbody>

                                <tr>
                                    <td>{{'123'}}</td>
                                    <td><span class="badge badge-warning badge-md">
                                         {{'AGUARDANDO'}}</span>
                                    <td>{{'00:00 - 28/01/2019'}}</td>
                                    <td>{{'PEÇAS'}}</td>
                                    <td>{{'Peça: PCI PRINCIPAL IDM LED - LCD REV - FILIZOLA'}}</td>
                                    <td>{{'FDS'}}</td>
                                    <td>{{'-'}}</td>
                                    <td>{{' '}}</td>
                                </tr>

                                <tr>
                                    <td>{{'123'}}</td>
                                    <td><span class="badge badge-warning badge-md">{{'AGUARDANDO'}}</span></td>
                                    <td>{{'00:00 - 28/01/2019'}}</td>
                                    <td>{{'PEÇAS'}}</td>
                                    <td>{{'Peça: PCI PRINCIPAL IDM LED - LCD REV - FILIZOLA'}}</td>
                                    <td>{{'FDS'}}</td>
                                    <td>{{'-'}}</td>
                                    <td>{{' '}}</td>
                                </tr>



                            </tbody>

                        </table>

                       





                    </div>

                </div>

        </div>
        
    </div><!--/.main-content -->

@endsection
