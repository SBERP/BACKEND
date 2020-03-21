<?php
namespace ERP\Core\Clients\Properties;

/**
 * @author Kanaiya Rana<kanaiya.r@siliconbrain.in>
 */
trait ArchitectCommissionPropertyTrait
{
	/**
     * @var architectCommission
     */
    private $architectCommission;
	/**
	 * @param string $architectCommission
	 */
	public function setArchitectCommission($architectCommission)
	{
		$this->architectCommission = $architectCommission;
	}
	/**
	 * @return architectCommission
	 */
	public function getArchitectCommission()
	{
		return $this->architectCommission;
	}
}