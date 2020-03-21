<?php
namespace ERP\Core\Clients\Properties;

/**
 * @author Kanaiya Rana<kanaiya.r@siliconbrain.in>
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
	 * @return carpenterCommission
	 */
	public function getCarpenterCommission()
	{
		return $this->carpenterCommission;
	}
}