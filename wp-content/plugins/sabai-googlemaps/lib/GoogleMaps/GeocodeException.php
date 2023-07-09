<?php
class Sabai_Addon_Google_GeocodeException extends Sabai_RuntimeException
{
    protected $_query, $_status;
    
    public function __construct($query, $message = '', $status ='')
    {
        parent::__construct($message);
        $this->_query = $query;
        $this->_status = $status;
    }
    
    public function getGeocodeQuery()
    {
        return $this->_query;
    }
    
    public function getGeocodeStatus()
    {
        return $this->_status;
    }
}