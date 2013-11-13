<?php
/**
 * @package Core
 * @subpackage model.data
 */
class kOrCondition extends kCondition
{
	/*
	 * @var array
	 */
	protected $conditions;
	
	/**
	 * @param array $conditions
	 */
	public function setConditions (array $conditions)
	{
		$this->conditions = $conditions;
	}
	
	
	/**
	 * @param kScope $scope
	 * @return bool
	 */
	protected function internalFulfilled(kScope $scope)
	{
		foreach ($this->conditions as $condition)
		{
			if (!($condition instanceof kCondition ))
				continue;
			/* @var $condition kCondition */
			if ($condition->fulfilled($scope))
			{
				KalturaLog::info('One of the conditions has been fulfilled. OR condition has been fulfilled successfully');
				return true;
			}
		}
		
		KalturaLog::info('None of the conditions have been fulfilled. OR condition returns FALSE');
		return false;
	}
}
