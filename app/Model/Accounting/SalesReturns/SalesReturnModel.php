<?php
namespace ERP\Model\Accounting\SalesReturns;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;
use ERP\Exceptions\ExceptionMessage;
use ERP\Entities\Constants\ConstantClass;
use Illuminate\Container\Container;
use ERP\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use stdClass;
// Inventory Deps
use ERP\Api\V1_0\Accounting\SalesReturns\Transformers\SaleReturnInventoryTransformer;
use ERP\Model\Accounting\SalesReturns\SaleReturnInventoryModel;
/**
 * @author Hiren Faldu<hiren.f@siliconbrain.in>
 */
class SalesReturnModel extends Model
{
	protected $table = 'sales_return';

	function __construct()
	{
		parent::__construct();

		$exceptions = new ExceptionMessage();
		$this->messages = $exceptions->messageArrays();
		$this->constant = new ConstantClass();
		$this->constantVars = $this->constant->constantVariable();
		$database = $this->constant->constantDatabase();
		$this->database = DB::connection($database);
	}
	/**
	 * insert data with document
	 * @param  array
	 * returns the status
	*/
	public function insertData($salesReturnData, $requestData)
	{
		$mytime = Carbon\Carbon::now();
		//get exception message
		$exceptionArray = $this->messages;
		$requestInput = $requestData->input();
		$insertKeyStr = "";
		$insertValueStr = "";
		$insertables = ['product_array','payment_mode','bank_name','bank_ledger_id','invoice_number','check_number','total','total_discounttype','total_discount','total_cgst_percentage','total_sgst_percentage','total_igst_percentage','extra_charge','tax','grand_total','advance','balance','remark','entry_date','client_id','company_id','branch_id','sale_id','jf_id'];
		$separator = '';
		$values = array();
		foreach ($insertables as $value) {
			if (array_key_exists($value, $salesReturnData)) {
				$insertKeyStr .= $separator."{$value}";
				$insertValueStr .= $separator." ?";
				array_push($values, $salesReturnData[$value]);
				$separator = ",";
			}
		}
		$insertKeyStr .= ",created_at, updated_at";
		$insertValueStr .= ", ?, ?";
		array_push($values, $mytime, $mytime);
		DB::beginTransaction();
		
		$raw = $this->database->statement("INSERT INTO `sales_return` ($insertKeyStr) VALUES ($insertValueStr);", $values);
		$returnId = $this->database->select("SELECT max(sale_return_id) as return_id FROM sales_return;");
		if(array_key_exists('product_array', $salesReturnData)) {
			$returnId = $returnId[0]->return_id;
			$transformer = new SaleReturnInventoryTransformer();
			$trimInv = $transformer->trimInventory($salesReturnData['product_array'], $returnId);
			$invModel = new SaleReturnInventoryModel();
			$status = $invModel->insertData($trimInv);
		}
		DB::commit();
		if ($raw==1) {
			return $exceptionArray['200'];
		} else {
			return $exceptionArray['500'];
		}
	}
	public function getAll($companyId,$data)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

			DB::beginTransaction();
			DB::statement('SET group_concat_max_len = 1000000');
			$raw = $this->database->select("select 
			s.sale_return_id as saleReturnId,
			s.product_array as productArray,
			s.payment_mode as paymentMode,
			s.bank_ledger_id as bankLedgerId,
			s.bank_name as bankName,
			s.invoice_number as invoiceNumber,
			s.check_number as checkNumber,
			s.total,
			s.total_discounttype as totalDiscounttype,
			s.total_discount as totalDiscount,
			s.total_cgst_percentage as totalCgstPercentage,
			s.total_sgst_percentage as totalSgstPercentage,
			s.total_igst_percentage as totalIgstPercentage,
			s.extra_charge as extraCharges,
			s.tax,
			s.grand_total as grandTotal,
			s.advance,
			s.balance,
			s.remark,
			s.entry_date as entryDate,
			c.client_name as clientName
			from sales_return as s
			join client_mst as c on c.client_id=s.client_id
			where (s.entry_date BETWEEN '".$data['fromdate'][0]."' AND '".$data['todate'][0]."') and 
			s.company_id='".$companyId."' and 
			s.deleted_at='0000-00-00 00:00:00'");
			DB::commit();
			if(count($raw)==0)
			{
				return $exceptionArray['404']; 
			}
			else
			{
				return json_encode($raw);
			}
	}
}