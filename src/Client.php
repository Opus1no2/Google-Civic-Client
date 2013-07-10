<?php
/**
 *
 * Minimal client for Goolge Civic REST API
 *
 * @Author: Travis Tillotson <tillotson.travis@gmail.com>
 */
class GoolgeCivic
{
    /**
     * @var string $_agent | default user agent
     */
    private $_agent = 'Goolge-Civic-API-Client';
    /**
     * @var int $_version  | API Version
     */
    private $_version = 1;
    /**
     * @var array $_option
     */
    private $_option;
    /**
     * @var array $_addr
     */
    private $_addr;
    
    const BASE = 'https://www.googleapis.com';
    const PATH = '/civicinfo/';
    
    /**
     *
     * Require API key at instantiation
     *
     * @param string $key
     *
     * @return void
     */
    public function __construct($key)
    {
        $this->_option['key'] = $key;
    }
    
    /**
     *
     * Get all available elections
     *
     * @return string
     */
    public function getElections()
    {
        $this->_setUrl('elections');
        return $this->_request();
    }
    
    /**
     *
     * Retrieve relevent voter information based on address
     * $electionID can be retrieved from getElections method
     *
     * @param int  $electionId
     * @param bool $official
     *
     * @return string
     */
    public function getVoterInfo($electionId, $official = false)
    {
        if ($official === true) {
            $this->_option['officialOnly'] = 'true';
        }
        $this->_setUrl("voterinfo/{$electionId}/lookup");
        return $this->_request('POST');
    }
    
    /**
     *
     * Create and execute HTTP request
     *
     * @param string $method
     *
     * @return string
     */
    private function _request($method = 'GET')
    {
        $ch = curl_init();
        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_getAddr());
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        }
        curl_setopt($ch, CURLOPT_URL, $this->_getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_agent); 
        $out = curl_exec($ch);
        curl_close($ch);
        
        return $out;
    }
    
    /**
     *
     * Set URL for HTTP request
     *
     * @param string $path
     *
     * @return void
     */
    private function _setUrl($path)
    {
        $url  = self::BASE . self::PATH;
        $url .= "us_v{$this->_version}/{$path}";
        $url .= '?'.http_build_query($this->_option);
        
        $this->_url = self::valid($url);
    }
    
    /**
     *
     * Return URL for HTTP request
     *
     * @return string
     */
    private function _getUrl()
    {
        return $this->_url;
    }
    
    /**
     *
     * Set address for voterinfo method
     *
     * @param string $addr
     *
     * @return void
     */
    public function setAddr($addr)
    {
        $this->_addr['address'] = $addr;
        return $this;
    }
    
    /**
     *
     * Get user Address for voterinfo request
     *
     * @return string
     */
    private function _getAddr()
    {
        return json_encode($this->_addr);
    }
    
    /**
     *
     * Used if version is changed
     *
     * @param string $version
     *
     * @return void
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }
    
    /**
     *
     * Allow user to set their own user agent
     *
     * @param string $agent
     *
     * @return void
     */
    public function setUserAgent($agent)
    {
        $this->_agent = $agent;
        return $this;
    }
    
    /**
     *
     * Used to validate URL before request
     *
     * @param string $url
     *
     * @return string
     *
     * @throws RunTimeException
     */
    public static function valid($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        throw new RunTimeException(sprintf('Invalid URL: %s', $url));
    }
}