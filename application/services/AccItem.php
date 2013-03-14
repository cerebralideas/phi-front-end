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
                "opClId" => null,
                "uniqueId" => null,
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

            $where = $this->accItemModel->getAdapter()->quoteInto( 'accItemId = ?', $uniqueId);
            $data = $this->accItemModel->fetchRow( $where );


        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->accItemWorkingModel->getAdapter()->quoteInto('accItemId = ?', $uniqueId );
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
                $where = $this->accItemModel->getAdapter()->quoteInto( 'accItemId = ?', $uniqueId);
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

    public function getAllAssociatedJsonObjects( $opClId, $createdBy = 0 )
    {
        $opClService = new Service_OpCl();
        $opClJsonData =  $opClService->getJson( $opClId, $createdBy );
        $opClArrayData = Zend_Json_Decoder::decode( $opClJsonData );

        if ( $opClArrayData['opClDetails']['opSbId'] )
        {
            $opSbService = new Service_OpSb();
            $opSbJsonData = $opSbService->getJson( $opClArrayData['opClDetails']['opSbId'], $createdBy );
            $opSbArrayData = Zend_Json_Decoder::decode( $opSbJsonData );

            if ( $opSbArrayData['opSbDetails']['aptId'] )
            {
                $aptService = new Service_Apt();
                $aptJsonData = $aptService->getJson( $opSbArrayData['opSbDetails']['aptId'], $createdBy );
                $aptArrayData = Zend_Json_Decoder::decode( $aptJsonData );

                $returnArrayData = array(
                    'opCl' => $opClArrayData,
                    'opSb' => $opSbArrayData,
                    'apt' => $aptArrayData
                );

                return Zend_Json_Encoder::encode( $returnArrayData );

            }

        }
    }

    public function update ( array $data )
    {
        $resp = null;

        // Get account balance
        $accCurrentBalance = $this->getCurrentBalance( $data['UniqueId'] );
        echo 'accCurrentBalance: ' . $accCurrentBalance . '<br />';

        if ( !isset( $data['AccItemBalance'] ) )
        {
            if ( strcasecmp($data['PostType'], 'Bill' ) == 0 )
                $data['AccItemBalance'] = $accCurrentBalance + abs( $data['Debit'] );
            elseif ( strcasecmp($data['PostType'], 'Payment' ) == 0 )
                $data['AccItemBalance'] = $accCurrentBalance - abs( $data['Credit'] );
            elseif ( strcasecmp($data['PostType'], 'Adjustment' ) == 0 )
                $data['AccItemBalance'] = $accCurrentBalance + abs( $data['Adjustment'] );
            elseif ( strcasecmp($data['PostType'], 'Refund' ) == 0 )
                $data['AccItemBalance'] = $accCurrentBalance + abs( $data['Credit'] );
        }

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['accItemId']) )
            {
                /* If accItemId was passed, we're doing an update */
                $where = $this->accItemModel->getAdapter()->quoteInto('accItemId = ?', $data['accItemId']);
                $this->accItemModel->update( $data, $where);
                $resp = $data['accItemId'];
            }
            else
            {
                /* No accItemId was passed, so we're doing an insert */
                $this->accItemModel->insert( $data );
                $resp = $this->accItemModel->lastInsertId();
            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['accItemId']) )
            {
                /* If accItemId was passed, we're going to see if user has a working copy */
                $where = $this->accItemWorkingModel->getAdapter()->quoteInto('accItemId = ?', $data['accItemId'] );
                $where .= $this->accItemWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->accItemWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $this->accItemWorkingModel->update( $data, $where);
                    $resp = $data['accItemId'];
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
                /* No accItemId was passed, so we're doing an insert */
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

    public function getByPtId( $uniqueId )
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $query = '
                SELECT
                    `accItemId`,
                    `uniqueId`,
                    `opClId`,
                    `postDate`,
                    `postType`,
                    `claimNum`,
                    `payor`,
                    `debit`,
                    `adjustment`,
                    `credit`,
                    `paymentType`,
                    `adjustmentType`,
                    `refundType`,
                    `referenceNumber`,
                    `totalProcedures`,
                    `accItemBalance`,
                    `postComment`
                FROM `accItem`
                WHERE
                    `uniqueId` = ' . $this->accItemModel->quote( $uniqueId );

        }
        else
        {
            /* User is in 'Student' mode */
            $query = '
                SELECT
                    `accItemId`,
                    `uniqueId`,
                    `opClId`,
                    `postDate`,
                    `postType`,
                    `claimNum`,
                    `payor`,
                    `debit`,
                    `adjustment`,
                    `credit`,
                    `paymentType`,
                    `adjustmentType`,
                    `refundType`,
                    `referenceNumber`,
                    `totalProcedures`,
                    `accItemBalance`,
                    `postComment`
                FROM `accItem`
                WHERE
                    `accItemId` NOT IN
                    (
                        SELECT `accItemId` FROM `accItem_working` WHERE `createdBy` = ' . $this->accItemModel->quote( $this->userId ) . '
                    )
                    AND
                    `uniqueId` = ' . $this->accItemModel->quote( $uniqueId ) . '

                UNION

                SELECT
                    `accItemId`,
                    `uniqueId`,
                    `opClId`,
                    `postDate`,
                    `postType`,
                    `claimNum`,
                    `payor`,
                    `debit`,
                    `adjustment`,
                    `credit`,
                    `paymentType`,
                    `adjustmentType`,
                    `refundType`,
                    `referenceNumber`,
                    `totalProcedures`,
                    `accItemBalance`,
                    `postComment`
                FROM `accItem_working`
                WHERE
                    `createdBy` = ' . $this->accItemModel->quote( $this->userId ) . '
                    AND
                    `uniqueId` = ' . $this->accItemModel->quote( $uniqueId );
        }
        $stmt = $this->accItemModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();

        return Zend_Json_Encoder::encode( $result );
    }

    public function getAccItems( $uniqueId )
    {
        $accItems = Zend_Json_Decoder::decode( $this->getByPtId( $uniqueId ) );
        $currentBalance = $this->getCurrentBalance( $uniqueId );
        $returnData = array('accItems' => $accItems, 'currentBalance' => $currentBalance);
        return Zend_Json_Encoder::encode($returnData);
    }

    public function getCurrentBalance( $uniqueId )
    {
        $accItems = Zend_Json_Decoder::decode( $this->getByPtId( $uniqueId ) );

        if ( count( $accItems ) )
            return $accItems[count ( $accItems ) - 1]['accItemBalance'];
        else
            return 0.00;
    }
}