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
	
	/**
	 * Init object type
	 */
	public function __construct() 
	{
		$this->type = ConditionType::OR_CONDITION;
	}
	
	/* (non-PHPdoc)
	 * @see KalturaObject::toObject()
	 */
	public function toObject($dbObject = null, $skip = array())
	{
		if(!$dbObject)
			$dbObject = new kOrCondition();
			
		return parent::toObject($dbObject, $skip);
	}
}
