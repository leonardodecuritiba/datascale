<?php
$instrument = $Apparatu->instrument;
?>

<tr class="fundo_titulo_2">
    <th class="linha_titulo" colspan="8">
        INSTRUMENTO Nº {{$instrument->id}}
    </th>
</tr>
<tr class="campo">
    <td width="10%">NÚMERO</td>
    <td colspan="2">DESCRIÇÃO</td>
    <td colspan="3">MARCA/MODELO</td>
    <td>Nº DE SÉRIE</td>
    <td>ANO</td>
</tr>
<tr>
    <td>{{$instrument->id}}</td>
    <td colspan="2">{{$instrument->getBaseDescription()}}</td>
    <td colspan="3">{{$instrument->getBrandModel()}}</td>
    <td>{{$instrument->serial_number}}</td>
    <td>{{$instrument->year}}</td>
</tr>
<tr class="campo">
    <td width="10%">PORTARIA</td>
    <td>CAPACIDADE</td>
    <td>DIVISÃO</td>
    <td>INVENTÁRIO</td>
    <td>PATRIMÔNIO</td>
    <td>SETOR</td>
    <td>ENDEREÇO</td>
    <td>IP</td>
</tr>
<tr>
    <td>{{$instrument->getBaseOrdinance()}}</td>
    <td>{{$instrument->getBaseCapacity()}}</td>
    <td>{{$instrument->getBaseDivision()}}</td>
    <td>{{$instrument->inventory}}</td>
    <td>{{$instrument->patrimony}}</td>
    <td>{{$instrument->setor_name}}</td>
    <td>{{$instrument->address}}</td>
    <td>{{$instrument->ip}}</td>
</tr>
@if($Apparatu->hasLabelSetted())
    <tr class="campo">
        <td colspan="2">SELO RETIRADO</td>
        <td colspan="2">SELO AFIXADO</td>
        <td colspan="2">LACRES RETIRADOS</td>
        <td colspan="2">LACRES AFIXADOS</td>
    </tr>
    <tr>
        <td colspan="2">{{$Apparatu->getNumberLabelUnsetted()['text']}}</td>
        <td colspan="2">{{$Apparatu->getNumberLabelSetted()['text']}}</td>
        <td colspan="2">{{$Apparatu->getNumberSealsUnsetted()['text']}}</td>
        <td colspan="2">{{$Apparatu->getNumberSealsSetted()['text']}}</td>
    </tr>
@else
    <tr class="campo">
        <td colspan="8">SELOS/LACRES</td>
    </tr>
    <tr>
        <td colspan="8">SEM INTERVENÇÃO</td>
    </tr>
@endif