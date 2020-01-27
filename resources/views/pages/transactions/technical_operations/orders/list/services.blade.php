<table class="table table-separated">
    <thead class="thead-dark">
    <tr>
        <th>#</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Quant.</th>
        <th>Desc.</th>
        <th>Total</th>
        <th class="text-center w-100px">Ação</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="7" class="text-right table-actions">
            <a class="table-action hover-primary" data-type="add" data-input="service" data-toggle="modal" data-target="#modal-change-input" data-href="{{route('ajax.orders.add-input',$Apparatu->id)}}" href="#"><i class="ti-plus"></i> Adicionar</a>
        </td>
    </tr>
    </tfoot>
    <tbody>
    @foreach($Apparatu_services as $apparatu_service)
        <tr>
            <th scope="row">{{$apparatu_service->service_id}}</th>
            <th scope="row">{{$apparatu_service->parent_name}}</th>
            <td>{{$apparatu_service->value_formatted}}</td>
            <td>{{$apparatu_service->quantity}}</td>
            <td>{{$apparatu_service->discount_formatted}}</td>
            <td>{{$apparatu_service->total_formatted}}</td>
            <td class="text-right table-actions">
                <a class="table-action hover-primary" data-input="service"
                   data-type="edit" data-toggle="modal" data-target="#modal-change-input"
                   href="#" data-id="{{$apparatu_service->id}}" data-href="{{route('ajax.orders.show-input',$Apparatu->id)}}"><i class="ti-pencil"></i></a>
                <a class="table-action hover-danger" onclick="showDeleteMessage(this)" data-input="service"
                   data-function="remInput" href="#" data-id="{{$apparatu_service->id}}" data-input_id="{{$apparatu_service->service_id}}" data-href="{{route('ajax.orders.rem-input',$Apparatu->id)}}"><i class="ti-trash"></i></a>
            </td>
        </tr>
    @endforeach
    <tr class="hidex">
        <th scope="row"></th>
        <th scope="row"></th>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-right table-actions">
            <a class="table-action hover-primary" data-input="service" data-type="edit" data-toggle="modal" data-target="#modal-change-input" href="#" data-id="" data-href="{{route('ajax.orders.show-input',$Apparatu->id)}}"><i class="ti-pencil"></i></a>
            <a class="table-action hover-danger" onclick="showDeleteMessage(this)" data-input="service" data-function="remInput" href="#" data-id="" data-input_id="" data-href="{{route('ajax.orders.rem-input',$Apparatu->id)}}"><i class="ti-trash"></i></a>
        </td>
    </tr>
    </tbody>
</table>