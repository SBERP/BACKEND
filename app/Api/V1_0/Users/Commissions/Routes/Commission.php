<?php
namespace ERP\Api\V1_0\Users\Commissions\Routes;

use ERP\Api\V1_0\Users\Commissions\Controllers\CommissionController;
use ERP\Support\Interfaces\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Log;

/**
 * @author Hiren Faldu <hiren.f@siliconbrain.in>
 */
class Commission implements RouteRegistrarInterface
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
			Route::get('Users/Commissions/Commission/item-wise/{commissionId?}', 'Users\Commissions\Controllers\CommissionController@getItemwiseData');
			/***************************Added after commission update for categorywise and brandWise
			****************************on Date: 26-02-2020*******************************************/
			// Route::get('Users/Commissions/Commission/{userId?}', 'Users\Commissions\Controllers\CommissionController@getData');
			Route::get('Users/Commissions/Commission/{userId?}', 'Users\Commissions\Controllers\CommissionController@getDataValue');
			/***************************Added after commission update for categorywise and brandWise
			****************************on Date: 26-02-2020*******************************************/;
			Route::get('Users/Commissions/Commission/report/{userId}', 'Users\Commissions\Controllers\CommissionController@getReportData');

		});
		// insert data post request
		Route::post('Users/Commissions/Commission/item-wise/{commissionId?}', 'Users\Commissions\Controllers\CommissionController@storeItemwise');
		/***************************Added after commission update for categorywise and brandWise
		****************************on Date: 26-02-2020*******************************************/
		// Route::post('Users/Commissions/Commission/{userId}', 'Users\Commissions\Controllers\CommissionController@storeOrUpdate');
		Route::post('Users/Commissions/Commission/{userId}', 'Users\Commissions\Controllers\CommissionController@storeOrUpdateValues');
		/***************************Added after commission update for categorywise and brandWise
		****************************on Date: 26-02-2020*******************************************/
		// update data post request
		// Route::post('Users/Commission/{userId}', 'Users\Commissions\Controllers\CommissionController@update');
		Route::delete('Users/Commissions/Commission/item-wise/{commissionId}', 'Users\Commissions\Controllers\CommissionController@destroyItemwise');
	}
}


