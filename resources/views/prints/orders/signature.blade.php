<tr class="fundo_titulo_3">
    <th class="linha_titulo" colspan="7">TÉCNICO</th>
</tr>
<tr class="campo">
    <th colspan="3">NOME</th>
    <th colspan="4">CPF</th>
</tr>
<tr>
    <td colspan="3">{{$Order->owner->name}}</td>
    <td colspan="4">{{$Order->owner->cpf_formatted}}</td>
</tr>
<tr>
    <th colspan="4" class="assinatura">Assinatura:</th>
    <td colspan="3" class="sublinhar"></td>
</tr>

<tr class="espaco">
    <th colspan="7"></th>
</tr>

<tr class="fundo_titulo_3">
    <th class="linha_titulo" colspan="7">RESPONSÁVEL</th>
</tr>
<tr class="campo">
    <th colspan="3">NOME</th>
    <th colspan="2">CPF</th>
    <th colspan="2">CARGO</th>
</tr>
<tr>
    <td colspan="3">{{$Order->responsible}}</td>
    <td colspan="2">{{$Order->responsible_cpf}}</td>
    <td colspan="2">{{$Order->responsible_position}}</td>
</tr>
<tr>
    <th colspan="4" class="assinatura">Assinatura:</th>
    <td colspan="3" class="sublinhar"></td>
</tr>