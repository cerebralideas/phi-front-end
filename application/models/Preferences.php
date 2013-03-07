<?php
class Model_Preferences extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'preferences';
    protected $_schema = APP_MYSQL_DATABASE;

    private $auth;
    private $storage;
    private $userId;

    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
    }

}