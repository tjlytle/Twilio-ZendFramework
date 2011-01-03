<?php
require_once 'Twilio/Resource/ResourceAbstract.php';
class Twilio_Resource_List_ListAbstract extends Twilio_Resource_ResourceAbstract implements Iterator, Countable
{
    //TODO: Auto-discover these
    protected $listName;
    protected $resourceName;
    protected $resourceClass;

    protected $position = 0;
    
    protected $pagesize;
    protected $page;
    
    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return new $this->resourceClass($this->getXml()->{$this->listName}->{$this->resourceName}[$this->position - (int) $this->getXml()->{$this->listName}['start']]);
    }

    //TODO: Only for sid based resources
    public function key() {
        //return $this->position;
        return $this->current()->sid;
    }

    public function next() {
        ++$this->position;
        if(!$this->valid()){
        	if(is_null($this->page) AND !empty($this->getXml()->{$this->listName}['nextpageuri'])){
                $response = $this->getTwilioClient()->get((string) $this->getXml()->{$this->listName}['nextpageuri']);
                $this->setXml($response->getBody());
        	}
        }
    }

    public function valid() {
        return isset($this->getXml()->{$this->listName}->{$this->resourceName}[$this->position - (int) $this->getXml()->{$this->listName}['start']]);
    }
    
    public function count()
    {
    	return (int) $this->getXml()->{$this->listName}['total'];
    }

    public function setXml($xml)
    {
    	parent::setXml($xml);
    	//makes manual pagination work
    	$this->position = (int) $this->getXml()->{$this->listName}['start'];
    }
    
    public function setPage($page, $pagesize = null)
    {
    	//unset current XML
    	$this->xml = null;
    	if(!is_null($pagesize)){
    		$this->pagesize = $pagesize;
    	}
    	
    	if(is_null($this->pagesize)){
    		throw new Twilio_Resource_Exception('Pagesize must be set');
    	}
    	
    	$this->page = $page;
    	
    	return $this;
    }
    
    public function getQuery()
    {
        $query = array();
        
        if(!empty($this->page)){
            $query['Page'] = (int) $this->page;
        }
        
        if(!empty($this->pagesize)){
            $query['PageSize'] = (int) $this->pagesize;
        }
        
        if(!empty($query)){
            foreach($query as $key => $value){
                $queryString[] = $key . '=' . $value;
            }
            
            return '?' . implode('&', $queryString);
        }
    }
}
