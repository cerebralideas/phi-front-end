<?php
class Model_OpCl extends Othernet_Model_System_MySQLiAbstract
{

    protected $_name = 'opCl';
    protected $_schema = APP_MYSQL_DATABASE;

    private $service = 'opCl';
    private $auth;
    private $storage;
    private $userId;
    private $lastInsertId;
    private $masterData;

    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;

        $preferencesService = new Service_Preferences();
        $this->masterData = $preferencesService->getMasterDataFlag();
    }

    public function insert(array $data)
    {
        /* Generate opClDetailsOpClId */
        $seqService = new Service_Seq();
        $this->lastInsertId = $seqService->getValue( $this->service );

        /* Override these values */
        $data['opClDetailsOpClId'] = $this->lastInsertId;
        $data['createdBy'] = $this->userId;
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['modifiedBy'] = $this->userId;
        $data['modifiedDate'] = date('Y-m-d H:i:s');

        /* Calculate the number of existing claims for this patient */

        // Figure out patientId
        $opClDetailsOpSbId = $data['opClDetailsOpSbId'];
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $opSbModel = new Model_OpSb();
            $opSbWhere = $opSbModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $opClDetailsOpSbId);
            $opSb = $opSbModel->fetchRow( $opSbWhere );
            $opSbDetailsAptId = $opSb['opSbDetailsAptId'];

            $aptModel = new Model_Apt();
            $aptWhere = $aptModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $opSbDetailsAptId);
            $apt = $aptModel->fetchRow( $aptWhere );

            $patientId = $apt['ptInfoUniqueId'];
        }
        else
        {
            /* User is in 'Student' mode */
            $opSbWorkingModel = new Model_OpSbWorking();
            $opSbWorkingWhere = $opSbWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $opClDetailsOpSbId);
            $opSbWorkingWhere .= $opSbWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId);
            $opSb = $opSbWorkingModel->fetchRow( $opSbWorkingWhere );

            $opSbDetailsAptId = $opSb['opSbDetailsAptId'];

            if ( !$opSbDetailsAptId )
            {
                $opSbModel = new Model_OpSb();
                $opSbWhere = $opSbModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $opClDetailsOpSbId);
                $opSb = $opSbModel->fetchRow( $opSbWhere );
                $opSbDetailsAptId = $opSb['opSbDetailsAptId'];
            }


            $aptWorkingModel = new Model_AptWorking();
            $aptWorkingWhere = $aptWorkingModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $opSbDetailsAptId);
            $aptWorkingWhere .= $aptWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId);
            $apt = $aptWorkingModel->fetchRow( $aptWorkingWhere );

            $patientId = $apt['ptInfoUniqueId'];

            if ( !$patientId )
            {
                $aptModel = new Model_Apt();
                $aptWhere = $aptModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $opSbDetailsAptId);
                $apt = $aptModel->fetchRow( $aptWhere );

                $patientId = $apt['ptInfoUniqueId'];
            }
        }

        $opClService = new Service_OpCl();
        $opClJson = $opClService->getByPtId( $patientId );
        $opClArray = Zend_Json_Decoder::decode( $opClJson );

        $data['opClDetailsClaimNum'] = count( $opClArray ) + 1;

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