<?php
namespace ERP\Core\Clients\Properties;

/**
 * @author Kanaiya Rana<kanaiya.r@siliconbrain.in>
 */
trait CarpenterIdPropertyTrait
{
	/**
     * @var carpenterId
     */
    private $carpenterId;
	/**
	 * @param string $carpenterId
	 */
	public function setCarpenterId($carpenterId)
	{
		$this->carpenterId = $carpenterId;
	}
	/**
	 * @return carpenterId
	 */
	public function getCarpenterId()
	{
		return $this->carpenterId;
	}
}