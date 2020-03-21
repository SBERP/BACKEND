<?php
namespace ERP\Core\Accounting\Bills\Properties;

/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
trait ArchitectCommissionPropertyTrait
{
	/**
     * @var architectCommission
     */
    private $architectCommission;
	/**
	 * @param string $ArchitectCommission
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