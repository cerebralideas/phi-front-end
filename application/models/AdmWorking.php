<?php
class Model_AdmWorking extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'adm_working';
    protected $_schema = APP_MYSQL_DATABASE;

    private $service = 'adm';
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
        if ( !isset( $data['admDetailsAdmId'] ) )
        {
            /* Generate admDetailsAdmId */
            $seqService = new Service_Seq();
            $this->lastInsertId = $seqService->getValue( $this->service );

            $data['admDetailsAdmId'] = $this->lastInsertId;
        }

        /* Override these values */
        $data['createdBy'] = $this->userId;
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        if ( !isset($data['ptInfoAdmNum']) )
        {
            // Calculate number of working copy adms for this patient
            $whereWorking =  $this->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);
            $rowsWorking = $this->fetchAll( $whereWorking );

            $admIds = array();
            foreach ( $rowsWorking as $rowWorking )
            {
                $admIds[] = $rowWorking['admDetailsAdmId'];
            }

            $admIdList = implode(',', $admIds);

            // Calculate the number of additional master copy adms for this patient
            $admWorkingModel = new Model_AdmWorking();
            if ( count($rowsWorking) )
                $where = $admWorkingModel->getAdapter()->quoteInto('ptInfoUniqueId = ? AND admDetailsAdmId NOT IN (' . $admIdList . ')', $data['ptInfoUniqueId']);
            else
                $where = $admWorkingModel->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);

            $rows = $admWorkingModel->fetchRow( $where );

            $data['ptInfoAdmNum'] = count($rowsWorking) + count($rows) + 1;
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