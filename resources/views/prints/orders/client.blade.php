
<tr class="fundo_titulo">
    <th class="linha_titulo" colspan="6">CLIENTE N° {{$client->id}}</th>
</tr>
<tr class="campo">
    <td width="35%">CLIENTE/RAZÃO SOCIAL</td>
    <td colspan="2" width="25%">FANTASIA</td>
    <td>CONTATO</td>
    <td width="15%">CNPJ/CPF</td>
    <td width="13%">IE</td>
</tr>
<tr>
    <td>{{$client->social_reason_text}}</td>
    <td colspan="2">{{$client->fantasy_name_text}}</td>
    <td>{{$client->responsible_name}}</td>
    <td>{{$client->short_document}}</td>
    <td>{{$client->ie_formatted}}</td>
</tr>
<tr class="campo">
    <td colspan="3">ENDEREÇO</td>
    <td colspan="2">BAIRRO/DISTRITO</td>
    <td>CEP</td>
</tr>
<tr>
    <td colspan="3">{{$client->address->getFullStreetComplement()}}</td>
    <td colspan="2">{{$client->address->district}}</td>
    <td>{{$client->address->zip_formatted}}</td>
</tr>
<tr class="campo">
    <td>MUNICÍPIO</td>
    <td>UF</td>
    <td colspan="2">FONE</td>
    <td colspan="2">EMAIL NOTA</td>
</tr>
<tr>
    <td>{{$client->address->city_name}}</td>
    <td>{{$client->address->uf_name}}</td>
    <td colspan="2">{{$client->contact->phone_formatted}}</td>
    <td colspan="2">{{$client->email_bill}}</td>
</tr>