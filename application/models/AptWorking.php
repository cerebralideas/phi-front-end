<?php
class Model_AptWorking extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'apt_working';
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
        if ( !isset( $data['aptDetailsAptId'] ) )
        {
            /* Generate aptDetailsAptId */
            $seqService = new Service_Seq();
            $this->lastInsertId = $seqService->getValue( $this->service );

            $data['aptDetailsAptId'] = $this->lastInsertId;
        }

        /* Override these values */
        $data['createdBy'] = $this->userId;
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        if ( !isset($data['ptInfoAptNum']) )
        {
            // Calculate number of working copy apts for this patient
            $whereWorking =  $this->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);
            $rowsWorking = $this->fetchAll( $whereWorking );

            $aptIds = array();
            foreach ( $rowsWorking as $rowWorking )
            {
                $aptIds[] = $rowWorking['aptDetailsAptId'];
            }

            $aptIdList = implode(',', $aptIds);

            // Calculate the number of additional master copy apts for this patient
            $aptModel = new Model_Apt();
            if ( count($rowsWorking) )
                $where = $aptModel->getAdapter()->quoteInto('ptInfoUniqueId = ? AND aptDetailsAptId NOT IN (' . $aptIdList . ')', $data['ptInfoUniqueId']);
            else
                $where = $aptModel->getAdapter()->quoteInto('ptInfoUniqueId = ?', $data['ptInfoUniqueId']);

            $rows = $aptModel->fetchRow( $where );



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