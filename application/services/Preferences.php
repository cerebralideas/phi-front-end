<?php
class Service_Preferences
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->preferencesModel = new Model_Preferences();

    }

    public function getMasterDataFlag()
    {
        $where = $this->preferencesModel->getAdapter()->quoteInto('userId = ?', $this->userId);
        $row = $this->preferencesModel->fetchRow( $where );

        if ( $row )
        {
            if ( strcasecmp($row['masterData'], '1' ) == 0 )
                return true;
            else
                return false;
        }
        else
        {
            return false;
        }
    }

    public function setMasterDataFlag( $masterDataFlag )
    {
        $where = $this->preferencesModel->getAdapter()->quoteInto('userId = ?', $this->userId);
        $row = $this->preferencesModel->fetchRow( $where );

        if ( $row )
        {


            $data = array();
            $data['masterData'] = $masterDataFlag;
            $this->preferencesModel->update( $data, $where );
        }
        else
        {
            $data = array();
            $data['userId'] = $this->userId;
            $data['masterData'] = $masterDataFlag;

            $this->preferencesModel->insert( $data );
        }
    }
}