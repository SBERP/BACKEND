<?php
namespace ERP\Api\V1_0\Accounting\Bills\Controllers;

use ERP\Api\V1_0\Accounting\Bills\Processors\BillProcessor;
use ERP\Api\V1_0\Documents\Controllers\DocumentController;
use ERP\Api\V1_0\Support\BaseController;
use ERP\Core\Accounting\Bills\Persistables\BillPersistable;
use ERP\Core\Accounting\Bills\Services\BillService;
use ERP\Core\Support\Service\ContainerInterface;
use ERP\Entities\AuthenticationClass\TokenAuthentication;
use ERP\Entities\Constants\ConstantClass;
use ERP\Exceptions\ExceptionMessage;
use ERP\Model\Accounting\Bills\BillModel;
use ERP\Model\Authenticate\AuthenticateModel;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class BillController extends BaseController implements ContainerInterface
{
	/**
	 * @var billService
	 * @var processor
	 * @var request
	 * @var billPersistable
	 */
	private $billService;
	private $processor;
	private $request;
	private $billPersistable;

	/**
	 * get and invoke method is of ContainerInterface method
	 */
	public function get($id, $name)
	{
		// echo "get";
	}
	public function invoke(callable $method)
	{
		// echo "invoke";
	}

	/**
	 * insert the specified resource
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function store(Request $request)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.add');
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$this->request = $request;

			// check the requested Http method
			$requestMethod = $_SERVER['REQUEST_METHOD'];

			// get exception message
			$exception = new ExceptionMessage();
			$msgArray = $exception->messageArrays();

			// insert
			if ($requestMethod == 'POST') {
				if (count($_POST) == 0) {
					return $msgArray['204'];
				} else {
					$processor = new BillProcessor();
					$billPersistable = new BillPersistable();
					$billPersistable = $processor->createPersistable($this->request);

					if (is_array($billPersistable) || is_object($billPersistable)) {
						$billService = new BillService();
						$status = $billService->insert($billPersistable, $this->request);
						if (strcmp($status, $msgArray['500']) == 0) {
							return $status;
						} else {
							$decodedSaleData = json_decode($status);
							$saleId = $decodedSaleData->saleId;
							$saleIdArray = array();
							$saleIdArray['saleId'] = $saleId;
							$documentController = new DocumentController(new Container());
							$method = $constantArray['postMethod'];
							$path = $constantArray['documentGenerateUrl'];
							$documentRequest = Request::create($path, $method, $saleIdArray);
							if (array_key_exists('operation', $request->header())) {
								if ($request->header()['operation'][0] != 'generate') {
									$documentRequest->headers->set('operation', $request->header()['operation'][0]);
								}
							} else {
								$documentRequest->headers->set('key', $request->header());
							}
							if (array_key_exists("issalesorder", $request->header())) {
								$documentRequest->headers->set('issalesorder', $request->header()['issalesorder'][0]);
							}
							$processedData = $documentController->getData($documentRequest);
							if (array_key_exists('isquotationprocess', $request->header())) {
								return [
									'saleId' => $saleId,
									'response' => $processedData,
								];
							}
							return $processedData;
						}
					} else {
						return $billPersistable;
					}
				}
			}
		} else {
			return $authenticationResult;
		}
	}

	public function getQuotationData(Request $request, $companyId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			if (array_key_exists('fromdate', $request->header()) && array_key_exists('todate', $request->header())) {
				$processor = new BillProcessor();
				$billPersistable = new BillPersistable();
				$billPersistable = $processor->getPersistableData($request->header());
				if (!is_object($billPersistable)) {
					return $billPersistable;
				}
				$data = $billPersistable;
			} else if (array_key_exists('invoicenumber', $request->header())) {
				$data = $request->header();
			}

			$billService = new BillService();
			$status = $billService->getQuotationData($data, $companyId);
			return $status;
		} else {
			return $authenticationResult;
		}
	}
	/**
	 * get the specified resource
	 * @param  Request object[Request $request] and companyId
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function getData(Request $request, $companyId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			if (array_key_exists('fromdate', $request->header()) && array_key_exists('todate', $request->header())) {
				$processor = new BillProcessor();
				$billPersistable = new BillPersistable();
				$billPersistable = $processor->getPersistableData($request->header());
				if (!is_object($billPersistable)) {
					return $billPersistable;
				}
				$data = $billPersistable;
			} else if (array_key_exists('invoicenumber', $request->header())) {
				$data = $request->header();
			}

			$billService = new BillService();
			$status = $billService->getData($data, $companyId);
			return $status;
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * get the Previos-next data
	 * @param  Request object[Request $request]
	 * @return array-data/error message
	 */
	public function getPreviosNextData(Request $request)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billService = new BillService();
			$status = $billService->getPreviousNextData($request->header());
			return $status;
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * update the specified resource (bill-payment)
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function updateBillPayment(Request $request, $saleId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.edit');

		// get exception message
		$exception = new ExceptionMessage();
		$msgArray = $exception->messageArrays();
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$processor = new BillProcessor();
			$billPersistable = new BillPersistable();
			$billPersistable = $processor->getPersistablePaymentData($request, $saleId);
			if (is_object($billPersistable)) {
				$billService = new BillService();
				$status = $billService->updatePaymentData($billPersistable);
				if (strcmp($status, $msgArray['200']) == 0) {
					$saleIdArray = array();
					$saleIdArray['saleId'] = $saleId;
					$documentController = new DocumentController(new Container());

					$method = $constantArray['postMethod'];
					$path = $constantArray['documentGenerateUrl'];
					$documentRequest = Request::create($path, $method, $saleIdArray);
					$processedData = $documentController->getData($documentRequest);
					return $processedData;
				}
			} else {
				return $billPersistable;
			}
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * update the specified resource (bill-status)
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function updateBillStatus(Request $request, $saleId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.edit');

		// get exception message
		$exception = new ExceptionMessage();
		$msgArray = $exception->messageArrays();
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			if (count($_POST) != 0) {
				$billModel = new BillModel();
				$status = $billModel->getSaleIdData($saleId);
				if (strcmp($status, $msgArray['404']) == 0) {
					return $status;
				}
				$processor = new BillProcessor();
				$billPersistable = new BillPersistable();
				$billData = json_decode($status, true);
				$billPersistable = $processor->getPersistableStatusData($request, $billData[0]);

				if (is_array($billPersistable)) {
					$billService = new BillService();
					$status = $billService->updateStatusData($billPersistable);
					return $status;
				} else {
					return $billPersistable;
				}
			} else {
				return $msgArray['204'];
			}

		} else {
			return $authenticationResult;
		}
	}

	/**
	 * update the specified resource
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function update(Request $request, $saleId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.edit');

		// get exception message
		$exception = new ExceptionMessage();
		$msgArray = $exception->messageArrays();

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			//check the condition for image or data or both available
			if (empty($request->input()) && in_array(true, $request->file()) || !empty($request->input())) {
				//check saleId exist or not?
				$billModel = new BillModel();
				$billData = array_key_exists("issalesorderupdate", $request->header())
				? $billModel->getSaleOrderData($saleId) : $billModel->getSaleIdData($saleId);
				if (strcmp($billData, $msgArray['404']) == 0) {
					return $msgArray['404'];
				}

				$processor = new BillProcessor();
				$billPersistable = new BillPersistable();
				$billPersistable = $processor->createPersistableChange($request, $saleId, $billData);	

				if (is_array($billPersistable) || is_object($billPersistable)) {
					$billService = new BillService();
					$status = $billService->updateData($billPersistable, $saleId, $request->header());
					return $status;
				} else {
					return $billPersistable;
				}
			} else {
				if (array_key_exists('operation', $request->header())) {
					if ($request->header()['operation'][0] == 'generate') {
						$billModel = new BillModel();
						$billModel->updatePrintCount($saleId);
					}
				}
				return $msgArray['204'];
			}
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * get the specified resource
	 * @param  Request object[Request $request]
	 * store data in database
	 */
	public function getDraftData(Request $request, $companyId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billService = new BillService();
			$status = $billService->getDraftData($companyId);
			return $status;
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * get the pdf of all saleids
	 * @param  Request object[Request $request]
	 * store data in database
	 */
	public function getBulkPrintData(Request $request)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$exception = new ExceptionMessage();
			$fileNotGet = $exception->messageArrays();

			if (isset($request->header()['saleid'])) {
				$saleIds = $request->header()['saleid'][0];

				if ($saleIds != '') {
					$saleIds = explode(',', $saleIds);
					$billService = new BillService();
					$status = $billService->getBulkPrintData($saleIds, $request->header());
					return $status;
				}
			}
			return $fileNotGet['404'];
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * store the specified resource
	 * @param  Request object[Request $request]
	 * store data in database
	 */
	public function storeDraftData(Request $request)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.add');

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billModel = new BillModel();
			$draftBillResult = $billModel->insertBillDraftData($request);
			return $draftBillResult;
		} else {
			return $authenticationResult;
		}
	}

	public function getBillById(Request $request,$id)
	{
		// Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billService = new BillService();
			$billResult = $billService->getBillById($id);
			return $billResult;
		} else {
			return $authenticationResult;
		}
	}

	public function getBillMonthwise(Request $request)
	{
		// Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.view');
		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billService = new BillService();
			$billResult = $billService->getBillMonthwise();
			return $billResult;
		} else {
			return $authenticationResult;
		}
	}
	/**
	 * store the specified resource
	 * @param  Request object[Request $request]
	 * store data in database
	 */
	public function getBillByJfId(Request $request, $jfId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$companyId = $request->header('companyId');
			$billService = new BillService();
			$billResult = $billService->getBillByJfId($companyId, $jfId);
			return $billResult;
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * update the specified resource
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function destroy(Request $request, $saleId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.delete');

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$authenticateModel = new AuthenticateModel();
			$userId = $authenticateModel->getActiveUser($request->header());
			$deletedBy = isset($userId[0]->user_id) ? $userId[0]->user_id : 0;
			$billModel = new BillModel();
			$deleteBillResult = $billModel->deleteBillData($saleId, $deletedBy);
			return $deleteBillResult;
		} else {
			return $authenticationResult;
		}
	}

	/**
	 * update the specified resource
	 * @param  Request object[Request $request]
	 * method calls the processor for creating persistable object & setting the data
	 */
	public function destroyDraftData(Request $request, $saleId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header(),'salesbill.delete');

		// get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if (strcmp($constantArray['success'], $authenticationResult) == 0) {
			$billModel = new BillModel();
			$deleteBillResult = $billModel->deleteBillDraftData($saleId);
			return $deleteBillResult;
		} else {
			return $authenticationResult;
		}
	}
}
