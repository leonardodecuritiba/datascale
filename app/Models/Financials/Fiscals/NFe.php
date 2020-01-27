<?php

namespace App\Models\Financials\Fiscals;

use App\Models\Companies\Empresa as Company;
use App\Models\Financials\Billing;
use Carbon\Carbon;

/**
 * LaravelFocusnfe
 *
 * @author Leonardo Zanin <silva.zanin@gmail.com>
 */
class NFe extends NF
{
//  http://homologacao.acrasnfe.acras.com.br/panel/dashboard
//  https://api.focusnfe.com.br/panel/login

    public $params_fixos = [
        'cest_default' => '0106400',
    ];
    private $now;
    private $cabecalho;
    private $emitente;
    private $destinatario;
    private $transportadora;
    private $tributacao;
    private $itens;

    function __construct($debug, Billing $billing)
    {
        $this->debug = $debug;
        if ($this->debug) {
            $this->_SERVER_ = parent::_URL_HOMOLOGACAO_;
            $this->_TOKEN_ = parent::_TOKEN_HOMOLOGACAO_;
            $this->_REF_ = $billing->nfe_id_homologacao;
        } else {
            $this->_SERVER_ = parent::_URL_PRODUCAO_;
            $this->_TOKEN_ = parent::_TOKEN_PRODUCAO_;
            $this->_REF_ = $billing->nfe_id_producao;
        }

        $this->_NF_TYPE_ = parent::_URL_NFe_;
        $this->now = Carbon::now();
        $this->_BILLING_ = $billing;

        $this->_COMPANY_ = new Company();
        $this->setParams();
    }

    public function setParams()
    {
        //Configurando o cabeçalho - OK
        $this->setCabecalho();

        //Configurando o emitente - OK
        $this->setEmitente();

        //Configurando o destinatário - OK
        $this->setDestinatario();
        if ($this->debug) {
            $this->destinatario["nome_destinatario"] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }

        //Configurando a tributação - OK
        $this->setTributacao();

        //Configurando o transportadora - OK
        $this->setTransportadora();

        //Configurando itens - OK
        $this->setItens();

        $this->_PARAMS_NF_ = array_merge(
            $this->cabecalho,
            $this->emitente,
            $this->destinatario,
            $this->tributacao,
            $this->transportadora,
            ["items" => $this->itens]
        );
        $this->writeJson();
    }

    public function setCabecalho()
    {
        $this->cabecalho = [
            "natureza_operacao" => 'Venda c/ ST VENDA', //Descrição da natureza de operação. (obrigatório) String[1-60] Tag XML natOp
//            "natureza_operacao" => 'DEVOLUÇÃO', //Descrição da natureza de operação. (obrigatório) String[1-60] Tag XML natOp
	        "tipo_documento" => 1, // Tipo da nota fiscal. (obrigatório) Tag XML tpNF
	        // Valores permitidos:
	        // 0: Nota de entrada.
	        // 1: Nota de saída.
            "finalidade_emissao" => 1, // Finalidade da nota fiscal. (obrigatório) Tag XML finNFe
//            "finalidade_emissao" => 4, // Finalidade da nota fiscal. (obrigatório) Tag XML finNFe
	        // Valores permitidos
	        // 1: Nota normal.
	        // 2: Nota complementar.
	        // 3: Nota de Setting.
	        // 4: Devolução de mercadoria.
            "forma_pagamento" => 1, //Forma de pagamento. Valores permitidos 0: a vista. 1: a prazo. 2: outros. (obrigatório) Tag XML indPag
            "local_destino" => 1, //Identificador de local de destino da operação. (obrigatório) Tag XML idDest
            // Valores permitidos:
            // 1: Operação interna
            // 2: Operação interestadual
            // 3: Operação com exterior
            "data_emissao" => $this->now->toW3cString(),//Data e hora de emissão. (obrigatório) Tag XML dhEmi
            "data_entrada_saida" => $this->now->toW3cString(),//Data e hora de entrada (em notas de entrada) ou saída (em notas de saída). Tag XML dhSaiEnt

            "consumidor_final" => 1, //Indica operação com consumidor (obrigatório) Tag XML indFinal  final
            // Valores permitidos:
            // 0: Normal
            // 1: Consumidor final
            "presenca_comprador" => 0, //Indicador de presença do comprador no estabelecimento comercial no momento da operação. (obrigatório) Tag XML indPres
            // Valores permitidos:
            // 0: Não se aplica (por exemplo, para a Nota Fiscal complementar ou de ajuste);
            // 1: Operação presencial
            // 2: Operação não presencial, pela Internet
            // 3: Operação não presencial, Teleatendimento
            // 4: NFC-e em operação com entrega em domicílio
            // 9: Operação não presencial, outros
//	        "notas_referenciadas" => [
//	        	[
//	        		'chave_nfe' => '35180903391625000110550010001239241008050008', //Chave de acesso da nota referenciada.
//					// chave_cte Integer[44] Tag XML refCTe
//						//Chave de acesso da CTe referenciada.
//		        ]
//	        ]//notas_referenciadas Coleção[0-500] [coleção: NotaReferenciadaXML]
            //Notas referenciadas.
        ];
    }

    public function setEmitente()
    {
        $this->emitente = [
            "cnpj_emitente" => $this->_COMPANY_->cnpj,
            "inscricao_estadual_emitente" => $this->_COMPANY_->ie,
            "inscricao_municipal_emitente" => $this->_COMPANY_->im,
            "cnae_fiscal_emitente" => $this->_COMPANY_->cnae_fiscal,
            "regime_tributario_emitente" => $this->_COMPANY_->regime_tributario,
            "nome_emitente" => $this->_COMPANY_->razao_social,
            "nome_fantasia_emitente" => $this->_COMPANY_->nome_fantasia,

            "logradouro_emitente" => $this->_COMPANY_->logradouro,
            "numero_emitente" => $this->_COMPANY_->numero,
            "bairro_emitente" => $this->_COMPANY_->bairro,
            "municipio_emitente" => $this->_COMPANY_->cidade,
            "uf_emitente" => $this->_COMPANY_->estado,
            "cep_emitente" => $this->_COMPANY_->cep,
            "telefone_emitente" => $this->_COMPANY_->telefone,
        ];
    }

    public function setDestinatario()
    {
        $Client = $this->_BILLING_->client;
        if ($Client->isLegalPerson()) { //1:PJ, 0: PF
            $LegalPerson = $Client->legal_person;
            $this->destinatario["nome_destinatario"] = $LegalPerson->social_reason;
            $this->destinatario["cnpj_destinatario"] = $LegalPerson->cnpj;
            if ($LegalPerson->exemption_ie) {
                $this->destinatario["indicador_inscricao_estadual_destinatario"] = '9';
                $this->destinatario["inscricao_estadual_destinatario"] = 'ISENTO';
            } else {
                $this->destinatario["indicador_inscricao_estadual_destinatario "] = '1';
                $this->destinatario["inscricao_estadual_destinatario"] = $LegalPerson->ie;
            }
        } else {
            $this->destinatario["nome_destinatario"] = $Client->responsible_name;
            $this->destinatario["cpf_destinatario"] = $Client->cpf;
            $this->destinatario["inscricao_estadual_destinatario"] = 'ISENTO';
        }

        if (($Client->email_bill != NULL) && ($Client->email_bill != "")) {
            $this->destinatario["email_destinatario"] = $Client->email_bill;
        }

        $Contact = $Client->contact;
        $Address = $Client->address;
        $this->destinatario["telefone_destinatario"] = $Contact->phone;
        $this->destinatario["logradouro_destinatario"] = $Address->street;
        $this->destinatario["numero_destinatario"] = $Address->number;
        $this->destinatario["bairro_destinatario"] = $Address->district;
        $this->destinatario["municipio_destinatario"] = $Address->city_name;
        $this->destinatario["uf_destinatario"] = $Address->uf_name;
//        $this->destinatario["pais_destinatario"]                = 'Brasil';
        $this->destinatario["cep_destinatario"] = $Address->zip;

        if ($this->debug) {
            $this->destinatario["nome_destinatario"] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        return true;
    }

    public function setTributacao()
    {
    	//PERGUNTA. A TRIBUTAÇÃO VEM DE TODOS OS PRODUTOS?
        $valores = $this->_BILLING_->getValues();
        $this->tributacao = [
            "icms_base_calculo" => "0.00", //Valor total da base de cálculo do ICMS. (obrigatório) Decimal[13.2] Tag XML vBC
            "icms_valor_total" => "0.00", //Valor total do ICMS. (obrigatório) Decimal[13.2] Tag XML vICMS
            "icms_valor_total_desonerado" => "0.00", //Valor total do ICMS.Desonerado. (obrigatório) Decimal[13.2] Tag XML vICMSDeson
            "icms_base_calculo_st" => "0.00", //Valor total da base de cálculo do ICMS do substituto tributário. (obrigatório) Decimal[13.2] Tag XML vBCST
            "icms_valor_total_st" => "0.00", //Valor total do ICMS do substituto tributário. (obrigatório) Decimal[13.2] Tag XML vST

            "valor_seguro" => "0.00", //Valor total do seguro. (obrigatório) Decimal[13.2] Tag XML vSeg
            "valor_total_ii" => "0.00", //Valor total do imposto de importação. (obrigatório) Decimal[13.2] Tag XML vII
            "valor_ipi" => "990.00", //Valor total do IPI. (obrigatório) Decimal[13.2] Tag XML vIPI
            "valor_pis" => "0.00", //Valor do PIS. (obrigatório) Decimal[13.2] Tag XML vPIS
            "valor_cofins" => "0.00", //Valor do COFINS. (obrigatório) Decimal[13.2] Tag XML vCOFINS
            "valor_outras_despesas" => "0.00", //Valor das despesas acessórias. (obrigatório) Decimal[13.2] Tag XML vOutro

//            "valor_produtos" => $valores->valor_total_pecas_float, //Valor total dos produtos. (obrigatório) Decimal[13.2] Tag XML vProd
//            "valor_total" => $valores->valor_total_pecas_float, //Valor total da nota fiscal. (obrigatório) Decimal[13.2] Tag XML vNF

            "valor_total" => $valores['parts'], //Valor total da nota fiscal. (obrigatório) Decimal[13.2] Tag XML vNF
            "valor_desconto" => $valores['parts_discount'], //Valor total do desconto. (obrigatório) Decimal[13.2] Tag XML vDesc
            "valor_produtos" => $valores['parts'] + $valores['parts_discount'], //Valor total dos produtos. (obrigatório) Decimal[13.2] Tag XML vProd
        ];
    }

    public function setTransportadora()
    {
        $this->transportadora = [
            "modalidade_frete" => $this->_COMPANY_->modalidade_frete, // Modalidade do frete.(obrigatório) Tag XML modFrete.
            // Valores permitidos
            // 0: por conta do emitente
            // 1: por conta do destinatário
            // 2: por conta de terceiros
            // 9: sem frete
            "nome_transportador" => $this->_COMPANY_->razao_social, //Nome ou razão social do transportador. String[2-60] Tag XML xNome
            "cnpj_transportador" => $this->_COMPANY_->cnpj, //CNPJ do transportador. Se este campo for informado não deverá ser informado o CPF. Integer[14] Tag XML CNPJ
            "inscricao_estadual_transportador" => $this->_COMPANY_->ie, //Inscrição Estadual do transportador. String[2-14] Tag XML IE
//            "cpf_transportador "                    => '48740351000165', //CPF do transportador. Se este campo for informado não deverá ser informado o CNPJ. Integer[11] Tag XML CNPJ
            "endereco_transportador" => $this->_COMPANY_->logradouro, //Endereço (logradouro, número, complemento e bairro) do transportador. String[1-60] Tag XML xEnder
            "municipio_transportador" => $this->_COMPANY_->cidade, //Município do transportador. String[1-60] Tag XML xMun
            "uf_transportador" => $this->_COMPANY_->estado, //UF do transportador. String[2] Tag XML UF

            "transporte_icms_servico" => $this->_COMPANY_->icms_servico, //Valor do serviço de transporte. Decimal[13.2] Tag XML vServ
            "transporte_icms_base_calculo" => $this->_COMPANY_->icms_base_calculo, //Base de cálculo da retenção do ICMS de transporte. Decimal[13.2] Tag XML vBCRet
            "transporte_icms_aliquota" => $this->_COMPANY_->icms_aliquota, //Alíquota da retenção do ICMS de transporte. Decimal[3.2-4] Tag XML pICMSRet
            "transporte_icms_valor" => $this->_COMPANY_->icms_valor, //Valor retido do ICMS de transporte. Decimal[13.2] Tag XML vICMSRet
            "transporte_icms_cfop" => $this->_COMPANY_->icms_cfop, //CFOP do serviço de transporte. Integer[4] Tag XML CFOP
            // (Valores aceitos: 5351, 5352, 5353, 5354, 5355, 5356, 5357,
            // 5359, 5360, 5931, 5932, 6351, 6352, 6353, 6354,
            // 6355, 6356, 6357, 6359, 6360, 6931, 6932, 7358)
            "transporte_icms_codigo_municipio" => $this->_COMPANY_->icms_codigo_municipio, //Código do município de ocorrência do fato gerador. Integer[7] Tag XML cMunFG

//             "informacoes_adicionais_contribuinte" => 'REF. NFE Nº 123.924
//             NFE CHAVE DE ACESSO: 3518 0903 3916 2500 0110 5500 1000 1239 2410 0805 0008', //Informações adicionais de interesse do contribuinte. String[1-5000] Tag XML infCpl

        ];
    }

    public function setItens()
    {
        $item_n = 1;

//        return $this->_BILLING_->getAllPecas();
        foreach ($this->_BILLING_->getAllParts() as $item) {
            $NfeItens[] = [
                "numero_item" => $item_n, //Número (índice) do item na nota fiscal, começando por 1. (obrigatório) Integer[1-3] Tag XML nItem
                "codigo_produto" => $item->part_id, //Código interno do produto. Se não existir deve ser usado o CFOP no formato CFOP9999. (obrigatório) String[1-60] Tag XML cProd
//                    "codigo_barras_comercial" => $pecas_utilizada->peca->codigo_barras, //Código GTIN/EAN do produto. Integer[0,8,12,13,14] Tag XML cEAN
                "descricao" => $item->parent_name, //Descrição do produto. (obrigatório) String[1-120] Tag XML xProd
                "codigo_ncm" => $item->part->ncm->code, //Código NCM do produto. Integer[2,8] Tag XML NCM
                "codigo_cest" => $item->part->cest, //Código Especificador da Substituição Tributária. Integer[7] Tag XML CEST
//                    "codigo_ex_tipi " => **, //Código EX TIPI do produto. Integer[2-3] Tag XML EXTIPI
                "cfop" => $item->part->cfop_text, //CFOP do produto. (obrigatório) Integer[4] Tag XML CFOP
                "unidade_comercial" => $item->part->unity_text, //Unidade comercial. (obrigatório) String[1-6] Tag XML uCom


                "inclui_no_total" => "1", //Valor do item (valor_bruto) compõe valor total da NFe (valor_produtos)? (obrigatório) Tag XML indTot
                //Valores permitidos:
                // 0: não
                // 1: sim
                "icms_origem" => $item->part->icms_origem, //Origem da mercadoria. (obrigatório)
                //Valores permitidos:
                //0: nacional
                //1: estrangeira (importação direta)
                //2: estrangeira (adquirida no mercado interno)
                //3: nacional com mais de 40% de conteúdo estrangeiro
                //4: nacional produzida através de processos produtivos básicos
                //5: nacional com menos de 40% de conteúdo estrangeiro
                //6: estrangeira (importação direta) sem produto nacional similar
                //7: estrangeira (adquirida no mercado interno) sem produto nacional similar
                "icms_situacao_tributaria" => $item->part->icms_situacao_tributaria,
//                    "icms_situacao_tributaria" => $pecas_utilizada->peca->peca_tributacao->icms_situacao_tributaria, //Situação tributária do ICMS. (obrigatório)
                //Valores permitidos
                //00: tributada integralmente
                //10: tributada e com cobrança do ICMS por substituição tributária
                //20: tributada com redução de base de cálculo
                //30: isenta ou não tributada e com cobrança do ICMS por substituição tributária
                //40: isenta
                //41: não tributada
                //50: suspensão
                //51: diferimento (a exigência do preenchimento das informações do ICMS diferido fica a critério de cada UF)
                //60: cobrado anteriormente por substituição tributária
                //70: tributada com redução de base de cálculo e com cobrança do ICMS por substituição tributária
                //90: outras (regime Normal)
                //101: tributada pelo Simples Nacional com permissão de crédito
                //102: tributada pelo Simples Nacional sem permissão de crédito
                //103: isenção do ICMS no Simples Nacional para faixa de receita bruta
                //201: tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por substituição tributária
                //202: tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por substituição tributária
                //203: isenção do ICMS nos Simples Nacional para faixa de receita bruta e com cobrança do ICMS por substituição tributária
                //300: imune
                //400: não tributada pelo Simples Nacional
                //500: ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação
                //900: outras (regime Simples Nacional)
                "pis_situacao_tributaria" => $item->part->pis_situacao_tributaria,
//                    "pis_situacao_tributaria" => $pecas_utilizada->peca->peca_tributacao->pis_situacao_tributaria, //Situação tributária do PIS.(obrigatório)
                //Valores permitidos
                //01: operação tributável: base de cálculo = valor da operação (alíquota normal - cumulativo/não cumulativo)
                //02: operação tributável: base de cálculo = valor da operação (alíquota diferenciada)
                //03: operação tributável: base de cálculo = quantidade vendida × alíquota por unidade de produto
                //04: operação tributável: tributação monofásica (alíquota zero)
                //05: operação tributável: substituição tributária
                //06: operação tributável: alíquota zero
                //07: operação isenta da contribuição
                //08: operação sem incidência da contribuição
                //09: operação com suspensão da contribuição
                //49: outras operações de saída
                //50: operação com direito a crédito: vinculada exclusivamente a receita tributada no mercado interno
                //51: operação com direito a crédito: vinculada exclusivamente a receita não tributada no mercado interno
                //52: operação com direito a crédito: vinculada exclusivamente a receita de exportação
                //53: operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no mercado interno
                //54: operação com direito a crédito: vinculada a receitas tributadas no mercado interno e de exportação
                //55: operação com direito a crédito: vinculada a receitas não-tributadas no mercado interno e de exportação
                //56: operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no mercado interno e de exportação
                //60: crédito presumido: operação de aquisição vinculada exclusivamente a receita tributada no mercado interno
                //61: crédito presumido: operação de aquisição vinculada exclusivamente a receita não-tributada no mercado interno
                //62: crédito presumido: operação de aquisição vinculada exclusivamente a receita de exportação
                //63: crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas no mercado interno
                //64: crédito presumido: operação de aquisição vinculada a receitas tributadas no mercado interno e de exportação
                //65: crédito presumido: operação de aquisição vinculada a receitas não-tributadas no mercado interno e de exportação
                //66: crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas no mercado interno e de exportação
                //67: crédito presumido: outras operações
                //70: operação de aquisição sem direito a crédito
                //71: operação de aquisição com isenção
                //72: operação de aquisição com suspensão
                //73: operação de aquisição a alíquota zero
                //74: operação de aquisição sem incidência da contribuição
                //75: operação de aquisição por substituição tributária
                //98: outras operações de entrada
                //99: outras operações
                "cofins_situacao_tributaria" => $item->part->cofins_situacao_tributaria,
//                    "cofins_situacao_tributaria" => $pecas_utilizada->peca->peca_tributacao->cofins_situacao_tributaria //(obrigatório)
                //Valores permitidos
                //01: operação tributável: base de cálculo = valor da operação (alíquota normal - cumulativo/não cumulativo)
                //02: operação tributável: base de cálculo = valor da operação (alíquota diferenciada)
                //03: operação tributável: base de cálculo = quantidade vendida × alíquota por unidade de produto
                //04: operação tributável: tributação monofásica (alíquota zero)
                //05: operação tributável: substituição tributária
                //06: operação tributável: alíquota zero
                //07: operação isenta da contribuição
                //08: operação sem incidência da contribuição
                //09: operação com suspensão da contribuição
                //49: outras operações de saída
                //50: operação com direito a crédito: vinculada exclusivamente a receita tributada no mercado interno
                //51: operação com direito a crédito: vinculada exclusivamente a receita não tributada no mercado interno
                //52: operação com direito a crédito: vinculada exclusivamente a receita de exportação
                //53: operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no mercado interno
                //54: operação com direito a crédito: vinculada a receitas tributadas no mercado interno e de exportação
                //55: operação com direito a crédito: vinculada a receitas não-tributadas no mercado interno e de exportação
                //56: operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no mercado interno e de exportação
                //60: crédito presumido: operação de aquisição vinculada exclusivamente a receita tributada no mercado interno
                //61: crédito presumido: operação de aquisição vinculada exclusivamente a receita não-tributada no mercado interno
                //62: crédito presumido: operação de aquisição vinculada exclusivamente a receita de exportação
                //63: crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas no mercado interno
                //64: crédito presumido: operação de aquisição vinculada a receitas tributadas no mercado interno e de exportação
                //65: crédito presumido: operação de aquisição vinculada a receitas não-tributadas no mercado interno e de exportação
                //66: crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas no mercado interno e de exportação
                //67: crédito presumido: outras operações
                //70: operação de aquisição sem direito a crédito
                //71: operação de aquisição com isenção
                //72: operação de aquisição com suspensão
                //73: operação de aquisição a alíquota zero
                //74: operação de aquisição sem incidência da contribuição
                //75: operação de aquisição por substituição tributária
                //98: outras operações de entrada
                //99: outras operações


                //MESMA COISA DO CAMPO quantidade_comercial E unidade_tributave

                "quantidade_comercial" => $item->quantity, //Quantidade comercial. (obrigatório) Decimal[11.0-4] Tag XML qCom
                "valor_unitario_comercial" => $item->value, //Valor unitário comercial. (obrigatório) Decimal[11.0-10] Tag XML vUnCom
                "valor_bruto" => $item->total, //Valor bruto. Deve ser igual ao produto de Valor unitário comercial com quantidade comercial. Decimal[13.2] Tag XML vProd
//                    "codigo_barras_tributavel" => "**", //Código GTIN/EAN tributável. Integer[0,8,12,13,14] Tag XML cEANTrib
                "unidade_tributavel" => $item->part->unity_text, //Unidade tributável. (obrigatório) String[1-6] Tag XML uTrib
                "quantidade_tributavel" => $item->quantity, //Quantidade tributável. (obrigatório) Decimal[11.0-4] Tag XML qTrib
                "valor_unitario_tributavel" => $item->value, //Valor unitário tributável. (obrigatório) Decimal[11.0-10] Tag XML vUnTrib

                //O valor do frete vai ser incluído dentro do produto mesmo (compo é hoje) ou vai depender da O.S?
                "valor_frete" => $item->part->valor_frete, //Valor do frete. Decimal[13.2] Tag XML vFrete
                "valor_seguro" => $item->part->valor_seguro, //Valor do seguro. Decimal[13.2] Tag XML vSeg
                "valor_desconto" => $item->discount, //Valor do desconto. Decimal[13.2] Tag XML vSeg
//                    "valor_outras_despesas" =>  ***, //Valor de outras despesas acessórias. Decimal[13.2] Tag XML vOutro
                "valor_ipi" => $item->part->valor_ipi,

            ];
            $item_n++;
        }

        $this->itens = $NfeItens;
        return true;
    }

}