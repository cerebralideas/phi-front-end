<?php
class Service_Activity
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->submissionModel = new Model_Submission();

    }

    public function getListByType( $type )
    {
        if ( strcasecmp( $type, 'reg' ) == 0 )
        {
            $query =
                'select
                submission.submissionId as `subId`,
                submission.submissionType as `subtype`,
                DATE_FORMAT(submission.createdDate, \'%m/%d/%Y\') as `subDate`,
                submission.createdBy as `student`,
                pt_submission.ptUniqueId as `ptUniqueId`,
                submission.submissionStatus as `subStatus`
            from submission
            inner join pt_submission on submission.submissionId = pt_submission.submissionId
            where submission.submissionType = ' . $this->submissionModel->getAdapter()->quote( $type ) .
            ' and (submission.submissionTo = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) .
            ' or submission.createdBy = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) . ')';

        }
        elseif ( strcasecmp( $type, 'adm' ) == 0 )
        {

            $query =
                'select
                submission.submissionId as `subId`,
                submission.submissionType as `subtype`,
                DATE_FORMAT(submission.createdDate, \'%m/%d/%Y\') as `subDate`,
                submission.createdBy as `student`,
                adm_submission.ptInfoUniqueId as `ptUniqueId`,
                submission.submissionStatus as `subStatus`
            from submission
            inner join adm_submission on submission.submissionId = adm_submission.submissionId
            where submission.submissionType = ' . $this->submissionModel->getAdapter()->quote( $type ) .
                    ' and (submission.submissionTo = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) .
                    ' or submission.createdBy = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) . ')';

        }
        elseif ( strcasecmp( $type, 'apt' ) == 0 )
        {

            $query =
                'select
                submission.submissionId as `subId`,
                submission.submissionType as `subtype`,
                DATE_FORMAT(submission.createdDate, \'%m/%d/%Y\') as `subDate`,
                submission.createdBy as `student`,
                apt_submission.ptInfoUniqueId as `ptUniqueId`,
                submission.submissionStatus as `subStatus`
            from submission
            inner join apt_submission on submission.submissionId = apt_submission.submissionId
            where submission.submissionType = ' . $this->submissionModel->getAdapter()->quote( $type ) .
                    ' and (submission.submissionTo = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) .
                    ' or submission.createdBy = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) . ')';

        }
        elseif ( strcasecmp( $type, 'opsb' ) == 0 )
        {

            $query =
                'select
                submission.submissionId as `subId`,
                submission.submissionType as `subtype`,
                DATE_FORMAT(submission.createdDate, \'%m/%d/%Y\') as `subDate`,
                submission.createdBy as `student`,
                submission.uniqueId as `ptUniqueId`,
                submission.submissionStatus as `subStatus`
            from submission
            inner join opSb_submission on submission.submissionId = opSb_submission.submissionId
            where submission.submissionType = ' . $this->submissionModel->getAdapter()->quote( $type ) .
                    ' and (submission.submissionTo = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) .
                    ' or submission.createdBy = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) . ')';

        }
        elseif ( strcasecmp( $type, 'opcl' ) == 0 )
        {

            $query =
                'select
                submission.submissionId as `subId`,
                submission.submissionType as `subtype`,
                DATE_FORMAT(submission.createdDate, \'%m/%d/%Y\') as `subDate`,
                submission.createdBy as `student`,
                submission.uniqueId as `ptUniqueId`,
                submission.submissionStatus as `subStatus`
            from submission
            inner join opCl_submission on submission.submissionId = opCl_submission.submissionId
            where submission.submissionType = ' . $this->submissionModel->getAdapter()->quote( $type ) .
                    ' and (submission.submissionTo = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) .
                    ' or submission.createdBy = ' . $this->submissionModel->getAdapter()->quote( $this->userId ) . ')';
        }

        else
        {
            $query =
                'select
                \'subId\' as `subId`,
                \'subtype\' as `subtype`,
                \'subDate\' as `subDate`,
                \'student\' as `student`,
                \'pt\' as `pt`,
                \'subStatus\' as `subStatus`
            from submission limit 1';

        }

        $stmt = $this->submissionModel->getAdapter()->query( $query );
        $rows = $stmt->fetchAll();
        $data = array();
        $usersModel = new Model_Users();
        $ptService = new Service_Pt;
        foreach ( $rows as $row )
        {
            $user = $usersModel->getByUserId($row['student']);
            $item = array();
            $item['subId'] = $row['subId'];
            $item['subtype'] = $row['subtype'];
            $item['subDate'] = $row['subDate'];
            $item['student'] =  $user['firstname'] . ' ' . $user['lastname'];

            $patient = $ptService->get( $row['ptUniqueId']);

            $item['pt'] = $patient['ptFirstName'] . ' ' . $patient['ptLastName'];
            $item['subStatus'] = strtolower($row['subStatus']);

            $data[] = $item;
        }

        return Zend_Json_Encoder::encode( $data );
    }

    public function getSubmission( $submissionId, $submissionType )
    {
        if ( strcasecmp( $submissionType, 'reg' ) == 0 )
        {
            $ptService = new Service_Pt();
            return $ptService->getSubmitJson( $submissionId );
        }
        elseif ( strcasecmp( $submissionType, 'apt' ) == 0 )
        {
            $aptService = new Service_Apt();
            return $aptService->getSubmitJson( $submissionId );
        }
        elseif ( strcasecmp( $submissionType, 'adm' ) == 0 )
        {
            $admService = new Service_Adm();
            return $admService->getSubmitJson( $submissionId );
        }

        elseif ( strcasecmp( $submissionType, 'opsb' ) == 0 )
        {
            $opSbService = new Service_OpSb();
            return $opSbService->getSubmitJson( $submissionId );
        }

        elseif ( strcasecmp( $submissionType, 'opcl' ) == 0 )
        {
            $opClService = new Service_OpCl();
            return $opClService->getSubmitJson( $submissionId );
        }
        else
        {
            return Zend_Json_Encoder::encode(array());
        }
    }

    public function insertSubmissionComment( $submissionId, $comment)
    {
        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $submissionId);
        $submission = $submissionModel->fetchRow( $where );

        if ( $submission )
        {
            $submissionCommentModel = new Model_SubmissionComment();
            $data = array();
            $data['submissionId'] = $submissionId;
            $data['comment'] = $comment;
            $submissionCommentModel->insert( $data );
        }
    }

    public function changeSubmissionStatus( $submissionId, $submissionStatus)
    {
        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $submissionId);
        $submission = $submissionModel->fetchRow( $where );

        if ( $submission )
        {
            $data = array();
            $data['submissionStatus'] = $submissionStatus;
            $submissionModel->update( $data, $where );

            $submissionHistoryModel = new Model_SubmissionHistory();
            $previousSubmissionStatus = $submission['submissionStatus'];
            $data = array();
            $data['submissionId'] = $submissionId;
            $data['submissionStatus'] = $previousSubmissionStatus;

            $submissionHistoryModel->insert( $data );

        }
    }

    public function getAuthorComments($submissionId)
    {
        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $submissionId);
        $submission = $submissionModel->fetchRow( $where );

        if ( $submission )
        {
            $author = $submission['createdBy'];
            $submissionCommentsModel = new Model_SubmissionComment();
            $where = $submissionCommentsModel->getAdapter()->quoteInto( 'submissionId = ?', $submissionId);
            $where .= $submissionCommentsModel->getAdapter()->quoteInto( ' AND createdBy = ?', $author);
            $submissionComments = $submissionCommentsModel->fetchAll( $where );

            if ( count($submissionComments) )
            {
                $data = array();
                $usersModel = new Model_Users();
                foreach ($submissionComments as $submissionComment)
                {
                    $item = array();
                    $user = $usersModel->getByUserId($author);
                    $item['subCommentId'] = $submissionComment['submissionCommentId'];
                    $item['subId'] = $submissionComment['submissionId'];
                    $item['userId'] = $author;
                    $item['fullName'] = $user['firstname'] . ' ' . $user['lastname'];
                    $item['commentDate'] = $submissionComment['createdDate'];
                    $item['comment'] = $submissionComment['comment'];
                    $data[] = $item;
                }

                return Zend_Json_Encoder::encode( $data );
            }
            else
            {
                return null;
            }
        }
    }

    public function getReviewerComments($submissionId)
    {
        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $submissionId);
        $submission = $submissionModel->fetchRow( $where );

        if ( $submission )
        {
            $reviewer = $submission['submissionTo'];
            $submissionCommentsModel = new Model_SubmissionComment();
            $where = $submissionCommentsModel->getAdapter()->quoteInto( 'submissionId = ?', $submissionId);
            $where .= $submissionCommentsModel->getAdapter()->quoteInto( ' AND createdBy = ?', $reviewer);
            $submissionComments = $submissionCommentsModel->fetchAll( $where );

            if ( count($submissionComments) )
            {
                $data = array();
                $usersModel = new Model_Users();
                foreach ($submissionComments as $submissionComment)
                {
                    $item = array();
                    $user = $usersModel->getByUserId($reviewer);
                    $item['subCommentId'] = $submissionComment['submissionCommentId'];
                    $item['subId'] = $submissionComment['submissionId'];
                    $item['userId'] = $reviewer;
                    $item['fullName'] = $user['firstname'] . ' ' . $user['lastname'];
                    $item['commentDate'] = $submissionComment['createdDate'];
                    $item['comment'] = $submissionComment['comment'];
                    $data[] = $item;
                }

                return Zend_Json_Encoder::encode( $data );
            }
            else
            {
                return null;
            }
        }
    }

    public function getComments($submissionId)
    {
        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $submissionId);
        $submission = $submissionModel->fetchRow( $where );

        if ( $submission )
        {
            $reviewer = $submission['submissionTo'];
            $submissionCommentsModel = new Model_SubmissionComment();
            $where = $submissionCommentsModel->getAdapter()->quoteInto( 'submissionId = ?', $submissionId);
            $submissionComments = $submissionCommentsModel->fetchAll( $where );

            if ( count($submissionComments) )
            {
                $data = array();
                $usersModel = new Model_Users();
                foreach ($submissionComments as $submissionComment)
                {
                    $item = array();

                    $item['subCommentId'] = $submissionComment['submissionCommentId'];

                    if ( strcasecmp($reviewer, $submissionComment['createdBy'] ) == 0)
                    {
                        $item['subCommentType'] = 'reviewer';
                        $item['userId'] = $reviewer;
                        $user = $usersModel->getByUserId($reviewer);
                        $item['fullName'] = $user['firstname'] . ' ' . $user['lastname'];
                    }
                    else
                    {
                        $item['subCommentType'] = 'author';
                        $item['userId'] = $submission['createdBy'];
                        $user = $usersModel->getByUserId($submission['createdBy']);
                        $item['fullName'] = $user['firstname'] . ' ' . $user['lastname'];
                    }
                    $item['subId'] = $submissionComment['submissionId'];
                    $item['commentDate'] = $submissionComment['createdDate'];
                    $item['comment'] = $submissionComment['comment'];
                    $data[] = $item;
                }

                return Zend_Json_Encoder::encode( $data );
            }
            else
            {
                return null;
            }
        }
    }
}