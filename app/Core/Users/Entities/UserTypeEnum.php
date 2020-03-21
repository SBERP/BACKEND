<?php
namespace ERP\Core\Users\Entities;
/**
 *
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class UserTypeEnum 
{
    public function enumArrays()
	{
		$enumArray = array();
		$enumArray['adminType'] = "admin";
		$enumArray['stffType'] = "staff";
		$enumArray['salesmanType'] = "salesman";
		$enumArray['architectType'] = "architect";
		$enumArray['carpenterType'] = "carpenter";
		return $enumArray;
	}
}