<?php
namespace ERP\Core\Accounting\SalesReturns\Services;

use ERP\Core\Accounting\Bills\Persistables\BillPersistable;
use ERP\Core\Accounting\Bills\Entities\EncodeAllData;
use ERP\Exceptions\ExceptionMessage;
use ERP\Http\Requests;
use Illuminate\Http\Request;
use ERP\Entities\Constants\ConstantClass;
use ERP\Model\Accounting\SalesReturns\SalesReturnModel;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class SalesReturnService
{
    /**
     * @var billService
	 * $var billModel
     */
    private $billService;
    private $billModel;
	
    /**
     * @param LedgerService $ledgerService
     */
    public function initialize(LedgerService $ledgerService)
    {		
		echo "init";
    }
	
    /**
     * @param LedgerPersistable $persistable
     */
    public function create(BillPersistable $persistable)
    {
		return "create method of LedgerService";
		
    }
	
	 /**
     * get the data from persistable object and call the model for database insertion opertation
     * @param BillPersistable $persistable
     * @return status/error message
     */
	public function insert()
	{
		$billArray = array();
		$getData = array();
		$keyName = array();
		$funcName = array();
		$billArray = func_get_arg(0);
		$requestInput = func_get_arg(1);
		if(is_array($billArray))
		{
			$getNameArray = $billArray[0];
			$persistable = $billArray[1];

			foreach ($getNameArray as $key => $getFunName) {
				$salesReturnArray[$key] = $persistable->$getFunName();
			}

			$salesReturnArray['jf_id'] = $persistable->getJfId();
			$salesReturnArray['product_array'] = $persistable->getProductArray();
			$salesReturnModel = new SalesReturnModel();
			$status = $salesReturnModel->insertData($salesReturnArray,$requestInput);
			//get exception message
			return $status;
		}
	}
	public function getAll() #done
	{
		$data = func_get_arg(0);
		$companyId = func_get_arg(1);
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
			
		//data pass to the model object for getData
		$salesReturnModel = new SalesReturnModel();
		// $billModel = new BillModel();
		$salesReturnResult = $salesReturnModel->getAll($companyId,$data);
		return $salesReturnResult;
		if(strcmp($salesReturnResult,$exceptionArray['404'])==0)
		{
			return $salesReturnResult;
		}
		else
		{
			$encodeAllData = new EncodeAllData();
			$encodingResult = $encodeAllData->getEncodedAllData($salesReturnResult);
			return $encodingResult;
		}
	}
}