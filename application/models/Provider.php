<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/15/12
 * Time: 4:54 PM
 * To change this template use File | Settings | File Templates.
 */
class Model_Provider extends Othernet_Model_System_MySQLiAbstract
{
    protected $_name = 'users';
    protected $_schema = AUTH_MYSQL_DATABASE;
    protected $_db;

    private $auth;
    private $storage;
    private $userId;
    private $organizationId;

    public function init()
    {
        //load the authdb adapter
        $this->_db = Zend_Registry::getInstance('authdbAdapter')->authdbAdapter;

        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
        $this->organizationId = $this->storage->read()->organization_id;
    }

}
