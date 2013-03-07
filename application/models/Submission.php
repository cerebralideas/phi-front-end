<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/21/12
 * Time: 9:18 AM
 * To change this template use File | Settings | File Templates.
 */
class Model_Submission extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'submission';
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

    public function insert(array $data)
    {
        // add created/modified timestamp & userId
        if (empty($data['createdBy']))
            $data['createdBy'] = $this->userId;

        if (empty($data['createdDate']))
            $data['createdDate'] = date('Y-m-d H:i:s');

        if (empty($data['modifiedBy']))
            $data['modifiedBy'] = $this->userId;

        if (empty($data['modifiedDate']))
            $data['modifiedDate'] = date('Y-m-d H:i:s');

        parent::insert($data);
    }
}