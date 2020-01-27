<table class="table table-separated">
    <thead class="thead-dark">
    <tr>
        <th>#</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Quant.</th>
        <th>Desc.</th>
        <th class="text-right">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($Apparatu_services as $apparatu_service)
        <tr>
            <th scope="row">{{$apparatu_service->service_id}}</th>
            <th scope="row">{{$apparatu_service->parent_name}}</th>
            <td>{{$apparatu_service->value_formatted}}</td>
            <td>{{$apparatu_service->quantity}}</td>
            <td>{{$apparatu_service->discount_formatted}}</td>
            <td class="text-right">{{$apparatu_service->total_formatted}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6" class="text-right fw-500 text-success">{{$Apparatu->getTotalServicesFormatted()}}</th>
    </tr>
    </tfoot>
</table>