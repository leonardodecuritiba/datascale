<table class="table table-responsive-lg">
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
    @foreach($Apparatu_parts as $apparatu_part)
        <tr>
            <th scope="row">{{$apparatu_part->part_id}}</th>
            <th scope="row">{{$apparatu_part->parent_name}}</th>
            <td>{{$apparatu_part->value_formatted}}</td>
            <td>{{$apparatu_part->quantity}}</td>
            <td>{{$apparatu_part->discount_formatted}}</td>
            <td class="text-right">{{$apparatu_part->total_formatted}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6" class="text-right fw-500 text-success">{{$Apparatu->getTotalPartsFormatted()}}</th>
    </tr>
    </tfoot>
</table>