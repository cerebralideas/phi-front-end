<?php
class Othernet_Model_System_Mysqli extends Zend_Db_Adapter_Mysqli
{
	private $reconnectAttempts = 5;
	private $totalSleepTime = 0;
	private $_lastReconnect = 0;

	public function query($sql, $bind = array())
	{
		$this->reconnect();
		return parent::query($sql, $bind);
	}
	
	/* overloaded call to the base function of Zend_Db_Adapter_Mysqli */
	public function select()
	{
		$this->reconnect();
		return parent::select();
	}
	
	/* overloaded call to the base function of Zend_Db_Adapter_Mysqli */
	public function update($table, array $bind, $where = '')
	{
		$this->reconnect();
		return parent::update($table, $bind, $where);
	}
	
	/* overloaded call to the base function of Zend_Db_Adapter_Mysqli */
	public function delete($table, $where = '')
	{
		$this->reconnect();
		return parent::delete($table, $where);
	}
	
	/* overloaded call to the base function of Zend_Db_Adapter_Mysqli */
	public function insert($table, array $bind)
	{
		$this->reconnect();
		return parent::insert($table, $bind);
	}

	public function quote($data)
	{	
		/* this is 200% faster for strings and numbers than the parent */
		if(is_numeric($data) && !strcasecmp(strval(intval($data)), $data))
			return $data;
			
		/* if our data is a string or !$data referes to a blank sting */
		else if(is_string($data) || !$data)
			return "'".$this->getConnection()->escape_string($data)."'";
		
		/* use the inefficient parent for anything that isnt a number or a string */
		else 
			return parent::quote($data);
	}
	
	/* replace all ? with quotes from an array of vals */
	public function quoteIntoArray($text = '', array $values)
	{
		/* if we didnt get any values, then just return the text that was sent in */
		if(!$text || !count($values))
			return $text;
			
		$textArray = explode("?", $text);
		
		if(count($textArray) - 1 > count($values))
			throw new Zend_Exception("The number of value must be equal to or greater than the number of place holders in your query\n".$text."\n".print_r($values, true));
			
		/* reindex to a 0 base index */
		$values = array_values($values);
		for($i = 0; $i < count($textArray) - 1; $i++)
			$textArray[$i] .= $this->quote($values[$i]);
		
		$text = implode("", $textArray);
		
		return $text;
	}
	
	public function reconnect()
	{	
		/* make sure we have atleast 30 seconds between reconnects */
		if(microtime(true) - $this->_lastReconnect < 30)
			return true;
			
		$this->_lastReconnect = microtime(true);
		
		/* use the current connection first, if that works then return */
		if($this->_ping($this->getConnection()))
			return true;
		
		if(function_exists('cli_print')){cli_print('Reconnect (initial ping()) on '
			.$this->_config['host'].' db ' .$this->_config['dbname'].' failed.  Trying a new connection.');}
			
		/* otherwise lets try ot make a new connection and then try again */
		$this->_connection = false; 
		$this->_connect();
		
		if(function_exists('cli_print')){cli_print('New connection created for '
			.$this->_config['host'].' db '.$this->_config['dbname']);}
		
		/* use the current connection first, if that works then return */
		if($this->_ping($this->getConnection()))
			return true;
		
		if(function_exists('cli_print')){cli_print('Reconnect on '.$this->_config['host'].' db '
			.$this->_config['dbname'].' failed for new connection.  Throwing Exception.');}
			
		/* if we get here, then we are throwing an exception because the connection can not be refreshed */
		throw new Zend_Db_Adapter_Mysqli_Exception(
			'Unable to reconnect via ping'.PHP_EOL.'Original Adapter: '.PHP_EOL.print_r($MySQLiAdapter->getConfig(), true)
		);
		
	}
	
	private function _ping(mysqli $MySQLiConnectionObject)
	{
		for($i = 0; $i < $this->reconnectAttempts; $i++)
		{
			if($MySQLiConnectionObject->ping())
			{
				return true;
			}
			
			/* we add a sleep time so the server doesnt reject us because of a barage of reconnect attempts */
			$sleepInterval = mt_rand(5000, 200000); 
			usleep($sleepInterval);
			
			if(function_exists('cli_print')){$this->totalSleepTime+=$sleepInterval;cli_print('Reconnect '.($i+1).' failed on the '
				.$this->_config['host'].' db '.$this->_config['dbname'].' connection. This sleep interval was '
				.($sleepInterval / 1000).' MS and a total of '.($this->totalSleepTime / 1000).' MS');}
		}
		return false;
	}
}