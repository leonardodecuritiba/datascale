<?php

namespace App\Models\Financials\Fiscals;

use App\Helpers\DataHelper;
use App\Models\Companies\Empresa as Company;
use App\Models\Financials\Billing;
use Carbon\Carbon;

/**
 * LaravelFocusnfe
 *
 * @author Leonardo Zanin <silva.zanin@gmail.com>
 */
class NFSe extends NF
{
	/*
    public $servico_params_fixos = [

        //3. A aliquota não deve ser enviada para optantes do simples nacional
        'aliquota' => 2.5,
        'porcentagem_tributos_float' => 11.31,
        'porcentagem_tributos_real' => '11,31%',

        'item_lista_servico' => '14.01', //'14.01/14.01.11',
        'codigo_cnae' => '3314710', //'3314-7/10',

        //4. Faltava um dígido no codigo_tributacao_municipio
        'codigo_tributario_municipio' => '14.01.11 / 00140111', //'14.01',

        //1. Alterei a configuração para remover automaticamente os acentos
        'discriminacao' => 'SERVIÇOS PRESTADOS EM BALANÇAS, MÍDIAS, COLETORES DE DADOS, CFTV, SERVIDORES, FATIADORES, REDES DE DADOS E OUTROS EQUIPAMANTOS DE AUTOMAÇÃO COMERCIAL \ INDUSTRIAL.\n\nVALOR APROXIMADO DOS TRIBUTOS',
//        'discriminacao' => 'SERVI\u00c7OS PRESTADOS EM BALAN\u00c7AS, M\u00cdDIAS, COLETORES DE DADOS, CFTV, SERVIDORES, FATIADORES, REDES DE DADOS E OUTROS EQUIPAMANTOS DE AUTOM\u00c7\u00c3O COMERCIAL \\ INDUSTRIA',
        'codigo_municipio' => '3543402', //cliente
    ];
    */
    private $now;
    private $cabecalho;
    private $prestador;
    private $tomador;
    private $servico;

    function __construct($debug, Billing $billing)
    {
	    $this->_COMPANY_ = new Company();
        $this->debug = $debug;
        if ($this->debug) {
            $this->_SERVER_ = parent::_URL_HOMOLOGACAO_;
            $this->_TOKEN_ = parent::_TOKEN_HOMOLOGACAO_;
            $this->_REF_ = $billing->idnfse_homologacao;
        } else {
            $this->_SERVER_ = parent::_URL_PRODUCAO_;
            $this->_TOKEN_ = parent::_TOKEN_PRODUCAO_;
            $this->_REF_ = $billing->idnfse_producao;
        }
        $this->_NF_TYPE_ = parent::_URL_NFSe_;
        $this->now = Carbon::now();
        $this->_BILLING_ = $billing;
        $this->setParams();
    }

    public function setParams()
    {
        //Configurando o cabeçalho - OK
        $this->setCabecalho();

        //Configurando o prestador - OK
        $this->setPrestador();

        //Configurando o tomador - OK
        $this->setTomador();
        if ($this->debug) {
            $this->tomador["razao_social"] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }

        //Configurando itens - OK
        $this->setServico();

        $this->_PARAMS_NF_ = array_merge(
            $this->cabecalho,
            ['prestador' => $this->prestador],
            ['tomador' => $this->tomador],
            ["servico" => $this->servico]
        );

        $this->writeJson();
    }

    public function setCabecalho()
    {
        $this->cabecalho = [
            "data_emissao" => $this->now->toW3cString(),//Data e hora de emissão. (obrigatório) Tag XML dhEmi
            "status" => 1,//: Status da NFS-e, informar 1 – Normal ou 2 – Cancelado. (Valor padrão: 1).
            "natureza_operacao" => 1, //(*): Natureza da operação. Informar um dos códigos abaixo.
            // Campo ignorado para o município de São Paulo.
            // 1 – Tributação no município
            // 2 – Tributação fora do município
            // 3 – Isenção
            // 4 – Imune
            // 5 – Exigibilidade suspensa por decisão judicial
            // 6 – Exigibilidade suspensa por procedimento administrativo (Valor padrão: 1)
            "regime_especial_tributacao" => $this->_COMPANY_->regime_especial_tributacao, // Informar o código de identificação do regime especial de tributação conforme abaixo.
            // Campo ignorado para o município de São Paulo.
            // 1 – Microempresa municipal
            // 2 – Estimativa
            // 3 – Sociedade de profissionais
            // 4 – Cooperativa
            // 5 – MEI – Simples Nacional
            // 6 – ME EPP – Simples Nacional
            "optante_simples_nacional" => $this->_COMPANY_->optante_simples_nacional, //(*): Informar verdadeiro ou falso se a empresa for optante pelo Simples Nacional. Campo ignorado pelo município de São Paulo.
            "incentivador_cultural" => $this->_COMPANY_->incentivador_cultural,//: Informe verdadeiro ou falso. Valor padrão: falso. Campo ignorado para o município de São Paulo.
            "tributacao_rps" => $this->_COMPANY_->tributacao_rps, //tributacao_rps: Usado apenas pelo município de São Paulo.
            // Informe o tipo de tributação:
            // T – Operação normal (tributação conforme documento emitido);
            // I – Operação isenta ou não tributável, executadas no Município de São Paulo;
            // F – Operação isenta ou não tributável pelo Município de São Paulo, executada em outro Município;
            // J – ISS Suspenso por Decisão Judicial (neste caso, informar no campo Discriminação dos Serviços, o número do processo judicial na 1a. instância). (Valor padrão “T”)
        ];
    }

    public function setPrestador() //PRESTADOR
    {
        $this->prestador = [
            "cnpj" => $this->_COMPANY_->cnpj, //(*): CNPJ do prestador de serviços. Caracteres não numéricos são ignorados.
            "codigo_municipio" => $this->_COMPANY_->icms_codigo_municipio, //(*): Código IBGE do município do prestador (consulte lista aqui)
            "inscricao_municipal" => $this->_COMPANY_->im, //: Inscrição municipal do prestador de serviços. Caracteres não numéricos são ignorados.
        ];
    }

    public function setTomador() //TOMADOR
    {

        $Client = $this->_BILLING_->client;
	    if ($Client->isLegalPerson()) { //1:PJ, 0: PF
		    $LegalPerson = $Client->legal_person;
	        $this->tomador["razao_social"] = $LegalPerson->social_reason; //: Razão social ou nome do tomador. Tamanho: 115 caracteres.
	        $this->tomador["cnpj"] = $LegalPerson->cnpj; //(*): CNPJ do tomador, se aplicável. Caracteres não numéricos são ignorados.
//            if (!$PessoaJuridica->isencao_ie) {
//                $this->tomador["inscricao_municipal"] = $PessoaJuridica->getIe(); //inscricao_municipal: Inscrição municipal do tomador. Caracteres não numéricos são ignorados.
//            }
        } else {
		    $this->tomador["cpf"] = $Client->responsible_name;//(*): CPF do tomador, se aplicável. Caracteres não numéricos são ignorados.
		    $this->tomador["razao_social"] = $Client->cpf; //: Razão social ou nome do tomador. Tamanho: 115 caracteres.
	    }

	    $Contact = $Client->contact;
	    $Address = $Client->address;
        $endereco["logradouro"] = $Address->street; // Nome do logradouro. Tamanho: 125 caracteres.
        $endereco["tipo_logradouro"] = ""; //Tipo do logradouro. Usado apenas para o município de São Paulo. Valor padrão: os 3 primeiros caracteres do logradouro. Tamanho: 3 caracteres.
        $endereco["numero"] = $Address->number; //: Número do endereço. Tamanho: 10 caracteres.
        if ($Address->complement != "") {
            $endereco["complemento"] = $Address->complement; //: Complemento do endereço. Tamanho: 60 caracteres.
        }
        $endereco["bairro"] = $Address->district; //: Bairro. Tamanho: 60 caracteres.
//        $endereco["codigo_municipio"] = $this->_COMPANY_->codigo_municipio; //: código IBGE do município.
        $endereco["codigo_municipio"] = $Address->city_code; //: código IBGE do município.
        $endereco["uf"] = $Address->uf_name; //: UF do endereço. Tamanho: 2 caracteres.
        $endereco["cep"] = $Address->zip; //: CEP do endereço. Caracteres não numéricos são ignorados.

        $this->tomador["telefone"] = $Contact->phone;
        if (($Client->email_bill != NULL) && ($Client->email_bill != "")) {
            $this->tomador["email"] = $Client->email_bill;
        }
        $this->tomador["endereco"] = $endereco;
    }

    public function setServico()
    {
        //# VALOR DE DEDUÇOES ate BASE DE CALCULO= SO SAO USADAS QNDO EMPRESA NAO E SIMPLES. CASO CONTRARIO EM BRANCO OU ZERO.

        $valores = $this->_BILLING_->getValues();


        $valor_aproximado_tributos = ($valores['nfse_value'] * $this->_COMPANY_->porcentagem_tributos_float) / 100;
        $discriminacao = $this->_COMPANY_->discriminacao .
            ' (' . $this->_COMPANY_->porcentagem_tributos_real . ') - ' .
            DataHelper::getFloat2RealMoeda($valor_aproximado_tributos);
        $this->servico = [
            "valor_liquido" => $valores['nfse_value'],
            "valor_servicos" => $valores['nfse_value'],//valor_servicos(*): Valor dos serviços.
            "valor_deducoes" => 0,//valor_deducoes: Valor das deduções.
            "valor_pis" => 0,//valor_pis: Valor do PIS.
            "valor_cofins" => 0,//valor_cofins: Valor do COFINS.
            "valor_inss" => 0,//valor_inss: Valor do INSS.
            "valor_ir" => 0,//valor_ir: Valor do IS.
            "valor_csll" => 0,//valor_csll: Valor do CSLL
            "iss_retido" => 0,//iss_retido(*): Informar verdadeiro ou falso se o ISS foi retido.
            "valor_iss" => 0,//valor_iss: Valor do ISS. Campo ignorado pelo município de São Paulo.
            "valor_iss_retido" => 0,//valor_iss_retido: Valor do ISS Retido. Campo ignorado pelo município de São Paulo.
            "outras_retencoes" => 0,//outras_retencoes: Valor de outras retenções.  Campo ignorado pelo município de São Paulo.

            "base_calculo" => 0,//base_calculo: Base de cálculo do ISS, valor padrão igual ao valor_servicos. Campo ignorado pelo município de São Paulo.

            //3. A aliquota não deve ser enviada para optantes do simples nacional
            "aliquota" => $this->_COMPANY_->aliquota,//aliquota: Aliquota do ISS.

            "desconto_incondicionado" => 0,//desconto_incondicionado: Valor do desconto incondicionado. Campo ignorado pelo município de São Paulo.
            "desconto_condicionado" => 0,//desconto_condicionado: Valor do desconto incondicionado. Campo ignorado pelo município de São Paulo.
            "item_lista_servico" => $this->_COMPANY_->item_lista_servico,//item_lista_servico (*): informar o código da lista de serviços, de acordo com a Lei Complementar 116/2003. Utilize outra tabela para o município de São Paulo.
            //2. Não deve ser enviado o código cnae para esta prefeitura
//            "codigo_cnae" => $this->_COMPANY_->codigo_cnae,//codigo_cnae: Informar o código CNAE. Campo ignorado pelo município de São Paulo.

            "codigo_tributario_municipio" => $this->_COMPANY_->codigo_tributario_municipio,//codigo_tributario_municipio: Informar o código tributário de acordo com a tabela de cada município (não há um padrão). Campo ignorado pelo município de São Paulo.
            "discriminacao" => $discriminacao,//discriminacao(*): Discriminação dos serviços. Tamanho: 2000 caracteres.
//            "codigo_municipio" => $this->_COMPANY_->codigo_municipio,//codigo_municipio(*): Informar o código IBGE do município de prestação do serviço.
            "codigo_municipio" => $this->_COMPANY_->icms_codigo_municipio,//codigo_municipio(*): Informar o código IBGE do município de prestação do serviço.
            "percentual_total_tributos" => 0,//percentual_total_tributos: Percentual aproximado de todos os impostos, de acordo com a Lei da Transparência. No momento disponível apenas para São Paulo.
//                    "fonte_total_tributos" =>0 ,//fonte_total_tributos: Fonte de onde foi retirada a informação de total de impostos, por exemplo, “IBPT”. No momento disponível apenas para São Paulo.
        ];

        return true;
//        echo json_encode($NfeItens);
    }

}