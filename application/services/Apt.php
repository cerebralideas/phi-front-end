<?php
class Service_Apt
{
    private $service = 'apt';
    private $aptModel;
    private $aptWorkingModel;
    private $schema;
    private $masterData;
    private $userId;
    private $debug = false;

    private $aptInterval = 15;
    private $aptStartTime = '0800';
    private $aptEndTime = '1700';

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->aptModel = new Model_Apt();
        $this->aptWorkingModel = new Model_AptWorking();

        // define schema for JSON
        $this->schema = array(
            "ptInfo" => array(
                "uniqueId" => null,
                "newPt" => null,
                "currentIns" => null,
                "aptNum" => null,
                "condRelatedTo" => null,
                "autoAccState" => null
            ),
            "md" => array(
                "clinic" => null,
                "referring" => null,
                "referringId" => null
            ),
            "aptDetails" => array(
                "serviceLocation" => null,
                "startDate" => null,
                "startTime" => null,
                "length" => null,
                "aptType" => null,
                "reason" => null,
                "aptId" => null
            ),
            "status" => array(
                "ptStatus" => null,
                "checkInDate" => null,
                "checkInTime" => null,
                "checkOutDate" => null,
                "checkOutTime" => null,
                "statusNotes" => null
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

    public function getAptListForPtJson( $uniqueId )
    {
        $list = array();

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $where = $this->aptModel->getAdapter()->quoteInto('ptInfoUniqueId = ?', $uniqueId );
            $items = $this->aptModel->fetchAll($where);
        }
        else
        {
            /* User is in 'Student' mode */
            $query =
                'select
                    `aptDetailsAptId`,
                    `statusPtStatus`,
                    `aptDetailsStartDate`,
                    `aptDetailsStartTime`,
                    `aptDetailsLength`,
                    `ptInfoNewPt`,
                    `aptDetailsServiceLocation`,
                    `mdClinic`,
                    `aptDetailsAptType`,
                    `aptDetailsReason`
                from `apt`
                WHERE
                    `aptDetailsAptId` NOT IN
                        (
                            SELECT `aptDetailsAptId` FROM `apt_working` WHERE `createdBy` = ' . $this->aptModel->quote( $this->userId ) . '
                    ) AND ptInfoUniqueId = ' . $this->aptModel->quote( $uniqueId ) . '
                UNION

                select
                    `aptDetailsAptId`,
                    `statusPtStatus`,
                    `aptDetailsStartDate`,
                    `aptDetailsStartTime`,
                    `aptDetailsLength`,
                    `ptInfoNewPt`,
                    `aptDetailsServiceLocation`,
                    `mdClinic`,
                    `aptDetailsAptType`,
                    `aptDetailsReason`
                from `apt_working`
                where `createdBy` = ' . $this->aptModel->quote( $this->userId ) .
                ' and ptInfoUniqueId = ' . $this->aptModel->quote( $uniqueId );

            $stmt = $this->aptModel->getAdapter()->query( $query );
            $items = $stmt->fetchAll();

        }

        foreach ( $items as $item )
        {
            $listItem = array();
            $listItem['aptId'] = $item['aptDetailsAptId'];
            $listItem['ptStatus'] = $item['statusPtStatus'];
            $listItem['date'] = $item['aptDetailsStartDate'];
            $listItem['time'] = $item['aptDetailsStartTime'];
            $listItem['length'] = $item['aptDetailsLength'];
            $listItem['newPt'] = $item['ptInfoNewPt'];
            $listItem['serviceLocation'] = $item['aptDetailsServiceLocation'];
            $listItem['md'] = $item['mdClinic'];
            $listItem['aptType'] = $item['aptDetailsAptType'];
            $listItem['reason'] = $item['aptDetailsReason'];

            $list[] = $listItem;
        }

        return Zend_Json_Encoder::encode( $list );
    }

    public function getAllAptListJson()
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $query = '
                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt` INNER JOIN `pt` ON `apt`.`ptInfoUniqueId` = `pt`.`ptUniqueId`';
        }
        else
        {
            /* User is in 'Student' mode */

            $query = '
                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `ptInfoNewPt` AS `newPt`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt` INNER JOIN `pt` ON `apt`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
                WHERE
                    `aptDetailsAptId` NOT IN
                    (
                        SELECT `aptDetailsAptId` FROM `apt_working` WHERE `createdBy` = ' . $this->aptModel->quote( $this->userId ) . '
                    )

                UNION

                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `ptInfoNewPt` AS `newPt`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt_working` INNER JOIN `pt` ON `apt_working`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
                WHERE
                    `apt_working`.`createdBy` = ' . $this->aptModel->quote( $this->userId );
        }



        $stmt = $this->aptModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();
        return Zend_Json_Encoder::encode( $result );
    }

    public function getAptListForDateJson($startDate, $endDate)
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $query = '
                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `ptInfoNewPt` AS `newPt`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt` INNER JOIN `pt` ON `apt`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
                WHERE CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate)));
        }
        else
        {
            /* User is in 'Student' mode */

            $query = '
                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `ptInfoNewPt` AS `newPt`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt` INNER JOIN `pt` ON `apt`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
                WHERE CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate))) . '
                AND
                    `aptDetailsAptId` NOT IN
                    (
                        SELECT `aptDetailsAptId` FROM `apt_working` WHERE `createdBy` = ' . $this->aptModel->quote( $this->userId ) . '
                    )

                UNION

                SELECT
                    `aptDetailsAptId` AS `aptId`,
                    CASE WHEN `statusPtStatus` = \'Checked-In\' THEN \'icon-checkmark\' ELSE \'\' END AS `checkedIn`,
                    `ptInfoNewPt` AS `newPt`,
                    `aptDetailsStartDate` AS `date`,
                    `aptDetailsStartTime` AS `time`,
                    `pt`.`ptUniqueId` AS `uniqueId`,
                    CONCAT(`pt`.`ptFirstName`, \' \', `pt`.`ptMiddleName`, \' \', `pt`.`ptLastName`, \' \', `pt`.`ptSuffix`) AS `patient`,
                    `aptDetailsLength` AS `length`,
                    `aptDetailsServiceLocation` AS `serviceLocation`,
                    `mdClinic` AS `md`
                FROM `apt_working` INNER JOIN `pt` ON `apt_working`.`ptInfoUniqueId` = `pt`.`ptUniqueId`
                WHERE CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) >= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($startDate))) .' AND CAST(STR_TO_DATE(`aptDetailsStartDate`, \'%m/%d/%Y\') AS DATETIME) <= ' . $this->aptModel->getAdapter()->quote(date('Y-m-d', strtotime($endDate))) . '
                AND `apt_working`.`createdBy` = ' . $this->aptModel->quote( $this->userId );

        }
        $stmt = $this->aptModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();
        return Zend_Json_Encoder::encode( $result );
    }

    public function getAvailabilityForDateJson($location, $date)
    {



        if ( $this->debug )
        {
            echo '<pre>';
            echo 'Looking at location: ' . $location . PHP_EOL;
            echo 'Looking at date: ' . $date . PHP_EOL;
        }

        // Determine what day of the week this date is
        $dayOfWeek = date('D', strtotime($date));
        if ( $this->debug )
        {
            echo 'Day of Week: ' . $dayOfWeek . PHP_EOL;
        }

        // Determine location availability for that day of the week
        $locModel = new Model_Location();
        $locWhere = $locModel->getAdapter()->quoteInto('`locationName` = ?', $location);
        $locWhere .= $locModel->getAdapter()->quoteInto(' AND `locationDay` = ?', $dayOfWeek);
        $locAvailability = $locModel->fetchRow( $locWhere );

        $locStartTime = $locAvailability['locationStartTime'];
        $locEndTime = $locAvailability['locationEndTime'];

        if ( $this->debug )
        {
            echo 'Location Start Time: ' . $locStartTime . PHP_EOL;
            echo 'Location End Time: ' . $locEndTime . PHP_EOL;
            echo 'Appointment Interval: '  . $this->aptInterval . PHP_EOL;
        }

        // For consistency of the user interface this feed will always start and end at the same time.
        $time = $this->aptStartTime;
        $availabilityArray = array();
        while ( $time <= $this->aptEndTime )
        {
            $blockedIndicator = 'false';

            if ( $this->debug )
            {
                echo 'Time: ' . date('Hi', strtotime($time)) . PHP_EOL;
            }

            // check to see if this location is open during this particular time slot
            if ( $time >= $locStartTime && $time < $locEndTime )
                $open = 'true';
            else
                $open = 'false';

            $staffModel = new Model_Staff();
            $staffWhere = $staffModel->getAdapter()->quoteInto('staffDay = ?', $dayOfWeek);
            $staff = $staffModel->fetchAll($staffWhere);


            $staffArray = array();
            foreach ($staff as $person)
            {
                $personName = $person['staffName'];
                $personStartTime = date('Hi', strtotime($person['staffStartTime']));
                $personEndTime = date('Hi', strtotime($person['staffEndTime']));
                if ( $this->debug )
                {
                    echo '    ' . 'Staff Name: ' . $personName . PHP_EOL;
                    echo '    ' . 'Staff Start: ' . $personStartTime . PHP_EOL;
                    echo '    ' . 'Staff End: ' . $personEndTime . PHP_EOL;
                }

                // Determine general working hours of this person
                if ( $time >= $personStartTime && $time < $personEndTime )
                {
                    // Determine if they have their calendar blocked for this time period
                    $staffBusyModel = new Model_StaffBusy();
                    $staffBusyWhere = $staffBusyModel->getAdapter()->quoteInto('`staffName` = ?', $personName);
                    $staffBusyWhere .= $staffBusyModel->getAdapter()->quoteInto(' AND `busyDay` = ?', $dayOfWeek);

                    $staffBusy = $staffBusyModel->fetchAll( $staffBusyWhere );

                    $blockedIndicator = 'false';
                    foreach ( $staffBusy as $staffBusyTimeSlot )
                    {
                        $staffBusyTimeStart = $staffBusyTimeSlot['busyStartTime'];
                        $staffBusyTimeEnd = $staffBusyTimeSlot['busyEndTime'];

                        if ( $time >= $staffBusyTimeStart && $time < $staffBusyTimeEnd )
                        {
                            $blockedIndicator = 'true';
                            break;
                        }

                    }

                    // Determine if they already have an appointment for this time slot, only if availability
                    // indicator is still true

                    if (strcasecmp($blockedIndicator, 'false') == 0)
                    {
                        $aptList = Zend_Json_Decoder::decode($this->getAptListForDateJson($date, $date));
                        //Zend_Debug::dump( $aptList );

                        foreach ( $aptList as $apt ){
                            $aptMd = $apt['md'];
                            $aptStartTime = date('Hi', strtotime($apt['time']));
                            $aptLength = str_replace('min', 'minutes', $apt['length']);
                            $aptEndTime = date('Hi', strtotime( $aptStartTime . '+' . $aptLength));

                            if ( $this->debug )
                            {
                                echo '    Checking conflicting appointments...' . PHP_EOL;
                                echo '    Md: ' . $aptMd . PHP_EOL;
                                echo '    Start: ' . $aptStartTime . PHP_EOL;
                                echo '    End: ' . $aptEndTime . PHP_EOL;
                                echo '    Time: ' . $time . PHP_EOL;
                            }

                            $aptDetails = null;
                            // Check to see if there is an appointment for this location for this person for this time slot
                            if ( strcasecmp($location, $apt['serviceLocation']) == 0 && strcasecmp($personName, $aptMd) == 0 && $time >= $aptStartTime && $time < $aptEndTime )
                            {

                                // Determine whether start of an appointment or a continuation of an appointment
                                if ( strcasecmp($aptStartTime, $time) == 0 )
                                    $aptStatus = 'start';
                                else
                                    $aptStatus = 'cont';



                                $blockedIndicator = 'false';
                                $aptDetails = array(
                                    'aptStartTime' => $aptStartTime,
                                    'time' => $time,
                                    'length' => $apt['length'],
                                    'status' => $aptStatus,
                                    'patient' => $apt['patient']

                                );

                                break;
                            }
                            else
                            {
                                $blockedIndicator = 'false';
                                $aptDetails = null;
                            }

                        }
                    }
                    else
                    {
                        $blockedIndicator = 'true';
                        $aptDetails = null;
                    }
                    if ( $this->debug )
                    {
                        echo '    ' . 'Staff Blocked: ' . $blockedIndicator . PHP_EOL;
                    }
                }
                else
                {
                    $aptDetails = null;
                    $blockedIndicator = 'true';

                    if ( $this->debug )
                    {
                        echo '    ' . 'Staff Blocked: ' . $blockedIndicator . PHP_EOL;
                    }
                }

                $staffArray[] = array(
                    'md' => $personName,
                    'time' => $time,
                    'blocked' => $blockedIndicator,
                    'apt' => $aptDetails
                );

            }

            $availabilityArray[] = array(
                'time' => $time,
                'open' => $open,
                'mds' => $staffArray
            );

            // Increment time by apt interval
            $time = date('Hi', strtotime( $time . '+' . $this->aptInterval . ' minutes'));
        }



        if ( $this->debug )
        {
            echo '</pre>';
            Zend_Debug::dump($availabilityArray);
        }
        //echo '<pre>';
        $json = Zend_Json_Encoder::encode($availabilityArray);
        //echo Zend_Json::prettyPrint($json, array("indent" => " "));
        //echo '</pre>';
        echo $json;


    }

    public function get( $uniqueId, $createdBy = 0 )
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $where = $this->aptModel->getAdapter()->quoteInto( 'aptDetailsAptId = ?', $uniqueId);
            $data = $this->aptModel->fetchRow( $where );


        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->aptWorkingModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $uniqueId );
            $where .= $this->aptWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->aptWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->aptWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->aptModel->getAdapter()->quoteInto( 'aptDetailsAptId = ?', $uniqueId);
                $data = $this->aptModel->fetchRow( $where );
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
            if ( isset( $data['aptDetailsAptId']) )
            {
                /* If aptDetailsAptId was passed, we're doing an update */
                $where = $this->aptModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $data['aptDetailsAptId']);
                $this->aptModel->update( $data, $where);
                $resp = $data['aptDetailsAptId'];
            }
            else
            {
                /* No aptDetailsAptId was passed, so we're doing an insert */
                $this->aptModel->insert( $data );
                $resp = $this->aptModel->lastInsertId();
            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['aptDetailsAptId']) )
            {
                /* If aptDetailsAptId was passed, we're going to see if user has a working copy */
                $where = $this->aptWorkingModel->getAdapter()->quoteInto('aptDetailsAptId = ?', $data['aptDetailsAptId'] );
                $where .= $this->aptWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->aptWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $this->aptWorkingModel->update( $data, $where);
                    $resp = $data['aptDetailsAptId'];
                }
                /* create new working copy */
                else
                {
                    $this->aptWorkingModel->insert( $data );
                    $resp = $this->aptWorkingModel->lastInsertId();
                }

            }
            else
            {
                /* No aptDetailsAptId was passed, so we're doing an insert */
                $this->aptWorkingModel->insert( $data );
                $resp = $this->aptWorkingModel->lastInsertId();
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
        $aptSubmissionModel = new Model_AptSubmission();

        $aptSubmissionModel->insert( $dbArray );

    }

    public function getSubmitJson( $uniqueId )
    {
        $aptSubmissionModel = new Model_AptSubmission();
        $aptWhere = $aptSubmissionModel->getAdapter()->quoteInto( 'submissionId = ?', $uniqueId);
        $aptData = $aptSubmissionModel->fetchRow( $aptWhere );

        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
        $submission = $submissionModel->fetchRow( $where );

        $usersModel = new Model_Users();

        $ptService = new Service_Pt();
        $ptData = $ptService->get( $aptData['ptInfoUniqueId'], $submission['createdBy'] );

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
        $json .= ',"item": ' . Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $aptData ) ) . '}';
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
        $dataPath = APPLICATION_PATH . '/views/scripts/patients/data/master-apts';

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