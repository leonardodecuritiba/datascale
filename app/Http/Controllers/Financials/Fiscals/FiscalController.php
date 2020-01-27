<?php

namespace App\Http\Controllers\Financials\Fiscals;

use App\Http\Controllers\Controller;
use App\Models\Financials\Billing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FiscalController extends Controller
{
//
//
//	public function __construct()
//	{
//		$this->Page = (object)[
//			'link' => "notas_fiscais",
//			'Target' => "Notas Fiscais",
//			'Search' => "Buscar por CPF, CNPJ, Nome Fantasia ou Razão Social...",
//			'Targets' => "Notas Fiscais",
//			'Titulo' => "Nota Fiscal",
//			'search_results' => "",
//			'search_no_results' => "Nenhuma Nota Fiscal encontrada!",
//			'titulo_primario' => "",
//			'titulo_secundario' => "",
//		];
//	}
//	/**
//	 * Display a listing of the resource.
//	 * @param Request $request
//	 * @return \Illuminate\Http\Response
//	 */
//	public function index(Request $request, $tipo)
//	{
//		$data_final = NULL;
//		$data_inicial = NULL;
//		$cnpj = NULL;
//		if ($request->has('data_inicial')) {
//			$data_inicial = DataHelper::getPrettyToCorrectDateTime($request->get('data_inicial'));
//		}
//		if ($request->has('data_final')) {
//			$data_final = DataHelper::getPrettyToCorrectDateTime($request->get('data_final'));
//		}
//		if ($request->has('cnpj')) {
//			$cnpj = DataHelper::getOnlyNumbers($request->get('cnpj'));
//		}
//
//		if (strcmp($tipo, 'nfe') == 0) {
//			$this->Page->Targets = 'NFe';
//			$this->Page->extras['tipo_nf'] = 'nfe';
//			$this->Page->extras['data_nf'] = 'data_nfe_producao';
//			$this->Page->extras['nome_nf'] = 'NFe';
//			$this->Page->extras['ref'] = 'idnfe_producao';
//			$this->Page->extras['debug'] = 0;
//		} else {
//			$this->Page->Targets = 'NFSe';
//			$this->Page->extras['tipo_nf'] = 'nfse';
//			$this->Page->extras['data_nf'] = 'data_nfse_producao';
//			$this->Page->extras['nome_nf'] = 'NFSe';
//			$this->Page->extras['ref'] = 'idnfse_producao';
//			$this->Page->extras['debug'] = 0;
//		}
//
////        if ($request->has('ref')) { $Buscas = Faturamento::where($this->Page->extras['ref'], $request->get('ref'))->first();
//		$query = Faturamento::whereBetween($this->Page->extras['data_nf'],
//			[$data_inicial, $data_final]);
//		if ($cnpj != NULL) {
//			$idcliente = Cliente::whereIn('idpjuridica',
//				PessoaJuridica::where('cnpj', $cnpj)->pluck('idpjuridica')
//			)->pluck('idcliente');
//			$query->whereIn('idcliente', $idcliente);
//		}
//		$Buscas = $query->get();
//
//		return view('pages.' . $this->Page->link . '.index')
//			->with('Page', $this->Page)
//			->with('Buscas', $Buscas);
//	}


	// ============= NF ==================

	public function getNF($id, $debug, $type)
	{
		$billing = Billing::find($id);
		return $billing->getNF($debug, $type);
	}

	public function sendNF($id, $debug, $type)
	{
		$billing = Billing::find($id);
		$message = $billing->sendNF($debug, $type);
		return response()->success( $message, $billing, route(  'billings.clients.show', $billing->id ) );
	}

	public function cancelNF(Request $request, $id, $debug, $type)
	{
		$billing = Billing::find($id);
		$message = $billing->cancelNF($debug, $type, $request->all());
		return response()->success( $message, $billing, route(  'billings.clients.show', $billing->id ) );
	}

	public function resendNF($id, $debug, $type)
	{
		$billing = Billing::find($id);
		$message = $billing->resendNF($debug, $type);
		return response()->success( $message, $billing, route(  'billings.clients.show', $billing->id ) );
	}


	public function sendEmail(Request $request, $id)
	{
		$billing = Billing::find($id);
		$code = $billing->sendNfByEmail($request->get('link'));
		$mensagem = ($code) ? 'Email enviado com sucesso!' : 'Ocorreu um erro ao enviar o email!';
		$content = [
			'code' => $code,
			'status' => $mensagem,
		];
		return new JsonResponse($content, 200);
	}

}
