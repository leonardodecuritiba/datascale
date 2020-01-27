<?php

namespace App\Traits\Orders;

use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\EntrustFacade;

trait OrderPoliciesTrait {

	public function canShowReopenBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && $this->isClosed());
//		return ($u && $this->isClosed() && (
//				$this->getAttribute('status') == OrderStatusTrait::$_STATUS_FINALIZADA_
//			)
//		);
	}

	public function canShowDeleteBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && (
				$this->isClosed()) ||
		        ($this->getAttribute('status') == OrderStatusTrait::$_STATUS_ABERTA_)
		);
	}

	public function canShowBillBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u &&
		        ($this->getAttribute('status') == OrderStatusTrait::$_STATUS_FINALIZADA_)
		);
	}

}
