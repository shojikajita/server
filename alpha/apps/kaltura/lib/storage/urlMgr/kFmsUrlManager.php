<?php
/**
 * @package Core
 * @subpackage storage.FMS
 */
class kFmsUrlManager extends kUrlManager
{
	/**
	 * @param FileSync $fileSync
	 * @return string
	 */
	protected function doGetFileSyncUrl(FileSync $fileSync)
	{
		$fileSync = kFileSyncUtils::resolve($fileSync);
		
		$url = parent::doGetFileSyncUrl($fileSync);
		$url = trim($url, '/');
		
		switch ($this->protocol)
		{
		case PlaybackProtocol::APPLE_HTTP:
			$pattern = isset($this->params["hls_pattern"]) ? $this->params["hls_pattern"] : '/hls-vod/{url}.m3u8';
			break;
		
		case PlaybackProtocol::HDS:
			$pattern = isset($this->params["hds_pattern"]) ? $this->params["hds_pattern"] : '/hds-vod/{url}.f4m';
			break;
			
		default:
			$pattern = isset($this->params["default_pattern"]) ? $this->params["default_pattern"] : '{url}'; 
			break;
		}
		
		return str_replace('{url}', $url, $pattern);
	}
	
	//load tokenizer according to the url manager params.tokenizer configuration should look like:
	//{"key":"tokenizers_<protocol>_class","value":"<tokenizer class name>"},
	//{"key":"tokenizers_<protocol>_param0","value":"<param0 value>"},
	//{"key":"tokenizers_<protocol>_param1","value":"<param1 value>"}
	// .
	// .
	// .
	public function getTokenizer(){
		KalturaLog::debug(print_r($this->params,true));
		if(key_exists('tokenizers_'.$this->protocol.'_class', $this->params))
		{
			$className = $this->params['tokenizers_'.$this->protocol.'_class'];
			$params = array();
			$i=0;
			while(true){
				if(!key_exists('tokenizers_'.$this->protocol.'_param'.$i, $this->params))
					break;
				$params[] = $this->params['tokenizers_'.$this->protocol.'_param'.$i];
				$i++;
			}
			$reflector = new ReflectionClass($className);
			KalturaLog::debug(print_r($reflector,true));
			KalturaLog::debug(print_r($params,true));
			return $reflector->newInstanceArgs($params);
		}
		return null;
	} 
	
	
	public function getManifestUrl(array $flavors)
	{
		$url = $this->generateCsmilUrl($flavors);
		
		if ($this->protocol == PlaybackProtocol::APPLE_HTTP)
		{
			
			$protocolFolder = '/i';
			$url = $url . '/master.m3u8';
			$urlPrefix = $this->params["hd_secure_ios"];
		}
		else
		{
			if (!isset($this->params["hd_secure_hds"]))
				return null;
				
			$protocolFolder = '/z';
			$url = $url . '/manifest.f4m';		
			$urlPrefix = $this->params["hd_secure_hds"];
		}

		// move any folders on the url prefix to the url part, so that the protocol folder will always be first
		$urlPrefixWithProtocol = $urlPrefix;
		if (strpos($urlPrefix, '://') === false)
			$urlPrefixWithProtocol = 'http://' . $urlPrefix;
		
		$urlPrefixPath = parse_url($urlPrefixWithProtocol, PHP_URL_PATH);
		if ($urlPrefixPath && substr($urlPrefix, -strlen($urlPrefixPath)) == $urlPrefixPath)
		{
			$urlPrefix = substr($urlPrefix, 0, -strlen($urlPrefixPath));
			$url = rtrim($urlPrefixPath, '/') . '/' . ltrim($url, '/');
		}
		
		return array('url' => $protocolFolder . $url, 'urlPrefix' => $urlPrefix);		
	}
}
