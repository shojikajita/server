<?php
/**
* @package deployment
* 
* Add permissions to change partnerId*/

$script = realpath(dirname(__FILE__) . '/../../../../') . '/alpha/scripts/utils/permissions/addPermissionsAndItems.php';
$config = realpath(dirname(__FILE__)) . '/../../../permissions/object.KalturaKalturaAssetParams.ini';
passthru("php $script $config");

