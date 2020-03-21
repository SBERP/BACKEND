<?php
namespace ERP\Api\V1_0\Users\Routes;

use ERP\Api\V1_0\User\Controllers\UserController;
use ERP\Support\Interfaces\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use Illuminate\Support\Facades\Route;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class User implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
	 * description : this function is going to the controller page
     */
    public function register(RegistrarInterface $Registrar)
    {
		// all the possible get request 
		Route::group(['as' => 'get'], function ()
		{
			Route::get('Users/User/activity','Users\Controllers\UserController@getActivity');
			Route::get('Users/User/{userId?}', 'Users\Controllers\UserController@getData');
			Route::get('Users/User/permissions/all', 'Users\Controllers\UserController@getPermissionsAll');
			Route::get('Users/User/permissions/{roleId}', 'Users\Controllers\UserController@getPermissions');
			Route::get('Users/User/roles/all','Users\Controllers\UserController@getRolesAll');
		});
		// insert data post request
		Route::post('Users/User/roles/store','Users\Controllers\UserController@roleStore');
		Route::post('Users/User/roles/{roleId}','Users\Controllers\UserController@roleUpdate');
		Route::post('Users/User/permissions/update','Users\Controllers\UserController@setPermissions');
		Route::post('Users/User', 'Users\Controllers\UserController@store');
		
		// update data post request
		Route::post('Users/User/{userId}', 'Users\Controllers\UserController@update');
		
		//delete data delete request
		Route::delete('Users/User/roles/{roleId}','Users\Controllers\UserController@roleDestroy');
		Route::delete('Users/User/{userId}', 'Users\Controllers\UserController@Destroy');
    }
}


