<?php
class Service_AccItem
{
    private $service = 'accItem';
    private $accItemModel;
    private $accItemWorkingModel;
    private $schema;
    private $masterData;
    private $userId;
    private $debug = false;

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->accItemModel = new Model_AccItem();
        $this->accItemWorkingModel = new Model_AccItemWorking();

        // define schema for JSON
        $this->schema = array(

            "accItem" => array(
                "accItemId" => null,
                "postDate" => null,
                "postType" => null,
                "claimNum" => null,
                "payor" => null,
                "debit" => null,
                "adjustment" => null,
                "credit" => null,
                "paymentType" => null,
                "adjustmentType" => null,
                "refundType" => null,
                "referenceNumber" => null,
                "totalProcedures" => null,
                "postComment" => null
            )

        );

        $preferencesService = new Service_Preferences();
        $this->masterData = $preferencesService->getMasterDataFlag();
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function get( $uniqueId, $createdBy = 0 )
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $where = $this->accItemModel->getAdapter()->quoteInto( 'accItemAccItemId = ?', $uniqueId);
            $data = $this->accItemModel->fetchRow( $where );


        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->accItemWorkingModel->getAdapter()->quoteInto('accItemAccItemId = ?', $uniqueId );
            $where .= $this->accItemWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->accItemWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->accItemWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->accItemModel->getAdapter()->quoteInto( 'accItemAccItemId = ?', $uniqueId);
                $data = $this->accItemModel->fetchRow( $where );
            }

        }
        return $data;
    }

    public function getJson( $uniqueId, $createdBy = 0 )
    {
        $data = $this->get( $uniqueId, $createdBy );
        $mappingService = new Service_Mapping();
        return Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
    }

    public function update ( array $data )
    {
        $resp = null;

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['accItemAccItemId']) )
            {
                /* If accItemAccItemId was passed, we're doing an update */
                $where = $this->accItemModel->getAdapter()->quoteInto('accItemAccItemId = ?', $data['accItemAccItemId']);
                $this->accItemModel->update( $data, $where);
                $resp = $data['accItemAccItemId'];
            }
            else
            {
                /* No accItemAccItemId was passed, so we're doing an insert */
                $this->accItemModel->insert( $data );
                $resp = $this->accItemModel->lastInsertId();
            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['accItemAccItemId']) )
            {
                /* If accItemAccItemId was passed, we're going to see if user has a working copy */
                $where = $this->accItemWorkingModel->getAdapter()->quoteInto('accItemAccItemId = ?', $data['accItemAccItemId'] );
                $where .= $this->accItemWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->accItemWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $this->accItemWorkingModel->update( $data, $where);
                    $resp = $data['accItemAccItemId'];
                }
                /* create new working copy */
                else
                {
                    $this->accItemWorkingModel->insert( $data );
                    $resp = $this->accItemWorkingModel->lastInsertId();
                }

            }
            else
            {
                /* No accItemAccItemId was passed, so we're doing an insert */
                $this->accItemWorkingModel->insert( $data );
                $resp = $this->accItemWorkingModel->lastInsertId();
            }
        }

        return $resp;
    }

    public function updateJson( array $data )
    {
        $mappingService = new Service_Mapping();
        $dbArray = array();
        $dbArray = $mappingService->mapToDb( $data, '', $dbArray);
        return $this->update( $dbArray );
    }


}