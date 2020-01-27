@if ($Order->isClosed() == 0)
    <tr class="fundo_titulo">
        <th class="linha_titulo" colspan="2">ATENÇÃO: Ordem de Serviço não finalizada!</th>
    </tr>
@endif
<tr>
    <td width="60%">Ordem de Serviço - #{{$Order->id}}</td>
    <td width="40%" rowspan="8" style="text-align: right;">
        <img width="280px" src="{{$Company->getImagePath()}}"/>
    </td>
</tr>
<tr>
    <td>{{$Company->slogan}}</td>
</tr>
<tr>
    <td>{{$Company->razao_social}} / CNPJ: {{$Company->cnpjFormatted()}}</td>
</tr>
<tr>
    <td>I.E: {{$Company->ieFormatted()}}</td>
</tr>
<tr>
    <td>N° de Autorização: {{$Company->n_autorizacao}}</td>
</tr>
<tr>
    <td>{{$Company->getFullAddress()}}</td>
</tr>
<tr>
    <td>Fone: {{$Company->getPhoneAndCellPhone()}}</td>
</tr>
<tr>
    <td>E-mail: {{$Company->email_os}}</td>
</tr>