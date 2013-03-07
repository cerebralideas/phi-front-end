<?php
class Model_Apt extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'apt';
    protected $_schema = APP_MYSQL_DATABASE;

    private $service = 'apt';
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
        /* Generate aptDetailsAptId */
        $seqService = new Service_Seq();
        $this->lastInsertId = $seqService->getValue( $this->service );

        /* Override these values */
        $data['aptDetailsAptId'] = $this->lastInsertId;
        $data['createdBy'] = $this->userId;
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        if ( !isset($data['ptInfoAptNum']) )
        {
            // Calculate number of working copy apts for this patient
            $aptWorkingModel = new Model_AptWorking();
            $whereWorking =  $aptWorkingModel->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);
            $rowsWorking = $aptWorkingModel->fetchAll( $whereWorking );

            $aptIds = array();
            foreach ( $rowsWorking as $rowWorking )
            {
                $aptIds[] = $rowWorking['aptDetailsAptId'];
            }

            $aptIdList = implode(',', $aptIds);

            // Calculate the number of additional master copy apts for this patient
            if ( count($rowsWorking) )
                $where = $this->getAdapter()->quoteInto('ptInfoUniqueId = ? AND aptDetailsAptId NOT IN (' . $aptIdList . ')', $data['ptInfoUniqueId']);
            else
                $where = $this->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);

            $rows = $this->fetchRow( $where );



            $data['ptInfoAptNum'] = count($rowsWorking) + count($rows) + 1;
        }

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