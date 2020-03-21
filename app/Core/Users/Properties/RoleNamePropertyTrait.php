<?php
namespace ERP\Core\Users\Properties;

/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
trait RoleNamePropertyTrait
{
	/**
     * @var roleName
     */
    private $roleName;
	/**
	 * @param int $roleName
	 */
	public function setRoleName($roleName)
	{
		$this->roleName = $roleName;
	}
	/**
	 * @return roleName
	 */
	public function getRoleName()
	{
		return $this->roleName;
	}
}