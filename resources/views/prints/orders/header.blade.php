<tr class="fundo_titulo">
    <th class="linha_titulo" colspan="4">ORDEM DE SERVIÇO N° {{$Order->id}}</th>
</tr>
<tr class="campo">
    <td width="7%">CÓD.</td>
    <td width="43%">SITUAÇÃO DA O.S.</td>
    <td width="25%">DATA DE ABERTURA</td>
    <td width="25%">DATA DE FINALIZAÇÃO</td>
</tr>
<tr>
    <td>{{$Order->id}}</td>
    <td>{{$Order->status_text}}</td>
    <td>{{$Order->created_at_full_formatted}}</td>
    <td>{{$Order->finished_at_full_formatted}}</td>
</tr>