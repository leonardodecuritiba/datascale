<?php
$equipment = $Apparatu->equipment;
?>
<tr class="fundo_titulo_2">
    <th class="linha_titulo" colspan="8">
        EQUIPAMENTO Nº {{$equipment->id}}
    </th>
</tr>
<tr class="campo">
    <td width="10%" colspan="2">NÚMERO</td>
    <td width="50%" colspan="2">DESCRIÇÃO</td>
    <td width="25%" colspan="2">MODELO</td>
    <td colspan="2">Nº DE SÉRIE</td>
</tr>
<tr>
    <td colspan="2">{{$equipment->id}}</td>
    <td colspan="2">{{$equipment->description}}</td>
    <td colspan="2">{{$equipment->model}}</td>
    <td colspan="2">{{$equipment->serial_number}}</td>
</tr>