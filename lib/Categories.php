<?php
class Categories extends Tym{
	protected $rawObj;
	protected $tostr="";
	public function __construct($obj){
		$this->logger=Logger::getLogger(__CLASS__);
		$this->rawObj=$obj;
		//$this->parse();
		$this->logger->debug($this->__toString());
	}
	public function __toString(){
		if(strlen($this->tostr)) return $this->tostr;
		$obj=$this->rawObj;
		if(is_null($obj)){$this->logger->warn("response is null");return;}
		if(!isset($obj->return)){$this->logger->warn("no valid response");return;}
		if(!isset($obj->return->categories)){$this->logger->warn("no catagories");return;}
		$this->tostr="<ul>";
		foreach($obj->return->categories as $cat){
			$this->tostr.="<li><img src='{$cat->image}' alt='{$cat->name}'/><a href='../merchants/?id={$cat->id}'><b>{$cat->name}</b> <pre>[{$cat->code}]</pre></a><li>";
		}
		$this->tostr.="</ul>";
		return $this->tostr;
	}
};
?>