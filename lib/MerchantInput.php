<?php
class MerchantInput{
	protected $rawObj;
	protected $inputs=array();
	protected $params=array(
		"required" => false
		,"id"=>""
        ,"type"=>""
        ,"value"=>""
        ,"example"=>""
        ,"hint"=>""
        ,"inputtedValue"=>""
        ,"options"=>""
        ,"required"=>""
        ,"rules"=>array()
        ,"textValue"=>""
        ,"title"=>""
	);
	protected function parse(){
		$obj=$this->rawObj;
		if(is_null($obj))return;
		foreach($this->params as $k=>$v){
			$this->params[$k]=isset($obj->$k)?$obj->$k:$this->params[$k];
		}
		switch($this->params["type"]){
			case "1":
			case "2":
			case "3":
			default:$this->params["type"]="text";break;
		}
		
	}
	public function __construct($obj,$required=false){
		$this->rawObj=$obj;
		$this->params["required"]=($required)?"true":"false";
		$this->parse();
	}
	public function __toString(){
		return "<label for='{$this->params["id"]}'>{$this->params["title"]}</label>"
			."<input type='{$this->params["type"]}' name='{$this->params["id"]}' id='{$this->params["id"]}' "
			."data-pattern='".(isset($this->params["rules"]->validateStr)?$this->params["rules"]->validateStr:".*")."' "
			."data-pattern-hint='".(isset($this->params["rules"]->message)?$this->params["rules"]->message:".*")."' "
			.(isset($this->params["rules"]->length)?"maxlenth='".$this->params["rules"]->length."' ":"")
			."hint='{$this->params["hint"]}' data-required='{$this->params["required"]}' placeholder='{$this->params["example"]}' value='{$this->params["value"]}'/>";
	}
};
?>