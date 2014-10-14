<?php
class MerchantForm extends Tym{
	protected $parseString="success";
	protected $rawObj;
	protected $inputs=array();
	protected $params=array(
		"maxSum" => 15000
		,"minSum" => 100
		,"code" => "megafon-moscow"
		,"id" => "1002"
		,"image" => "mob_megafon_moscow.gif"
		,"name" => "Мегафон Москва"
		,"title" => "Мегафон Москва"
	);
	protected function parse(){
		$obj=$this->rawObj;
		if(is_null($obj)){$this->logger->warn("response is null");return;}
		if(!isset($obj->return)){$this->logger->warn("no return tag");return;}
		if(!isset($obj->return->merchantInfo)){$this->logger->warn("no merchantInfo tag");return;}
		if(!isset($obj->return->merchantInfo->template)){$this->logger->warn("no template tag");return;}
		foreach($this->params as $k=>$v){
			$this->params[$k]=isset($obj->return->merchantInfo->$k)?$obj->return->merchantInfo->$k:$this->params[$k];
		}
		$this->params["title"]=isset($obj->return->merchantInfo->template->title)?$obj->return->merchantInfo->template->title:$this->params["title"];
		if(is_array($obj->return->merchantInfo->template->groups))foreach($obj->return->merchantInfo->template->groups as $input) $this->makeInput($input);
		else if(is_object($obj->return->merchantInfo->template->groups))$this->makeInput($obj->return->merchantInfo->template->groups);
		else $this->logger->warn("not object & not array");
		$this->logger->debug($this->__toString());
	}
	protected function makeInput($input){
		if(is_array($input->inputs)){
			foreach($input->inputs as $inpt){
				array_push($this->inputs,new MerchantInput($inpt,($input->id==="basicRequisite")));
			}
		}else array_push($this->inputs,new MerchantInput($input,($input->id==="basicRequisite")));
	}
	public function __construct($obj){
		$this->logger=Logger::getLogger(__CLASS__);
		$this->rawObj=$obj;
		$this->parse();
	}
	public function __toString(){
		$str="<form>";
		foreach($this->inputs as $i){
			$str.=$i->__toString();
		}
		return $str."</form>";
	}
};
?>