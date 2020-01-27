<tr class="fundo_titulo_3">
    <th class="linha_titulo" colspan="8">SERVIÇOS</th>
</tr>
<tr class="campo">
    <th width="7%">CÓD.</th>
    <th colspan="3" width="47%">DESCRIÇÃO</th>
    <th width="10%">V. UN.</th>
    <th width="6%">QTDE</th>
    <th width="10%">DESCONTO</th>
    <th width="10%">V. TOTAL</th>
</tr>
@foreach ($services as $sel)
    <tr>
        <td>{{$sel->service_id}}</td>
        <td colspan="3">{{$sel->parent_name}}</td>
        <td class="valor">{{$sel->value_formatted}}</td>
        <td class="valor">{{$sel->quantity}}</td>
        <td class="valor">{{$sel->discount_formatted}}</td>
        <td class="valor">{{$sel->total_formatted}}</td>
    </tr>
@endforeach
<tr class="linha_total">
    <th colspan="7">TOTAL</th>
    <td class="valor">{{$total}}</td>
</tr>