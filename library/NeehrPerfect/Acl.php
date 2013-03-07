<?php

class NeehrPerfect_Acl extends Zend_Acl
{
	public function NeehrPerfect_Acl()
	{
		$this->addRole(new Zend_Acl_Role('guest'));
		$this->addRole(new Zend_Acl_Role('org_student'), 'guest');
		$this->addRole(new Zend_Acl_Role('org_faculty'), array('guest', 'org_student'));
		$this->addRole(new Zend_Acl_Role('org_admin'), array('guest', 'org_student', 'org_faculty'));
		$this->addRole(new Zend_Acl_Role('ai_admin'), array('guest', 'org_student', 'org_faculty', 'org_admin'));

		$this->addResource(new Zend_Acl_Resource('activity'));
        $this->addResource(new Zend_Acl_Resource('activityasync'));
        $this->addResource(new Zend_Acl_Resource('admasync'));
        $this->addResource(new Zend_Acl_Resource('aptasync'));
        $this->addResource(new Zend_Acl_Resource('auth'));
		$this->addResource(new Zend_Acl_Resource('error'));
		$this->addResource(new Zend_Acl_Resource('index'));
		$this->addResource(new Zend_Acl_Resource('patients'));
        $this->addResource(new Zend_Acl_Resource('preferencesasync'));
        $this->addResource(new Zend_Acl_Resource('regasync'));
        $this->addResource(new Zend_Acl_Resource('reviewasync'));
        $this->addResource(new Zend_Acl_Resource('submitasync'));
		$this->addResource(new Zend_Acl_Resource('calendar'));
        $this->addResource(new Zend_Acl_Resource('userasync'));
        $this->addResource(new Zend_Acl_Resource('signasync'));
        $this->addResource(new Zend_Acl_Resource('diagcodesasync'));
        $this->addResource(new Zend_Acl_Resource('proccodesasync'));
        $this->addResource(new Zend_Acl_Resource('opsbasync'));
        $this->addResource(new Zend_Acl_Resource('modifiersasync'));
        $this->addResource(new Zend_Acl_Resource('opclasync'));
        $this->addResource(new Zend_Acl_Resource('accitemasync'));

		// Define "guest" access
		$this->allow('guest', 'auth', null);

		// Define "org_faculty" access
        $this->allow('org_faculty', 'activity', null);
        $this->allow('org_faculty', 'activityasync', null);
        $this->allow('org_faculty', 'admasync', null);
        $this->allow('org_faculty', 'aptasync', null);
		$this->allow('org_faculty', 'auth', null);
		$this->allow('org_faculty', 'error', null);
		$this->allow('org_faculty', 'index', null);
		$this->allow('org_faculty', 'patients', null);
        $this->allow('org_faculty', 'preferencesasync', null);
        $this->allow('org_faculty', 'regasync', null);
        $this->allow('org_faculty', 'reviewasync', null);
        $this->allow('org_faculty', 'submitasync', null);
		$this->allow('org_faculty', 'calendar', null);
        $this->allow('org_faculty', 'userasync', null);
        $this->allow('org_faculty', 'signasync', null);
        $this->allow('org_faculty', 'diagcodesasync', null);
        $this->allow('org_faculty', 'proccodesasync', null);
        $this->allow('org_faculty', 'opsbasync', null);
        $this->allow('org_faculty', 'modifiersasync', null);
        $this->allow('org_faculty', 'opclasync', null);
        $this->allow('org_faculty', 'accitemasync', null);

        // Define "org_student" access
        $this->allow('org_student', 'activity', null);
        $this->allow('org_student', 'activityasync', null);
        $this->allow('org_student', 'admasync', null);
        $this->allow('org_student', 'aptasync', null);
        $this->allow('org_student', 'auth', null);
        $this->allow('org_student', 'error', null);
        $this->allow('org_student', 'index', null);
        $this->allow('org_student', 'patients', null);
        $this->allow('org_student', 'preferencesasync', null);
        $this->allow('org_student', 'regasync', null);
        $this->allow('org_student', 'reviewasync', null);
        $this->allow('org_student', 'submitasync', null);
		$this->allow('org_student', 'calendar', null);
        $this->allow('org_student', 'userasync', null);
        $this->allow('org_student', 'signasync', null);
        $this->allow('org_student', 'diagcodesasync', null);
        $this->allow('org_student', 'proccodesasync', null);
        $this->allow('org_student', 'opsbasync', null);
        $this->allow('org_student', 'modifiersasync', null);
        $this->allow('org_student', 'opclasync', null);
        $this->allow('org_student', 'accitemasync', null);


	}
}