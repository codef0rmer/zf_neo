<?php

class Admin_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $adminLoginForm = new Admin_Form_Login();

        $username = $adminLoginForm->createElement('text', 'username');
        $username->setRequired('true');
        $username->addErrorMessage('Please enter valid username');
        $adminLoginForm->addElement($username);
        $this->view->username = $username;

        $password = $adminLoginForm->createElement('password', 'password');
        $password->setRequired('true');
        $password->addErrorMessage('Please enter valid password');
        $adminLoginForm->addElement($password);
        $this->view->password = $password;

        $submit = $adminLoginForm->createElement('submit', 'Submit');
        $this->view->submit = $submit;

        if ($this->_request->isPost() && $adminLoginForm->isValid($_POST)) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
            $authAdapter->setIdentity($adminLoginForm->getValue('username'));
            $authAdapter->setCredential(md5($adminLoginForm->getValue('password')));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $auth->getStorage()->write($authAdapter->getResultRowObject(array('username', 'role')));
                $this->_redirect('/admin/index/index');
            }
        }
    }

    public function logoutAction()
    {
        $authAdapter = Zend_Auth::getInstance();
        $authAdapter->clearIdentity();
        $this->_redirect('/admin/login/index');
    }


}



