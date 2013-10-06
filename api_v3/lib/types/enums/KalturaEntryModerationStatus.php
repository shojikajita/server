<?php
/**
 * @package api
 * @subpackage enum
 */
class KalturaEntryModerationStatus extends KalturaEnum
{
	const PENDING_MODERATION = 1; 
	const APPROVED = 2;   
	const REJECTED = 3;   
	const FLAGGED_FOR_REVIEW = 5;
	const AUTO_APPROVED = 6;
	
	public static function getDescriptions()
	{
		return array(
			self::PENDING_MODERATION => 'Moderation status given to entries uploaded to a partner account configured to automatically moderate incoming content',
			self::APPROVED => 'Moderation status given to an entry that is approved for display',
			self::REJECTED => 'Moderation status given to an entry that is rejected because of inappropriate content',
			self::FLAGGED_FOR_REVIEW => 'Moderation status signifying that an end user flagged the entry for inappropriate content',
			self::AUTO_APPROVED => 'Moderation status signifying that the entry was automatically approved for display',
		);
	}
}