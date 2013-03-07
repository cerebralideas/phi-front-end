<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/21/12
 * Time: 9:20 AM
 * To change this template use File | Settings | File Templates.
 */
class Service_Submission
{
    private $auth;
    private $storage;
    private $userId;
    private $lastInsertId;

    public function __construct()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
        $this->lastInsertId = 0;
    }

    public function patientSubmit($patientId, $submissionTo, $submissionComments)
    {
        $submissionModel = new Model_Submission();
        $patientSubmissionModel = new Model_PatientSubmission();
        $patientModel = new Model_Patient();
        $submissionTypeId = '1';

        $patientSubmissionData = $patientModel->getByPatientId($patientId);

        $submissionData = array(
            'submission_type_id' => $submissionTypeId,
            'patient_id' => $patientId,
            'submission_to' => $submissionTo,
            'submission_status_id' => '1'
        );


        // store basic submission info and get submissionId
        $submissionModel->insert($submissionData);
        $submissionId = $submissionModel->getAdapter()->lastInsertId();

        // snapshot patient information and store
        $patientSubmissionData['submission_id'] = $submissionId;
        $patientSubmissionModel->insert($patientSubmissionData);

        // store initial comment if any
        if (trim($submissionComments) != '')
        {
            $submissionCommentData = array(
                'submission_id' => $submissionId,
                'comment' => $submissionComments,
                'created_by' => $this->userId,
                'created_date' => date('Y-m-d H:i:s'),
                'modified_by' => $this->userId,
                'modified_date' => date('Y-m-d H:i:s')
            );

            $submissionCommentModel = new Model_SubmissionComment();
            $submissionCommentModel->insert($submissionCommentData);
        }

        // initialize status history
        $submissionHistoryData = array(
            'submission_id' => $submissionId,
            'submission_status_id' => '1',
            'created_by' => $this->userId,
            'created_date' => date('Y-m-d H:i:s'),
            'modified_by' => $this->userId,
            'modified_date' => date('Y-m-d H:i:s')
        );

        $submissionHistoryModel = new Model_SubmissionHistory();
        $submissionHistoryModel->insert($submissionHistoryData);
    }

    public function getPatientSubmission($submissionId)
    {

        $patientSubmissionModel = new Model_PatientSubmission();
        $query =
            $patientSubmissionModel->getAdapter()->select()
                ->from(array('s' => 'submission'),
                    array(
                        'submitted_by' => new Zend_Db_Expr('s.created_by'),
                        'submitted_date' => new Zend_Db_Expr('s.created_date')
                    ))
                ->joinInner(array('ps' => 'patient_submission'),
                    's.submission_id = ps.submission_id')
                ->where('s.submission_id = ?', $submissionId)
                ->where('s.submission_to = ?', $this->userId)
                ->query();

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return $results[0];
        }
        return null;

    }

    public function getSubmission($submissionId)
    {
        $submissionModel = new Model_Submission();
        $query = $submissionModel->select()
            ->where('submission_id = ?', $submissionId)
            ->query();

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return $results[0];
        }
        return null;
    }

    public function getSubmissions($submissionTypeId, $submissionStatusId)
    {
        $submissionModel = new Model_Submission();
        $query = $submissionModel->getAdapter()->select()
            ->from(array('u' => AUTH_MYSQL_DATABASE.'.users'),
                array(
                    's.submission_id',
                    'submitted_by_fullname' => new Zend_Db_Expr("CONCAT(firstname,' ',lastname)"),
                    'patient_fullname' => new Zend_Db_Expr("CONCAT(p.fname,' ',p.lname)")
                ))
            ->joinInner(
                array('s' => 'submission',),
                'u.id = s.created_by',
                array(
                    'submitted_date' => new Zend_Db_Expr('s.created_date')
                ))
            ->joinInner(
                array('p' => 'patient',),
                'p.patient_id = s.patient_id',
                array())
            ->where('submission_status_id = ?', $submissionStatusId)
            ->where('s.submission_to = ?', $this->userId)
            ->query();

        // need student name, patient name & submission date

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return $results;
        }
        return null;

    }

    public function getSubmissionHistory($submissionId)
    {
        $submissionHistoryModel = new Model_SubmissionHistory();
        $query = $submissionHistoryModel->getAdapter()->select()
            ->from(array('u' => AUTH_MYSQL_DATABASE.'.users'),
                array(
                    'u.role'
                )
            )
            ->joinInner(
                array('sh' => 'submission_history',),
                'sh.created_by = u.id'
            )
            ->joinInner(
                array('ss' => 'submission_status',),
                'ss.submission_status_id = sh.submission_status_id',
                array('ss.submission_status_name')
            )
            ->where('sh.submission_id = ?', $submissionId)
            ->query();

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return $results;
        }
        return null;


    }

    public function getSubmissionComment($submissionId)
    {
        $submissionCommentModel = new Model_SubmissionComment();
        $query = $submissionCommentModel->getAdapter()->select()
            ->from(array('u' => AUTH_MYSQL_DATABASE.'.users'),
            array(
                'u.role'
            )
        )
            ->joinInner(
            array('sc' => 'submission_comment',),
            'sc.created_by = u.id'
        )
            ->where('sc.submission_id = ?', $submissionId)
            ->query();

        $results = $query->fetchAll();
        if ( count($results) )
        {
            return $results;
        }
        return null;
    }

}