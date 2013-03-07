<?php
class Model_OpClSubmission extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'opCl_submission';
    protected $_schema = APP_MYSQL_DATABASE;

    private $service = 'opCl';
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

    public function insert(array $data)
    {
        if ( !isset( $data['opClDetailsOpClId'] ) )
        {
            /* Generate opClDetailsOpClId */
            $seqService = new Service_Seq();
            $this->lastInsertId = $seqService->getValue( $this->service );

            $data['opClDetailsOpClId'] = $this->lastInsertId;
        }

        /* Override these values */
        $data['createdBy'] = $this->userId;
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        parent::insert($data);
    }

    public function update(array $data, $where)
    {
        /* Override these values */
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }

    public function lastInsertId()
    {
        return $this->lastInsertId;
    }
}