<?php
class MobiService extends Tym{
	protected $channelId=5;
	protected $options=array();
	protected $soapSrv=null;
	protected $soalCall=null;
	public function __construct(){
		$this->logger=Logger::getLogger(__CLASS__);
		$this->options= array( 
			'location'=>MOBI_SERIVCE_URL
			,'uri'=>MOBI_WSDL_LOCATION
			,'soap_version'=>SOAP_1_2
			,'exceptions'=>true
			,'trace'=>1
			,'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0)))
		);
		$this->soapSrv = new SoapClient(MOBI_WSDL_LOCATION,$this->options);
	}
	public function dorequest(){
		try{
			$req=parse_url($_SERVER["REQUEST_URI"]);
			$data=array();
			if(preg_match_all("/(.+?)\//im",$req["path"],$m)){
				$request=$this->implemented[$m[1][count($m[1])-1]];
				$this->soapCall=$request["mobi"]["request"];
				foreach($_REQUEST as $param=>$value){
					if(!in_array($param,$this->noparams)){
						$psoParamName=isset($request["mobi"]["params"][$param])?$request["mobi"]["params"][$param]:$param;
						$data[$psoParamName]=$value;
					}else{$data[$param]=$value;}
				}
				if(isset($request["mobi"]["needchannel"])&&$request["mobi"]["needchannel"])$data["_channel"]=$this->channel;
				$_call=$this->soapCall;
				$ret=$this->soapSrv->$_call($data);
				if(isset($request["mobi"]["response"]))$ret=new $request["mobi"]["response"]($ret);
				$this->logger->debug("Request: ".$this->soapSrv->__getLastRequest());
				$this->logger->debug("Response: ".$this->soapSrv->__getLastResponse());
				return $ret;
			}
		} catch (Exception $e) {  
			echo $e->getMessage(); 
		}
	}
	/*public function __toString(){
		return "<h2>Request</h2><pre>".htmlspecialchars($this->soapSrv->__getLastRequest())."</pre>"
			."<h2>Response</h2><pre>".htmlspecialchars($this->soapSrv->__getLastResponse())."</pre>";
	}*/
	protected $noparams=array("url","session","request");
	protected $implemented=array(
		"test"=>array(
			"mobi"=>array(
				"request"=>"getMerchant"
				,"params"=>array("id"=>"_id")
				,"response"=>"MerchantForm"
			)
		)
		,"categories"=>array(
			"mobi"=>array(
				"request"=>"getCategoryList"
				,"params"=>array()
				,"response"=>"Categories"
			)
		)
		,"merchant"=>array(
			"mobi"=>array(
				"request"=>"getMerchant"
				,"params"=>array("id"=>"_id")
				,"response"=>"MerchantForm"
			)
		)
		,"merchants"=>array(
			"mobi"=>array(
				"request"=>"getMerchantList"
				,"params"=>array("id"=>"_categoryId")
				,"response"=>"Category"
			)
		)
		,"auth"=>array(
			"mobi"=>array(
				"request"=>"authClient"
				,"params"=>array("login"=>"_login","user"=>"_login","pass"=>"_password")
				,"needchannel"=>true
			)
		)
	);
};
?>