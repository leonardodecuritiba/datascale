<?php

return [
    'cfops' => [
	    ['id' => '1', 'code'=> '5102'],
	    ['id' => '2', 'code'=> '5405'],
	    ['id' => '3', 'code'=> '5915'],
	    ['id' => '4', 'code'=> '5916'],
	    ['id' => '5', 'code'=> '5913'],
    ],
    'csts' => [
	    ['id' => '1', 'code'=> '102'],
	    ['id' => '2', 'code'=> '400'],
	    ['id' => '3', 'code'=> '500'],
	    ['id' => '4', 'code'=> '060'],
	    ['id' => '5', 'code'=> '000'],
	    ['id' => '6', 'code'=> '051'],
    ],
    'nature_operations' => [
	    ['id' => '1', 'code'=>'0', 'description'=> 'VENDA'],
    	['id' => '2', 'code'=>'1', 'description'=> 'REMESSA CONSERTO'],
    	['id' => '3', 'code'=>'2', 'description'=> 'RETORNO DE CONSERTO'],
    	['id' => '4', 'code'=>'4', 'description'=> 'DEVOLUÇÃO'],
    ],
    'unities' => [
    	['id' => '1', 'code'=>'KG', 'description'=>'KILO'],
    	['id' => '2', 'code'=>'M',  'description'=>'METRO'],
    	['id' => '3', 'code'=>'CM', 'description'=>'CENTÍMETRO'],
    	['id' => '4', 'code'=>'L',  'description'=>'LITRO'],
    	['id' => '5', 'code'=>'ML', 'description'=>'MILILITRO'],
    	['id' => '6', 'code'=>'MÊS','description'=>'MÊS'],
    	['id' => '8', 'code'=>'HR', 'description'=>'HORA'],
    	['id' => '9', 'code'=>'UN','description'=>'UNIDADE'],
    ],
    'payment_forms' => [
    	['id' => '1','description'=>'CARTÃO DE CRÉDITO'],
    	['id' => '2','description'=>'CARTÃO DE DÉBITO'],
    	['id' => '3','description'=>'CARTÃO BNDES'],
    	['id' => '4','description'=>'CHEQUE'],
    	['id' => '5','description'=>'BOLETO'],
    	['id' => '6','description'=>'DINHEIRO'],
    	['id' => '7','description'=>'TRANSFERÊNCIA'],
    ],
    'payment_dues' => [
    	['id' => '0','description'=>'Á VISTA'],
    	['id' => '1','description'=>'PARCELADO'],
    ],
    'billing_issue_types' => [
        ['id' => '1','description'=>'BOLETO, NFe, NFSe'],
        ['id' => '2','description'=>'BOLETO E NFSe AGREGADO AO VALOR DE PEÇA'],
        ['id' => '3','description'=>'SOMENTE BOLETO'],
    ],
    'order_status' => [
        ['id' => '1','description'=>'ABERTA'],
        ['id' => '2','description'=>'ATENDIMENTO EM ANDAMENTO'],
        ['id' => '3','description'=>'FINALIZADA'],
        ['id' => '4','description'=>'AGUARDANDO PEÇA'],
        ['id' => '5','description'=>'EQUIPAMENTO NA OFICINA'],
        ['id' => '6','description'=>'FATURADA'],
        ['id' => '7','description'=>'FATURAMENTO PENDENTE'],
    ],
    'payment_status' => [
        ['id' => '1','description'=>'ABERTO'],
        ['id' => '2','description'=>'FINALIZADO'],
        ['id' => '3','description'=>'QUITADO'],
    ],
    'request_types' => [
        ['id' => '1','description'=>'SELOS'],
        ['id' => '2','description'=>'LACRES'],
	    [ 'id' => '3', 'description' => 'FERRAMENTAS' ],
	    [ 'id' => '4', 'description' => 'EQUIPAMENTOS' ],
	    [ 'id' => '5', 'description' => 'VEÍCULOS' ],
	    [ 'id' => '6', 'description' => 'PEÇAS' ],
    ],
    'request_pattern_types' => [
	    [ 'id' => '1', 'description' => 'Requerimento Por Validade' ],
	    [ 'id' => '2', 'description' => 'Requerimento Após Compra' ],
	    [ 'id' => '3', 'description' => 'Requerimento Por Degradação' ],
	    [ 'id' => '4', 'description' => 'Requerimento Téc. Matriz/Filial' ]
    ],
    'request_status' => [
        ['id' => '1','description'=>'AGUARDANDO'],
        ['id' => '2','description'=>'ACEITA'],
        ['id' => '3','description'=>'NEGADA'],
    ],
    'label_seal_status' => [
        ['id' => '1','description'=>'DISPONÍVEL'],
        ['id' => '2','description'=>'USADO'],
        ['id' => '3','description'=>'TODOS'],
    ],
    'billing_status' => [
        ['id' => '1','description'=>'ABERTO'],
        ['id' => '2','description'=>'FINALIZADO'],
        ['id' => '3','description'=>'QUITADO'],
    ],
    'billing_types' => [
        ['id' => '1','description'=>'CLIENTE'],
        ['id' => '2','description'=>'CENTRO DE CUSTO'],
    ],
    'portion_status' => [
        ['id' => '1','description'=>'ABERTO'],
        ['id' => '2','description'=>'PAGO'],
        ['id' => '3','description'=>'PAGO EM ATRASO'],
        ['id' => '4','description'=>'PAGO EM CARTÓRIO'],
        ['id' => '5','description'=>'EM CARTÓRIO'],
        ['id' => '6','description'=>'DESCONTADO'],
        ['id' => '7','description'=>'VENCIDO'],
    ],
    'pattern_models' => [
        ['id' => '1','description'=>'M'],
    ],
    'pattern_brands' => [
        ['id' => '1','description'=>'BRASIL CALIBRAÇAO'],
        ['id' => '2','description'=>'RAMUZA'],
        ['id' => '3','description'=>'TOLEDO'],
        ['id' => '4','description'=>'WL'],
    ],
    'pattern_features' => [
        ['id' => '1','description'=>'FERRO FUNDIDO'],
        ['id' => '2','description'=>'INOX']
    ],
];