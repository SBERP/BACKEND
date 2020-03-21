<?php
namespace ERP\Core\Accounting\Bills\Properties;

/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
trait CarpenterCommissionPropertyTrait
{
	/**
     * @var carpenterCommission
     */
    private $carpenterCommission;
	/**
	 * @param string $carpenterCommission
	 */
	public function setCarpenterCommission($carpenterCommission)
	{
		$this->carpenterCommission = $carpenterCommission;
	}
	/**
	 * @return CarpenterCommission
	 */
	public function getCarpenterCommission()
	{
		return $this->carpenterCommission;
	}
}