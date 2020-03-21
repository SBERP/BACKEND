<?php
namespace ERP\Model\Users;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;
use ERP\Exceptions\ExceptionMessage;
use ERP\Entities\Constants\ConstantClass;
use ERP\Http\Requests;
use Illuminate\Http\Request;
use ERP\Core\Users\Entities\UserArray;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class UserModel extends Model
{
	protected $table = 'user_mst';
	
	/**
	 * insert data 
	 * @param  array
	 * returns the status
	*/
	
	public function generatePermissionArray($raw)
	{
		$data = [];
		foreach($raw as $val)
		{
			$data[explode('.',$val->name)[0]][explode('.',$val->name)[1]]=true;
		}

		$permissionsArray = [];

		$configuration = [];
		$configuration['group'] = 'configuration';
		$configuration['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='company' || $key=='branch' || $key=='staff' || $key=='invoiceno' || $key=='quotationno' || $key=='template' || $key=='setting')
			{
				$configuration['data'][$key]=$val;
			}
		}
		$permissionsArray[$configuration['group']]=$configuration['data'];

		$accounting = [];
		$accounting['group'] = 'accounting';

		$accounting['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='salesbill' || $key=='purchasebill' || $key=='salesorder' || $key=='purchaseorder' || $key=='quotation' || $key=='creditnotes' || $key=='debitnotes' || $key=='specialjournal' || $key=='payment' || $key=='receipt' || $key=='statement' || $key=='taxation' || $key=='ledgers' || $key=='quotationflow')
			{
				$accounting['data'][$key]=$val;
			}
		}
		$permissionsArray[$accounting['group']]=$accounting['data'];

		$inventory = [];
		$inventory['group'] = 'inventory';

		$inventory['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='brand' || $key=='category' || $key=='product' || $key=='barcodepoint' || $key=='stockregister' || $key=='stocksummary')
			{
				$inventory['data'][$key]=$val;
			}
		}
		$permissionsArray[$inventory['group']]=$inventory['data'];

		$crm = [];
		$crm['group'] = 'crm';

		$crm['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='jobcard' || $key=='client')
			{
				$crm['data'][$key]=$val;
			}
		}
		$permissionsArray[$crm['group']]=$crm['data'];

		$analyzer = [];
		$analyzer['group'] = 'analyzer';

		$analyzer['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='analyzers')
			{
				$analyzer['data'][$key]=$val;
			}
		}
		$permissionsArray[$analyzer['group']]=$analyzer['data'];

		$pricelist = [];
		$pricelist['group'] = 'pricelist';

		$pricelist['data'] = [];

		foreach($data as $key=>$val)
		{
			if($key=='tax')
			{
				$pricelist['data'][$key]=$val;
			}
		}
		$permissionsArray[$pricelist['group']]=$pricelist['data'];

		return [$permissionsArray];
	}

	public function insertData()
	{
		$mytime = Carbon\Carbon::now();
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$getUserData = array();
		$getUserKey = array();
		$getUserData = func_get_arg(0);
		$getUserKey = func_get_arg(1);
		$userData="";
		$keyName = "";
		for($data=0;$data<count($getUserData);$data++)
		{
			if($data == (count($getUserData)-1))
			{
				$userData = $userData."'".$getUserData[$data]."'";
				$keyName =$keyName.$getUserKey[$data];
			}
			else
			{
				$userData = $userData."'".$getUserData[$data]."',";
				$keyName =$keyName.$getUserKey[$data].",";
			}
		}
		$vals = explode(',', $userData);
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("insert into user_mst(".$keyName.",created_at) 
			values(".$userData.",'".$mytime."')");
		DB::commit();

		if($vals[1]=="'architect'" || $vals[1]=="'carpenter'")
		{
			DB::beginTransaction();
			$raw1 = DB::connection($databaseName)->select("select user_id,user_name from user_mst where email_id=".$vals[2]."");
			DB::commit();

			if(count($raw1)==0)
				return [];

			DB::beginTransaction();
			$raw2 = DB::connection($databaseName)->statement("insert into ledger_mst(ledger_name,inventory_affected,address1,contact_no,email_id,outstanding_limit_type,created_at,state_abb,city_id,ledger_group_id,company_id,staff_id) 
				values(".$vals[0].",'no',".$vals[5].",".$vals[4].",".$vals[2].",'credit','".$mytime."',".$vals[7].",".$vals[8].",31,".$vals[9].",".$raw1[0]->user_id.")");
			DB::commit();

			DB::beginTransaction();
			$ledgerId = DB::connection($databaseName)->select("SELECT  MAX(ledger_id) AS ledger_id from ledger_mst where deleted_at='0000-00-00 00:00:00'");
			$result = DB::connection($databaseName)->statement("CREATE TABLE ".$ledgerId[0]->ledger_id."_ledger_dtl (
				`".$ledgerId[0]->ledger_id."_id` int(11) NOT NULL AUTO_INCREMENT,
				`amount` decimal(20,4) NOT NULL DEFAULT '0.0000',
				`amount_type` enum('credit','debit') NOT NULL DEFAULT 'credit',
				`entry_date` date NOT NULL DEFAULT '0000-00-00',
				`jf_id` int(11) NOT NULL,
				`balance_flag` enum('','opening','closing') NOT NULL DEFAULT '',
				`created_at` datetime NOT NULL,
				`updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`ledger_id` int(11) NOT NULL,
				PRIMARY KEY (`".$ledgerId[0]->ledger_id."_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf16");
			DB::commit();

			DB::beginTransaction();
			$raw2 = DB::connection($databaseName)->statement("insert into ".$ledgerId[0]->ledger_id."_ledger_dtl(amount,entry_date,jf_id,balance_flag,created_at,ledger_id) 
				values(0,'".$mytime."',0,'opening','".$mytime."',".$ledgerId[0]->ledger_id.")");
			DB::commit();
		}
		
		// get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if($raw==1)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}
	/**
	 * update data 
	 * @param user-id,user-data and key of user-data
	 * returns the status
	*/
	public function updateData($userData,$key,$userId)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$mytime = Carbon\Carbon::now();
		$keyValueString="";
		for($data=0;$data<count($userData);$data++)
		{
			$keyValueString=$keyValueString.$key[$data]."='".$userData[$data]."',";
		}
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("update user_mst 
			set ".$keyValueString."updated_at='".$mytime."'
			where user_id = '".$userId."' and deleted_at='0000-00-00 00:00:00'");
		DB::commit();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if($raw==1)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}
	
	/**
	 * get All data 
	 * returns the status
	*/
	public function getAllData(Request $request,$emailId = '')
	{	
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		$extendedQuery = "and user_type != 'superadmin'";
		if ($emailId != '') {
			$extendedQuery = "and email_id = '$emailId'";
		}
		if(array_key_exists('companyid',$request->header()) || array_key_exists('branchid',$request->header()))
		{
			$userArray = new UserArray();
			$userArrayData = $userArray->userSearching();
			$querySet = "";
			for($arrayData=0;$arrayData<count($userArrayData);$arrayData++)
			{
				if(array_key_exists(array_keys($userArrayData)[$arrayData],$request->header()))
				{
					$querySet = $querySet.$userArrayData[array_keys($userArrayData)[$arrayData]]." = ".$request->header()[array_keys($userArrayData)[$arrayData]][0]." and ";
				}
			}
			DB::beginTransaction();	
			$raw = DB::connection($databaseName)->select("select 
				u.user_id,
				u.user_name,
				u.user_type,
				u.email_id,
				u.password,
				u.contact_no,
				u.address,
				u.pincode,
				u.state_abb,
				u.city_id,
				u.company_id,
				u.branch_id,
				u.role_id,
				r.name as role_name,
				u.permission_array,
				u.default_company_id,
				u.created_at,
				u.updated_at
				from user_mst as u
				left join roles as r on u.role_id=r.id 
				where ".$querySet." u.deleted_at='0000-00-00 00:00:00' $extendedQuery");
			DB::commit();
		}
		else
		{
			DB::beginTransaction();		
			$raw = DB::connection($databaseName)->select("select 
				u.user_id,
				u.user_name,
				u.user_type,
				u.email_id,
				u.password,
				u.contact_no,
				u.address,
				u.pincode,
				u.state_abb,
				u.city_id,
				u.company_id,
				u.branch_id,
				u.role_id,
				r.name as role_name,
				u.permission_array,
				u.default_company_id,
				u.created_at,
				u.updated_at
				from user_mst as u
				left join roles as r on u.role_id=r.id 
				where u.deleted_at='0000-00-00 00:00:00' $extendedQuery");
			DB::commit();
		}
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if(count($raw)==0)
		{
			return $exceptionArray['204'];
		}
		else
		{
			$enocodedData = json_encode($raw);
			return $enocodedData;
		}
	}
	
	/**
	 * get data as per given user_id
	 * @param $userId
	 * returns the status
	*/
	public function getData($userId)
	{	
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select 
			u.user_id,
			u.user_name,
			u.user_type,
			u.email_id,
			u.password,
			u.contact_no,
			u.address,
			u.pincode,
			u.state_abb,
			u.city_id,
			u.company_id,
			u.branch_id,
			u.role_id,
			r.name as role_name,
			u.permission_array,
			u.default_company_id,
			u.created_at,
			u.updated_at
			from user_mst as u 
			left join roles as r  on u.role_id=r.id 
			where user_id = '".$userId."' and u.deleted_at='0000-00-00 00:00:00'");
		DB::commit();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if(count($raw)==0)
		{
			return $exceptionArray['404'];
		}
		else
		{
			$enocodedData = json_encode($raw,true); 
			return $enocodedData;
		}
	}
	
	//delete
	public function deleteData($userId)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		DB::beginTransaction();
		$mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->statement("update user_mst 
			set deleted_at='".$mytime."'
			where user_id = '".$userId."'");
		DB::commit();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if($raw==1)
		{
			$activeSession = DB::statement("delete 
				from active_session 
				where user_id = '".$userId."'");
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}

	public function getPermissionsData()
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select 
			id,
			name
			from permissions");
		DB::commit();

		$permissionsArray = $this->generatePermissionArray($raw);
		
		//get exception message
		// $exception = new ExceptionMessage();
		// $exceptionArray = $exception->messageArrays();
		// if(count($raw)==0)
		// {
		// 	return $exceptionArray['404'];
		// }
		// else
		// {
			$enocodedData = json_encode($permissionsArray,true); 
			return $enocodedData;
		// }
	}

	public function updatePermissions($request)
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		$roleId = $request['roleId'];
		$permissions = json_decode($request['permissions']);
		$mytime = Carbon\Carbon::now();

		DB::beginTransaction();
		// $mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->statement("delete from role_permission 
			where role_id = '".$roleId."'");
		DB::commit();

		foreach($permissions[0] as $key=>$value)
		{
			foreach($value as $key2=>$value2)
			{
				foreach($value2 as $key3=>$value3)
				{
					$raw = [];
					if($value3==true)
					{
						if($key2!='setting')
						{
							DB::beginTransaction();
							$raw = DB::connection($databaseName)->select("select id from permissions where name='".$key2.'.'.$key3."'");
							DB::commit();
						}
						else
						{
							DB::beginTransaction();
							$raw = DB::connection($databaseName)->select("select id from permissions where name='".$key2.'.'.$key3.".all'");
							DB::commit();
						}
						if(count($raw)!=0)
						{
							$id = $raw[0]->id;
							DB::beginTransaction();
							$raw = DB::connection($databaseName)->statement("insert into role_permission (role_id,permission_id,created_at,updated_at) values (".$roleId.",".$id.",'".$mytime."','".$mytime."')");
							DB::commit();
						}
					}
				}
			}
			
		}
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		return $exceptionArray['200'];
		// if(count($permissions)>0)
		// {
		// 	$query = "insert into role_permission (role_id,permission_id,created_at,updated_at) values ";
		// 	foreach($permissions as $permission)
		// 	{
		// 		$query .= ("(".$roleId.",".$permission.",'".$mytime."','".$mytime."'),"); 
		// 	}
		// 	$query = rtrim($query, ",");
		// 	DB::beginTransaction();
		// 	// $mytime = Carbon\Carbon::now();
		// 	$raw = DB::connection($databaseName)->statement($query);
		// 	DB::commit();
		// 	if($raw==1)
		// 	{
		// 		return $exceptionArray['200'];
		// 	}
		// 	else
		// 	{
		// 		return $exceptionArray['500'];
		// 	}

		// }
		// else
		// {
		// 	return $exceptionArray['500'];
		// }
	}

	public function getPermissions($roleId)
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select 
			id,
			name
			from permissions where id in (select permission_id from role_permission where role_id=".$roleId.")");
		DB::commit();

		// $data = [];
		// foreach($raw as $val)
		// {
		// 	$inst = [];
		// 	for($i = 0;$i<count($data);$i++)
		// 	{
		// 		if($data[$i]['module']==explode('.',$val->name)[0])
		// 		{
		// 			break;
		// 		}
		// 	}
		// 	if($i!=count($data))
		// 	{
		// 		array_push($data[$i]['permissions'], $val);
		// 	}
		// 	else
		// 	{
		// 		$inst['module']=explode('.',$val->name)[0];
		// 		$inst['permissions']=[];
		// 		array_push($inst['permissions'], $val);
		// 		array_push($data, $inst);
		// 	}

		// }

		$permissionsArray = $this->generatePermissionArray($raw);
		
		//get exception message
		// $exception = new ExceptionMessage();
		// $exceptionArray = $exception->messageArrays();
		// if(count($raw)==0)
		// {
		// 	return $exceptionArray['404'];
		// }
		// else
		// {
			$enocodedData = json_encode($permissionsArray,true); 
			return $enocodedData;
		// }
	}
	public function getRolesAll()
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select 
			id as roleId,
			name as role,
			description
			from roles where deleted_at='0000-00-00 00:00:00'");
		DB::commit();

		for($i=0;$i<count($raw);$i++)
		{
			$raw[$i]->permissionsArray=json_decode($this->getPermissions($raw[$i]->roleId));
		}
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		if(count($raw)==0)
		{
			return $exceptionArray['404'];
		}
		else
		{
			$enocodedData = json_encode($raw,true); 
			return $enocodedData;
		}
	}

	public function roleStore($request)
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		$mytime = Carbon\Carbon::now();

		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		$query = "insert into roles (name,description,created_at,updated_at) values ('".$request['role']."','".$request['description']."','".$mytime."','".$mytime."')";
		DB::beginTransaction();
		// $mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->statement($query);
		DB::commit();
		if($raw==1)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}

	public function roleUpdate($request,$roleId)
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		$mytime = Carbon\Carbon::now();

		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		$query = "update roles set name='".$request['role']."', description='".$request['description']."', updated_at='".$mytime."' where id='".$roleId."'";
		// return $query;
		DB::beginTransaction();
		// $mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->statement($query);
		DB::commit();
		if($raw==1)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}

	public function roleDestroy($roleId)
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		$mytime = Carbon\Carbon::now();

		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		$query = "update roles set deleted_at='".$mytime."' where id='".$roleId."'";
		// return $query;
		DB::beginTransaction();
		// $mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->statement($query);
		DB::commit();
		if($raw==1)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['500'];
		}
	}

	public function getActivity()
	{
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();

		$mytime = Carbon\Carbon::now();

		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		$messageBag = [
			"[user] has performed activity [activity] on module [module].",
			"Module [module] got accessed by [user] and her/she performed [activity] on it.",
			"Opps, [user] has tried [activity] on [module] and he succeed",
			"[module] got affected by [activity], for more details contact [user]",
			"[activity] performed on [module] by [user]"];

		$query = "select 
		u.user_name as userName,
		a.module,
		a.activity,
		a.timestamp
		from activity_log as a
		join user_mst as u on a.user_id=u.user_id
		order by a.timestamp desc";
		// return $query;
		DB::beginTransaction();
		// $mytime = Carbon\Carbon::now();
		$raw = DB::connection($databaseName)->select($query);
		DB::commit();
		foreach($raw as $data)
		{
			$data->userName = ucwords($data->userName);
			$data->module = ucwords($data->module);
			$data->activity = ucwords($data->activity);
			$msg = $messageBag[rand(0,4)];
			$data->description = str_replace('[activity]',$data->activity, str_replace('[module]',$data->module, str_replace('[user]', $data->userName, $msg)));
		}
		if(count($raw)>0)
		{
			return json_encode($raw);
		}
		else
		{
			return $exceptionArray['404'];
		}
	}
}
