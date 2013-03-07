<?php

class Model_Organizations extends Othernet_Model_System_MySQLiAbstract
{
	protected $_name = 'organizations';
	protected $_schema = AUTH_MYSQL_DATABASE;
    protected $_db;

    public function init()
    {
        //load the authdb adapter
        $this->_db = Zend_Registry::getInstance('authdbAdapter')->authdbAdapter;
    }

    public function getLicenseType($organizationId)
	{
		$query = $this->select()
		->where('id = ?', $organizationId)
		->query();
			
		$results = $query->fetchAll();
		if ( count($results) )
		{
			return $results[0]['license_type'];
		}
		return 0;
		
	}
	
	public function getEnvironmentId($organizationId)
	{
		$query = $this->select()
		->where('id = ?', $organizationId)
		->query();
			
		$results = $query->fetchAll();
		if ( count($results) )
		{
			return $results[0]['environment_id'];
		}
		return 0;
	}
}