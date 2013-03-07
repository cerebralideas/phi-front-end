<?php
class Model_AccItem extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'accItem';
    protected $_schema = APP_MYSQL_DATABASE;

    private $service = 'accItem';
    private $auth;
    private $storage;
    private $userId;
    private $lastInsertId;

    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
    }
}
