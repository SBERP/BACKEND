<?php
namespace ERP\Core\Clients\Properties;

/**
 * @author Kanaiya Rana<kanaiya.r@siliconbrain.in>
 */
trait ArchitectIdPropertyTrait
{
	/**
     * @var architectId
     */
    private $architectId;
	/**
	 * @param string $architectId
	 */
	public function setArchitectId($architectId)
	{
		$this->architectId = $architectId;
	}
	/**
	 * @return architectId
	 */
	public function getArchitectId()
	{
		return $this->architectId;
	}
}