<div class="card">
    <h4 class="card-title"><strong>{{$Orders->count()}}</strong> Ordem de Serviço</h4>

    <div class="card-content">
        <div class="card-body">

            <table class="table table-striped table-bordered table-responsive-lg" cellspacing="0"
                   data-provide="datatables">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Situação</th>
                    <th>Abertura</th>
                    <th>Finalização</th>
                    <th>Técnico</th>
                    <th>Serviços</th>
                    <th>Peças</th>
                    <th>Desc. (Tec)</th>
                    <th>Acres. (Tec)</th>
                    <th>Total</th>
                    <th>Cliente</th>
                    <th width="30px">Ações</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Situação</th>
                    <th>Abertura</th>
                    <th>Finalização</th>
                    <th>Técnico</th>
                    <th>Serviços</th>
                    <th>Peças</th>
                    <th>Desc. (Tec)</th>
                    <th>Acres. (Tec)</th>
                    <th>Total</th>
                    <th>Cliente</th>
                    <th>Ações</th>
                </tr>
                </tfoot>
                <tbody>
                @forelse($Orders as $sel)
                    <tr>
                        <td>{{$sel['id']}}</td>
                        <td><span class="badge badge-{{$sel['status_color']}} badge-md">
                                    {{$sel['status_text']}}</span>
                        </td>
                        <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at_full_formatted']}}</td>
                        <td data-order="{{$sel['finished_at_time']}}">{{$sel['finished_at_full_formatted']}}</td>
                        <td>{{$sel->owner->name}}</td>
                        <td>{{$sel->getTotalServicesFormatted()}}</td>
                        <td>{{$sel->getTotalPartsFormatted()}}</td>
                        <td>{{$sel->getDiscountTecFormatted()}}</td>
                        <td>{{$sel->getIncreaseTecFormatted()}}</td>
                        <td>{{$sel->getFinalValueFormatted()}}</td>
                        <td>
                            <a target="_blank" href="{{route('clients.show',$sel['client_id'])}}">{{$sel->client->fantasy_name_text}}</a>
                        </td>
                        <td>
                            <a href="{{route('orders.show', $sel['id'])}}"
                               target="_blank"
                               class="btn btn-square btn-xs btn-outline btn-info"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="Visualizar"
                            ><i class="fa fa-eye"></i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>