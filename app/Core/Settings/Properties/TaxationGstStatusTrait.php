<?php
namespace ERP\Core\Settings\Properties;

/**
 * @author Kanaiya Rana<kanaiya.r@siliconbrain.in>
 */
trait TaxationGstStatusTrait
{
	/**
     * @var taxationGstStatus
     */
    private $taxationGstStatus;
	/**
	 * @param string $languageSettingType
	 */
	public function setTaxationGstStatus($taxationGstStatus)
	{
		$this->taxationGstStatus = $taxationGstStatus;
	}
	/**
	 * @return taxationGstStatus
	 */
	public function getTaxationGstStatus()
	{
		return $this->taxationGstStatus;
	}
}