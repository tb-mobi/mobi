<?php
class Category extends Tym{
	protected $rawObj;
	public function __construct($obj){
		$this->logger=Logger::getLogger(__CLASS__);
		$this->rawObj=$obj;
	}
	public function __toString(){
		$obj=$this->rawObj;
		if(is_null($obj)){$this->logger->warn("response is null");return;}
		if(!isset($obj->return)){$this->logger->warn("no valid response");return;}
		if(!isset($obj->return->merchants)){$this->logger->warn("no merchants");return;}
		echo "<ul>";
		foreach($obj->return->merchants as $cat){
			echo "<li><img src='{$cat->image}' alt='{$cat->name}'/><a href='../merchant/?id={$cat->id}'><b>{$cat->name}</b> <pre>[{$cat->code}]</pre></a><li>";
		}
		echo "</ul>";
	}
};
?>