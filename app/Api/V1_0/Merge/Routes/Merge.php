<?php
namespace ERP\Api\V1_0\Merge\Routes;

use ERP\Api\V1_0\Merge\Controllers\MergeController;
use ERP\Support\Interfaces\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use Illuminate\Support\Facades\Route;
/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class Merge implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
	 * description : this function is going to the controller page
     */
	
    public function register(RegistrarInterface $Registrar)
    {
		Route::post('Merge/Merge/products/{productId}', 'Merge\Controllers\MergeController@mergeProducts');
		// get jf_id
		
	}
}

