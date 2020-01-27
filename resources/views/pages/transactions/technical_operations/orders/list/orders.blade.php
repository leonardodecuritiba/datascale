
<div class="card">
    <h4 class="card-title"><strong>{{count($Orders)}}</strong> Registros
        @if(isset($period))
            <small><i>Período {{$period}}</i></small>
        @else
            <small><i>Mês atual</i></small>
        @endif
    </h4>

    <div class="card-content">
        <div class="card-body">

            <table class="table table-striped table-bordered responsive-table" cellspacing="0" data-provide="datatables">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Situação</th>
                    <th>Data de Abertura</th>
                    {{--<th>Nº Chamado</th>--}}
                    <th>Colaborador</th>
                    <th>Cliente</th>
                    <th width="20px">Ações</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Situação</th>
                    <th>Data de Abertura</th>
                    {{--<th>Nº Chamado</th>--}}
                    <th>Colaborador</th>
                    <th>Cliente</th>
                    <th>Ações</th>
                </tr>
                </tfoot>
                <tbody>
                @forelse($Orders as $sel)
                <tr>
                    <td>{{$sel['id']}}</td>
                    <td>
                        <span class="badge badge-{{$sel['status_color']}} badge-md">
                             {{$sel['status_text']}}</span>
                    </td>
                    <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                    {{--<td>{{$sel['call_number']}}</td>--}}
                    <td>{{$sel['owner_name']}}</td>
                    <td>{{$sel['client_name']}}</td>
                    <td>
                        <a href="{{route('orders.show', $sel['id'])}}"
                           class="btn btn-square btn-xs btn-outline btn-info"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Abrir"
                        ><i class="fa fa-eye"></i>
                        </a>

                        {{--@if($sel['can_show_bill_btn'])--}}
                            {{--<a href="#"--}}
                               {{--class="btn btn-square btn-xs btn-outline btn-success"--}}
                               {{--data-toggle="tooltip"--}}
                               {{--data-placement="top"--}}
                               {{--title="Faturar"--}}
                            {{--><i class="fa fa-money"></i>--}}
                            {{--</a>--}}
                        {{--@endif--}}

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @include('layouts.inc.loading')
</div>