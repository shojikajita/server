<?php
/**
 * @package api
 * @subpackage objects
 */
class KalturaOrCondition extends KalturaCondition
{
	/**
	 * The type of the access control condition
	 * 
	 * @var KalturaConditionArray
	 */
	public $conditions;

	
	private static $mapBetweenObjects = array
	(
		'conditions',
	);
	
	public function getMapBetweenObjects()
	{
		return array_merge(parent::getMapBetweenObjects(), self::$mapBetweenObjects);
	}
}
