<?php
namespace ERP\Model\Authenticate;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;
use ERP\Exceptions\ExceptionMessage;
use ERP\Entities\Constants\ConstantClass;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class AuthenticateModel extends Model
{
	protected $table = 'active_session';
	
	/**
	 * insert data 
	 * @param  array
	 * returns the status
	*/
	public function insertData($userId,$token)
	{
		$mytime = Carbon\Carbon::now();
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$mytime = Carbon\Carbon::now();
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("insert into active_session
		(user_id,
		token,
		updated_at,
		created_at)
		values(
		'".$userId."',
		'".$token."',
		'".$mytime."',
		'".$mytime."'
		)");
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
	 * update date 
	 * @param user-id
	 * returns the status
	*/
	public function updateDate($userId)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$mytime = Carbon\Carbon::now();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("update active_session 
		set updated_at='".$mytime."' where user_id='".$userId."'");
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
	 * get data
	 * returns the exception-message/arraydata
	*/
	public function getAllData()
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select
		session_id,
		token,
		created_at,
		updated_at,
		web_integration_token,
		web_integration_expire_datetime,
		user_id
		from active_session");
		DB::commit();
		
		if(count($raw)!=0)
		{
			$enocodedData = json_encode($raw);
			return $enocodedData;
		}
		else
		{
			return $exceptionArray['204'];
		}
	}
	
	/**
	 * get data 
	 * @param user-id
	 * returns the exception-message/arraydata
	*/
	public function getData($userId)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select
		session_id,
		token,
		created_at,
		updated_at,
		web_integration_token,
		web_integration_expire_datetime,
		user_id
		from active_session where user_id='".$userId."'");
		DB::commit();
		
		if(count($raw)!=0)
		{
			$enocodedData = json_encode($raw);
			return $enocodedData;
		}
		else
		{
			return $exceptionArray['404'];
		}
	}
	
	/**
	 * get user-type 
	 * @param header-data
	 * returns the exception-message/user-type
	*/
	public function getUserType($headerData)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select
		u.user_type
		from active_session a  
		RIGHT JOIN user_mst u
		ON a.user_id=u.user_id
		where token='".$headerData['authenticationtoken'][0]."'");
		DB::commit();
		if(count($raw)!=0)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['content'];
		}
	}

	/**
	 * get user-type 
	 * @param header-data
	 * returns the exception-message/user-type
	*/
	public function getUserTypeForPermission($headerData)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select
		u.user_type
		from active_session a  
		RIGHT JOIN user_mst u
		ON a.user_id=u.user_id
		where token='".$headerData['authenticationtoken'][0]."'");
		DB::commit();
		if(count($raw)!=0)
		{
			return $exceptionArray['200'];
		}
		else
		{
			return $exceptionArray['content'];
		}
	}
	
	/**
	 * get user-type 
	 * @param header-data
	 * returns the exception-message/user-type
	*/
	public function getActiveUser($headerData)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		if(array_key_exists('authenticationtoken', $headerData))
		{
			$authenticationtoken = $headerData['authenticationtoken'][0];
			DB::beginTransaction();
			$raw = DB::connection($databaseName)->select("select
			user_id
			from active_session
			where token='".$authenticationtoken."'");
			DB::commit();
		}
		else
		{
			DB::beginTransaction();
			$raw = DB::connection($databaseName)->select("select
			user_id
			from active_session
			where user_id=(select user_id from user_mst where user_type='superadmin')");
			DB::commit();
		}
		
		if(count($raw)!==0)
		{
			return $raw;
		}
		else
		{
			return $exceptionArray['userLogin'];
		}
	}
	
	/**
	 * get user-type 
	 * @param header-data
	 * returns the exception-message/user-type
	*/
	public function checkAuthenticationToken($headerData)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select
		session_id,
		updated_at
		from active_session
		where token='".$headerData."'");

		DB::commit();
		if(count($raw)!=0)
		{
			return $raw;
		}
		else
		{
			return $exceptionArray['token'];
		}
	}

	
	/**
	 * change updated_at date
	 * @param header-data
	 * returns the exception-message/status
	*/
	public function changeDate($headerData)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$mytime = Carbon\Carbon::now();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("update active_session
		set updated_at='".$mytime."'
		where token='".$headerData['authenticationtoken'][0]."'");
		DB::commit();
		return $exceptionArray['200'];
	}

	/**
	 * Refresh Webtoken
	 * @param header-data
	 * returns the exception-message/status
	*/
	public function freshWebToken($tokenArray,$session_id)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		$mytime = Carbon\Carbon::now();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->statement("update active_session
		set web_integration_expire_datetime='".$tokenArray['expireDate']."',web_integration_token='".$tokenArray['token']."' where session_id =".$session_id);
		DB::commit();
		return $exceptionArray['200'];
	}

	/**
	 * get Web Token and ExpireDate
	 * @param header-data
	 * returns the exception-message/user-type
	*/
	public function getActiveWebUser($authToken)
	{
		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();
		
		if($authToken != '')
		{
			DB::beginTransaction();
			$raw = DB::connection($databaseName)->select("select
			session_id,
			token,
			created_at,
			updated_at,
			web_integration_token,
			web_integration_expire_datetime,
			user_id
			from active_session
			where token='".$authToken."'");
			DB::commit();
		}
		
		if(count($raw)!==0)
		{
			return $raw;
		}
		else
		{
			return $exceptionArray['404'];
		}
	}

	public function checkPermission($headerData,$permission)
	{

		//database selection
		$database = "";
		$constantDatabase = new ConstantClass();
		$databaseName = $constantDatabase->constantDatabase();
		
		//get exception message
		$exception = new ExceptionMessage();
		$exceptionArray = $exception->messageArrays();

		$success = 0;

		// DB::beginTransaction();
		// $raw = DB::connection($databaseName)->select("select name from permissions where id in (select permission_id from role_permission where role_id in (select role_id from user_mst where user_id in (select user_id from active_session where token='".$headerData."')))");
		// DB::commit();

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select role_id,user_id from user_mst where user_id in (select user_id from active_session where token='".$headerData."')");
		DB::commit();

		if(count($raw)==0)
		{
			return 0;
		}
		else if($raw[0]->role_id==0)
		{
			// $success = 1;
			DB::beginTransaction();
			$raw = DB::connection($databaseName)->statement("insert into activity_log (activity,module,user_id) values ('".explode('.', $permission)[1]."','".explode('.', $permission)[0]."',".$raw[0]->user_id.")");
			DB::commit();
			return 1;
		}

		$userId = $raw[0]->user_id;

		DB::beginTransaction();
		$raw = DB::connection($databaseName)->select("select name from permissions where id in (select permission_id from role_permission where role_id=".$raw[0]->role_id.")");
		DB::commit();

		// return json_encode($raw);
		
		foreach($raw as $data)
		{
			if($data->name==$permission)
			{
				$success = 1;
				break;
			}
		}

		if($success==1)
		{
			DB::beginTransaction();
			$raw = DB::connection($databaseName)->statement("insert into activity_log (activity,module,user_id) values ('".explode('.', $permission)[1]."','".explode('.', $permission)[0]."',".$userId.")");
			DB::commit();
		}

		// return json_encode($raw);
		return $success;

		// if(count($raw)!=0)
		// {
		// 	return $raw;
		// }
		// else
		// {
		// 	return $exceptionArray['token'];
		// }
	}
}
