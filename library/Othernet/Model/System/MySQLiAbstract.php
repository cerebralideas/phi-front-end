<?php
abstract class Othernet_Model_System_MySQLiAbstract extends Zend_Db_Table_Abstract
{	
	public function select($withFromPart = parent::SELECT_WITHOUT_FROM_PART)
	{
		$this->reconnect();
		return parent::select($withFromPart);
	}
	
	public function insert(array $data)
	{	
		$this->reconnect();
		return parent::insert($data);
	}
	
	public function update(array $data, $where)
	{
		$this->reconnect();
		return parent::update($data, $where);
	}
	
	public function delete($where)
	{
		$this->reconnect();
		return parent::delete($where);
	}
	
	public function quote($data)
	{
		return $this->getAdapter()->quote($data);
	}
	
	public function reconnect()
	{
		if($this->getAdapter()->reconnect())
			return true;

		/* if we get here, then we are throwing an exception because the connection can not be refreshed */
		throw new Zend_Db_Exception('Unable to reconnect via ping - Original Adapter: '.PHP_EOL.print_r($this->getAdapter()->getConfig(), true));
	}

    public function __toString()
    {
        $string = '';

        if(isset($this->_name))
            $string .= $this->_name;

        if(isset($this->_schema))
            $string .= $this->_schema;

        return $string;
    }
}