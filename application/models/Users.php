<?php
class Model_Users extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'users';
    protected $_schema = AUTH_MYSQL_DATABASE;
    protected $_db;

    public function init()
    {
        //load the authdb adapter
        $this->_db = Zend_Registry::getInstance('authdbAdapter')->authdbAdapter;
    }

	public function validateCredentials($username, $password)
	{
		$query = $this->select()
			->where('ehr_username = ?', $username)
			->where('ehr_password = ?', $password)
			->query();
			
			$results = $query->fetchAll();
			if ( count($results) )
			{
				return true;
			}
			return false;
	}

    public function validateEsignature($userId, $eSignature)
    {
        $query = $this->select()
            ->where('id = ?', $userId)
            ->where('ehr_esignature = ?', $eSignature)
            ->query();

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return true;
        }
        return false;
    }
	
	public function getByCredentials($username, $password)
	{
		$query = $this->select()
			->where('ehr_username = ?', $username)
			->where('ehr_password = ?', $password)
			->query();
			
			$results = $query->fetchAll();
			if ( count($results) )
			{
				return $results[0];
			}
			return null;
	}
	
	public function getByUserId($userId)
	{
		$query = $this->select()
		->where('id = ?', $userId)
		->query();
			
		$results = $query->fetchAll();
		if ( count($results) )
		{
			return $results[0];
		}
		return null;
		
	}
	
	public function updateLastLoginDate($userId)
	{
		$this->update(
			array(
				'last_login_date' => date('Y-m-d H:i:s'),
			),
			'id='.$this->quote($userId)
		);
		
	}
}