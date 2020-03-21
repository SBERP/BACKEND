<?php
namespace ERP\Core\Users\Properties;

/**
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
trait RoleIdPropertyTrait
{
	/**
     * @var roleId
     */
    private $roleId;
	/**
	 * @param int $roleId
	 */
	public function setRoleId($roleId)
	{
		$this->roleId = $roleId;
	}
	/**
	 * @return roleId
	 */
	public function getRoleId()
	{
		return $this->roleId;
	}
}