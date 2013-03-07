<?php
class Service_Adm
{
    private $service = 'adm';
    private $admModel;
    private $admWorkingModel;
    private $schema;
    private $masterData;
    private $userId;

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->admModel = new Model_Adm();
        $this->admWorkingModel = new Model_AdmWorking();

        // define schema for JSON
        $this->schema = array(
            "ptInfo" => array(
                "uniqueId" => null,
                "confidential" => null,
                "currentIns" => null,
                "diagnosis" => null,
                "admNum" => null
            ),
            "admDetails" => array(
                "admType" => null,
                "date" => null,
                "time" => null,
                "length" => null,
                "admId" => null
            ),
            "md" => array(
                "admitting" => null,
                "attending" => null,
                "surgical" => null,
                "referring" => null,
                "referringId" => null
            ),
            "location" => array(
                "specialty" => null,
                "ward" => null,
                "roomNumber" => null,
                "bedNumber" => null
            ),
            "status" => array(
                "ptStatus" => null,
                "admDate" => null,
                "admTime" => null,
                "dcDate" => null,
                "dcTime" => null,
                "dcNotes" => null
            ),
            "notes" => array(
                "authorization" => null,
                "reminderNotes" => null,
                "equipment" => null,
                "facility" => null,
                "staff" => null
            )
        );

        $preferencesService = new Service_Preferences();
        $this->masterData = $preferencesService->getMasterDataFlag();
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function getAllAdmListJson()
    {

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $query = '
                SELECT
                    `admDetailsAdmId` AS `admId`,
                    CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                    `admDetailsDate` AS `date`,
                    `admDetailsTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `admDetailsLength` AS `length`,
                    `locationWard` AS `serviceLocation`,
                    `adm`.`mdPrimary` AS `md`
                FROM `adm` INNER JOIN `pt` ON `adm`.`ptInfoUniqueId` = `pt`.`ptUniqueId`';

        }
        else
        {
            /* User is in 'Student' mode */

            $query = '
            SELECT
                `admDetailsAdmId` AS `admId`,
                CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                `admDetailsDate` AS `date`,
                `admDetailsTime` AS `time`,
                `pt`.`ptUniqueId` AS `uniqueId`,
                CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                `admDetailsLength` AS `length`,
                `locationWard` AS `serviceLocation`,
                `adm`.`mdPrimary` AS `md`
            FROM `adm` INNER JOIN `pt` ON `adm`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
            WHERE
                `admDetailsAdmId` NOT IN
                (
                        SELECT `admDetailsAdmId` FROM `adm_working` WHERE `createdBy` = ' . $this->admModel->quote( $this->userId ) . '
                )

            UNION

            SELECT
                `admDetailsAdmId` AS `admId`,
                CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                `admDetailsDate` AS `date`,
                `admDetailsTime` AS `time`,
                `pt`.`ptUniqueId` AS `uniqueId`,
                CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                `admDetailsLength` AS `length`,
                `locationWard` AS `serviceLocation`,
                `adm_working`.`mdPrimary` AS `md`
            FROM `adm_working` INNER JOIN `pt` ON `adm_working`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
            WHERE `adm_working`.`createdBy` = ' . $this->admModel->quote( $this->userId );

        }



        $stmt = $this->admModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();
        return Zend_Json_Encoder::encode( $result );

    }

    public function getAdmListForDateJson($startDate, $endDate)
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $query =
            'SELECT
                `admDetailsAdmId` AS `admId`,
                CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                `admDetailsDate` AS `date`,
                `admDetailsTime` AS `time`,
                `pt`.`ptUniqueId` AS `uniqueId`,
                CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                `admDetailsLength` AS `length`,
                `locationWard` AS `serviceLocation`,
                `adm`.`mdAttending` AS `md`
            FROM `adm` INNER JOIN `pt` ON `adm`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
            WHERE CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate)));
        }
        else
        {
            /* User is in 'Student' mode */
            $query =
            'SELECT
                `admDetailsAdmId` AS `admId`,
                CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                `admDetailsDate` AS `date`,
                `admDetailsTime` AS `time`,
                `pt`.`ptUniqueId` AS `uniqueId`,
                CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                `admDetailsLength` AS `length`,
                `locationWard` AS `serviceLocation`,
                `adm`.`mdAttending` AS `md`
            FROM `adm` INNER JOIN `pt` ON `adm`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
            WHERE CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate))) . '
            AND `admDetailsAdmId` NOT IN
            (
                    SELECT `admDetailsAdmId` FROM `adm_working` WHERE `createdBy` = ' . $this->admModel->quote( $this->userId ) . '
            )

            UNION

            SELECT
                `admDetailsAdmId` AS `admId`,
                CASE WHEN `statusPtStatus` = \'admitted\' THEN \'icon-checkmark\' ELSE \'\' END AS `admitted`,
                `admDetailsDate` AS `date`,
                `admDetailsTime` AS `time`,
                `pt`.`ptUniqueId` AS `uniqueId`,
                CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                `admDetailsLength` AS `length`,
                `locationWard` AS `serviceLocation`,
                `adm_working`.`mdAttending` AS `md`
            FROM `adm_working` INNER JOIN `pt` ON `adm_working`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
            WHERE CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`admDetailsDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->admModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate))) . '
            AND `adm_working`.`createdBy` = ' . $this->admModel->quote( $this->userId );
        }

        $stmt = $this->admModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();
        return Zend_Json_Encoder::encode( $result );
    }

    public function getAdmListForPtJson( $uniqueId )
    {
        $list = array();

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $where = $this->admModel->getAdapter()->quoteInto('ptInfoUniqueId = ?', $uniqueId );
            $items = $this->admModel->fetchAll($where);

        }
        else
        {
            /* User is in 'Student' mode */
            $query =
                'select
                    `admDetailsAdmId`,
                    `statusPtStatus`,
                    `admDetailsDate`,
                    `admDetailsTime`,
                    `admDetailsLength`,
                    `admDetailsAdmType`,
                    `locationWard`,
                    `mdAttending`,
                    `ptInfoDiagnosis`
                from `adm`
                WHERE
                    `admDetailsAdmId` NOT IN
                        (
                            SELECT `admDetailsAdmId` FROM `adm_working` WHERE `createdBy` = ' . $this->admModel->quote( $this->userId ) . '
                    ) AND ptInfoUniqueId = ' . $this->admModel->quote( $uniqueId ) . '
                UNION

                select
                    `admDetailsAdmId`,
                    `statusPtStatus`,
                    `admDetailsDate`,
                    `admDetailsTime`,
                    `admDetailsLength`,
                    `admDetailsAdmType`,
                    `locationWard`,
                    `mdAttending`,
                    `ptInfoDiagnosis`
                from `adm_working`
                where `createdBy` = ' . $this->admModel->quote( $this->userId ) .
                ' and ptInfoUniqueId = ' . $this->admModel->quote( $uniqueId );

            $stmt = $this->admModel->getAdapter()->query( $query );
            $items = $stmt->fetchAll();
        }

        foreach ( $items as $item )
        {
            $listItem = array();

            $listItem['admId'] = $item['admDetailsAdmId'];
            $listItem['ptStatus'] = $item['statusPtStatus'];
            $listItem['date'] = $item['admDetailsDate'];
            $listItem['time'] = $item['admDetailsTime'];
            $listItem['length'] = $item['admDetailsLength'];
            $listItem['admType'] = $item['admDetailsAdmType'];
            $listItem['serviceLocation'] = $item['locationWard'];
            $listItem['md'] = $item['mdAttending'];
            $listItem['diagnosis'] = $item['ptInfoDiagnosis'];


            $list[] = $listItem;
        }

        return Zend_Json_Encoder::encode( $list );
    }

    public function get( $uniqueId, $createdBy = 0 )
    {

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $where = $this->admModel->getAdapter()->quoteInto( 'admDetailsAdmId = ?', $uniqueId);
            $data = $this->admModel->fetchRow( $where );

        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->admWorkingModel->getAdapter()->quoteInto('admDetailsAdmId = ?', $uniqueId );
            $where .= $this->admWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->admWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->admWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->admModel->getAdapter()->quoteInto( 'admDetailsAdmId = ?', $uniqueId);
                $data = $this->admModel->fetchRow( $where );
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
            if ( isset( $data['admDetailsAdmId']) )
            {
                /* If admDetailsAdmId was passed, we're doing an update */
                $where = $this->admModel->getAdapter()->quoteInto('admDetailsAdmId = ?', $data['admDetailsAdmId']);
                $this->admModel->update( $data, $where);
                $resp = $data['admDetailsAdmId'];
            }
            else
            {
                /* No admDetailsAdmId was passed, so we're doing an insert */
                $this->admModel->insert( $data );
                $resp = $this->admModel->lastInsertId();
            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['admDetailsAdmId']) )
            {
                /* If admDetailsAdmId was passed, we're going to see if user has a working copy */
                $where = $this->admWorkingModel->getAdapter()->quoteInto('admDetailsAdmId = ?', $data['admDetailsAdmId'] );
                $where .= $this->admWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->admWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $this->admWorkingModel->update( $data, $where);
                    $resp = $data['admDetailsAdmId'];
                }
                /* create new working copy */
                else
                {
                    $this->admWorkingModel->insert( $data );
                    $resp = $this->admWorkingModel->lastInsertId();
                }

            }
            else
            {
                /* No admDetailsAdmId was passed, so we're doing an insert */
                $this->admWorkingModel->insert( $data );
                $resp = $this->admWorkingModel->lastInsertId();
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

    public function submitJson( array $data, $submissionId )
    {
        $mappingService = new Service_Mapping();
        $dbArray = array();
        $dbArray = $mappingService->mapToDb( $data, '', $dbArray);

        $dbArray['submissionId'] = $submissionId;
        $admSubmissionModel = new Model_AdmSubmission();

        $admSubmissionModel->insert( $dbArray );

    }

    public function getSubmitJson( $uniqueId )
    {
        $admSubmissionModel = new Model_AdmSubmission();
        $admWhere = $admSubmissionModel->getAdapter()->quoteInto( 'submissionId = ?', $uniqueId);
        $admData = $admSubmissionModel->fetchRow( $admWhere );

        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
        $submission = $submissionModel->fetchRow( $where );

        $usersModel = new Model_Users();

        $ptService = new Service_Pt();
        $ptData = $ptService->get( $admData['ptInfoUniqueId'], $submission['createdBy'] );

        $submitData = array();
        $submitData['subId'] = $submission['submissionId'];
        $submitData['subtype'] = $submission['submissionType'];
        $submitData['subDate'] = date('m/d/Y', strtotime($submission['createdDate']));
        $user = $usersModel->getByUserId($submission['createdBy']);
        $submitData['student'] =  $user['firstname'] . ' ' . $user['lastname'];
        $user = $usersModel->getByUserId($submission['submissionTo']);
        $submitData['faculty'] = $user['firstname'] . ' ' . $user['lastname'];
        $submitData['pt'] = $ptData['ptFirstName'] . ' ' . $ptData['ptLastName'];
        $submitData['subStatus'] = strtolower($submission['submissionStatus']);

        $mappingService = new Service_Mapping();

        $json = '{"meta": ' .Zend_Json_Encoder::encode($submitData);
        $json .= ',"item": ' . Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $admData ) ) . '}';
        return $json;
    }

    public function getSequenceId()
    {
        $seqService = new Service_Seq();
        return $seqService->getValue( $this->service );
    }

    public function import()
    {
        echo '<pre>';
        $dataPath = APPLICATION_PATH . '/views/scripts/patients/data/master-adms';

        echo 'Looking for data in: ' . $dataPath . PHP_EOL;

        // Check to make sure dataPath is a valid directory
        if ( is_dir( $dataPath ) )
        {
            if ($handle = opendir( $dataPath )) {

                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && $entry != ".svn")
                    {
                        echo 'Processing ' . $entry . PHP_EOL;
                        $fHandle = fopen( $dataPath . DIRECTORY_SEPARATOR . $entry, "r");
                        $fContents = fread( $fHandle, filesize( $dataPath . DIRECTORY_SEPARATOR . $entry ));
                        $json = Zend_Json_Decoder::decode($fContents);
                        echo 'Json: ' . PHP_EOL;
                        echo Zend_Debug::dump($json) . PHP_EOL;
                        $this->updateJson( $json );
                        fclose($fHandle);

                    }


                }



                closedir($handle);
            }
        }
        echo 'Processing Completed' . PHP_EOL;
        echo '</pre>';
    }
}