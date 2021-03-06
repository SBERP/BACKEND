<?php
namespace ERP\Api\V1_0\Accounting\Ledgers\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use ERP\Core\Accounting\Ledgers\Services\LedgerService;
use ERP\Http\Requests;
use ERP\Api\V1_0\Support\BaseController;
use ERP\Api\V1_0\Accounting\Ledgers\Processors\DemoProcessor as LedgerProcessor;
use ERP\Core\Accounting\Ledgers\Persistables\LedgerPersistable;
use ERP\Core\Support\Service\ContainerInterface;
use ERP\Exceptions\ExceptionMessage;
use ERP\Model\Accounting\Ledgers\LedgerModel;
use ERP\Entities\AuthenticationClass\TokenAuthentication;
use ERP\Entities\Constants\ConstantClass;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class LedgerController extends BaseController implements ContainerInterface
{
	/**
     * @var ledgerService
     * @var processor
     * @var request
     * @var ledgerPersistable
     */
	private $ledgerService;
	private $processor;
	private $request;
	private $ledgerPersistable;	
	
	/**
	 * get and invoke method is of ContainerInterface method
	 */		
    public function get($id,$name)
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
		$requestUri = explode('/',$_SERVER['REQUEST_URI']);
		if((strcmp($requestUri[1],"accounting")==0 && strcmp($requestUri[2],"bills")==0) ||
			(strcmp($requestUri[2], 'quotations')==0 && strcmp($requestUri[3], 'convert')==0) ||
			(strcmp($requestUri[1], 'accounting')==0 && strcmp($requestUri[2], 'purchase-bills')==0))
		{
			$this->request = $request;
			// check the requested Http method
			$requestMethod = $_SERVER['REQUEST_METHOD'];
			// insert
			if($requestMethod == 'POST')
			{
				$processor = new LedgerProcessor();
				$ledgerPersistable = new LedgerPersistable();
				$ledgerPersistable = $processor->createPersistable($this->request);
				if($ledgerPersistable[0][0]=='[')
				{
					return $ledgerPersistable;
				}
				else if(is_array($ledgerPersistable))
				{
					$ledgerService= new LedgerService();
					$status = $ledgerService->insert($ledgerPersistable);
					return $status;
				}
				else
				{
					return $ledgerPersistable;
				}
			}
		}
		else
		{
			//Authentication
			$tokenAuthentication = new TokenAuthentication();
			$authenticationResult = $tokenAuthentication->authenticate($request->header(),'ledgers.add');
			
			//get constant array
			$constantClass = new ConstantClass();
			$constantArray = $constantClass->constantVariable();
			
			if(strcmp($constantArray['success'],$authenticationResult)==0)
			{
				$this->request = $request;
				// check the requested Http method
				$requestMethod = $_SERVER['REQUEST_METHOD'];
				// insert
				if($requestMethod == 'POST')
				{
					$processor = new LedgerProcessor();
					$ledgerPersistable = new LedgerPersistable();
					$ledgerPersistable = $processor->createPersistable($this->request);
					if($ledgerPersistable[0][0]=='[')
					{
						return $ledgerPersistable;
					}
					else if(is_array($ledgerPersistable))
					{
						$ledgerService= new LedgerService();
						$status = $ledgerService->insert($ledgerPersistable);
						return $status;
					}
					else
					{
						return $ledgerPersistable;
					}
				}
			}
			else
			{
				return $authenticationResult;
			}
		}
	}
	
	/**
     * get the specified resource.
     * @param  int  $ledgerId
     */
    public function getData(Request $request,$ledgerId=null)
    {
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			if($ledgerId==null)
			{	
				$ledgerService= new LedgerService();
				$status = $ledgerService->getAllLedgerData();
				return $status;
			}
			else
			{	
				$ledgerService= new LedgerService();
				$status = $ledgerService->getLedgerData($ledgerId);
				return $status;
			}
		}
		else
		{
			return $authenticationResult;
		}
	}

	public function getAllLedgers(Request $request)
	{
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getAllLedgers();
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}

	public function getCategorywiseLedger(Request $request,$lid,$from,$to)
	{
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getCategorywiseLedger($lid,$from,$to);
			// if(isset($status) && count($status)>0)
			// {
			// 	$data = [
			// 		'status'=>1,
			// 		'message'=>'Clients data retrived successfully',
			// 		'data'=>$status];
			// 	return $data;
			// }
			// $data = [
			// 		'status'=>0,
			// 		'message'=>'Data not found',
			// 		'data'=>$status];
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}

	public function getCategoryDataLedger(Request $request,$lid,$cid,$from,$to)
	{
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getCategoryDataLedger($lid,$cid,$from,$to);
			// if(isset($status) && count($status)>0)
			// {
			// 	$data = [
			// 		'status'=>1,
			// 		'message'=>'Clients data retrived successfully',
			// 		'data'=>$status];
			// 	return $data;
			// }
			// $data = [
			// 		'status'=>0,
			// 		'message'=>'Data not found',
			// 		'data'=>$status];
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}


	public function getOutstandings(Request $request)
	{
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getOutstandings();
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}
	
	/**
     * get the specified resource.
     * @param  int  $userId
     */
	public function getUserData(Request $request,$userId)
	{
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			if (array_key_exists('companyid', $request->header())) 
			{
				$headerData = $request->header();
				$ledgerService= new LedgerService();
				$status = $ledgerService->getUserData($userId,$headerData);
				return $status;
			}else{
				return $exceptionArray['204'];
			}
			
		}
		else
		{
			return $authenticationResult;
		}
	}
	/**
     * get the specified resource.
     * @param  int  $ledgerGrpId
     */
    public function getAllData(Request $request,$ledgerGrpId)
    {
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getAllData($ledgerGrpId);
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}

	public function getCompanyLedgerData(Request $request,$companyId,$ledgerGrpId)
    {
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getCompanyData($companyId,$ledgerGrpId);
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}
	
	
	/**
     * get the specified resource.
     * @param  int  $companyId
     */
    public function getLedgerData(Request $request,$companyId)
    {
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());
		
		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			//get exception message
			$exception = new ExceptionMessage();
			$exceptionArray = $exception->messageArrays();
			if(array_key_exists("type",$request->header()))
			{
				if(strcmp(trim($request->header()['type'][0]),'retail_sales')==0 || strcmp(trim($request->header()['type'][0]),'purchase')==0 || strcmp(trim($request->header()['type'][0]),'whole_sales')==0 || strcmp(trim($request->header()['type'][0]),'all')==0)
				{
					if(array_key_exists("fromdate",$request->header()) && array_key_exists("todate",$request->header()))
					{
						$this->request = $request;
						$processor = new LedgerProcessor();
						$ledgerPersistable = new LedgerPersistable();
						$ledgerPersistable = $processor->createPersistableData($this->request);
						$ledgerService= new LedgerService();
						$status = $ledgerService->getData($ledgerPersistable,$companyId,$request->header()['type'][0]);
						return $status;
					}
					//get current year data
					else
					{
						$ledgerService = new LedgerService();
						$status = $ledgerService->getCurrentYearData($companyId,$request->header()['type'][0]);
						return $status;
					}
				}
				else
				{
					return $exceptionArray['content'];
				}
			}
			else if(array_key_exists("ledgergroup",$request->header()))
			{
				$ledgerarray = explode(",", $request->header()['ledgergroup'][0]);
				$ledgerService= new LedgerService();
				$ledgerResult = $ledgerService->getDataAsLedgerGrp($ledgerarray,$companyId);
				return $ledgerResult;
			}
			else if(array_key_exists("ledgername",$request->header()))
			{
				$ledgerService= new LedgerService();
				$ledgerResult = $ledgerService->getLedgerDataAsName($request->header(),$companyId);
				return $ledgerResult;
			}
			else
			{
				$ledgerService= new LedgerService();
				$status = $ledgerService->getLedgerDetail($companyId);
				return $status;
			}
		}
		else
		{
			return $authenticationResult;
		}
	}
	
	/**
     * get the transaction resource.
     * @param  int  $ledgerId
     */
    public function getLedgerTransactionData(Request $request,$ledgerId)
    {
		//Authentication
		$tokenAuthentication = new TokenAuthentication();
		$authenticationResult = $tokenAuthentication->authenticate($request->header());

		//get constant array
		$constantClass = new ConstantClass();
		$constantArray = $constantClass->constantVariable();
		
		if(strcmp($constantArray['success'],$authenticationResult)==0)
		{
			$ledgerService= new LedgerService();
			$status = $ledgerService->getLedgerTransactionDetail($ledgerId);
			return $status;
		}
		else
		{
			return $authenticationResult;
		}
	}
	
    /**
     * Update the specified resource in storage.
     * @param  Request object[Request $request]
     * @param  ledger_id
     */
	public function update(Request $request,$ledgerId)
    {  
		$RequestUri = explode("/", $_SERVER['REQUEST_URI']);
		if(strcmp($RequestUri[1],"accounting")==0 && strcmp($RequestUri[2],"bills")==0 || strcmp($RequestUri[1],"clients")==0 ||
			(strcmp($RequestUri[2], 'quotations')==0 && strcmp($RequestUri[3], 'convert')==0))
		{
			$this->request = $request;
			
			$ledgerModel = new LedgerModel();
			$result = $ledgerModel->getData($ledgerId);
			
			//get exception message
			$exception = new ExceptionMessage();
			$exceptionArray = $exception->messageArrays();
			if(strcmp($result,$exceptionArray['404'])==0)
			{
				return $result;
			}
			else
			{
			
				$processor = new LedgerProcessor();
				$ledgerPersistable = new LedgerPersistable();
				$ledgerPersistable = $processor->createPersistableChange($this->request,$ledgerId,$result);
				
				//here two array and string is return at a time
				if(is_array($ledgerPersistable))
				{
					$ledgerService= new LedgerService();
					$status = $ledgerService->update($ledgerPersistable);
					return $status;
				}
				else
				{
					return $ledgerPersistable;
				}
			}
		}
		else
		{
			//Authentication
			$tokenAuthentication = new TokenAuthentication();
			$authenticationResult = $tokenAuthentication->authenticate($request->header(),'ledgers.edit');
			
			//get constant array
			$constantClass = new ConstantClass();
			$constantArray = $constantClass->constantVariable();
			
			if(strcmp($constantArray['success'],$authenticationResult)==0)
			{
				$this->request = $request;
				$processor = new LedgerProcessor();
				$ledgerPersistable = new LedgerPersistable();		
				$ledgerService= new LedgerService();		
				$ledgerModel = new LedgerModel();
				$result = $ledgerModel->getData($ledgerId);
				
				//get exception message
				$exception = new ExceptionMessage();
				$exceptionArray = $exception->messageArrays();
				if(strcmp($result,$exceptionArray['404'])==0)
				{
					return $result;
				}
				else
				{
					$ledgerPersistable = $processor->createPersistableChange($this->request,$ledgerId,$result);
					//here two array and string is return at a time
					if(is_array($ledgerPersistable))
					{
						$status = $ledgerService->update($ledgerPersistable);
						return $status;
					}
					else
					{
						return $ledgerPersistable;
					}
				}
			}
			else
			{
				return $authenticationResult;
			}
		}
	}
	
    /**
     * Remove the specified resource from storage.
     * @param  Request object[Request $request]
     * @param  ledger_id     
     */
    public function destroy(Request $request,$ledgerId)
    {
		$this->request = $request;
		$Processor = new LedgerProcessor();
		$ledgerPersistable = new LedgerPersistable();		
		$ledgerService= new LedgerService();	
		$ledgerModel = new LedgerModel();
		$result = $ledgerModel->getData($ledgerId);
		
		//get exception message
		$exception = new ExceptionMessage();
		$fileSizeArray = $exception->messageArrays();
		if(strcmp($result,$fileSizeArray['404'])==0)
		{
			return $result;
		}
		else
		{
			$ledgerPersistable = $Processor->createPersistableChange($this->request,$ledgerId);
			$ledgerService->create($ledgerPersistable);
			$status = $ledgerService->delete($ledgerPersistable);
			return $status;
		}
    }
}