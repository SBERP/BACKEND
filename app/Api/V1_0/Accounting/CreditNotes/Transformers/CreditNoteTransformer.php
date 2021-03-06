<?php
namespace ERP\Api\V1_0\Accounting\CreditNotes\Transformers;

use Illuminate\Http\Request;
use ERP\Http\Requests;
// Common deps
use ERP\Exceptions\ExceptionMessage;
use Carbon;
use ERP\Entities\Constants\ConstantClass;
// Credit note deps

/**
 * @author Hiren Faldu<hiren.f@siliconbrain.in>
 */
class CreditNoteTransformer
{
	function __construct() {
		$this->constant = new ConstantClass();
		$this->constantVars = $this->constant->constantVariable();
		// get exception message
		$this->exception = new ExceptionMessage();
		$this->messages = $this->exception->messageArrays();
	}
	/**
	 * trim request data for insertion	
	 * @param [Request $request]
	 * @return array
	 */
	public function trimInsertData(Request $request)
	{
		$inputData = array();
		$inputData = $request->input();

		$trimArray = array();

		$trimArray['entry_date'] = trim($inputData['entryDate']);
		$trimArray['invoice_number'] = trim($inputData['invoiceNumber']);
		if($trimArray['invoice_number'] == '') {
			return $this->messages['content'];
		}

		$trimArray['total'] = round(trim($inputData['total'], 4));

		if(!is_numeric($trimArray['total'])) {
			return $this->messages['invalidAmount'];
		}

		$trimArray['remark'] = trim($inputData['remark']) != 'undefined' && trim($inputData['remark']) != 'null' && trim($inputData['remark']) != NULL ? trim($inputData['remark']) : '';

		$returnJournal = array();
		if(!is_array($inputData['inventory']) || !count($inputData['inventory'])) {
			return $this->messages['content'];
		}

		$trimArray['credit_array'] = array_map(function($jvd) {
			$njv = array();
			$njv['client_id'] = trim($jvd['clientId']);
			$njv['client_name'] = trim($jvd['clientName']);
			$njv['ledger_id'] = trim($jvd['ledgerId']);
			$njv['amount'] = (float)trim($jvd['amount']);
			return $njv;
		}, $inputData['inventory']);
		
		$totalAmount = array_sum(array_column($trimArray['credit_array'], 'amount'));
		$totalAmount = round($totalAmount, 4);

		if(!is_numeric($totalAmount) || $totalAmount == 0 || abs($totalAmount - $trimArray['total']) > 0.01) {
			return $this->messages['invalidAmount'];
		}

		return $trimArray;
	}
}