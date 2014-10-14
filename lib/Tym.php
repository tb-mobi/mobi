<?php 

class Tym{
	protected $logger;
	protected function info($str){
		$this->logger->info($str);
	}
	protected function debug($str){
		$this->logger->debug($str);
	}
	protected function warn($str){
		$this->logger->warn($str);
	}
	protected function error($str,$ex){
		$this->logger->error($str,$ex);
	}
};
?>