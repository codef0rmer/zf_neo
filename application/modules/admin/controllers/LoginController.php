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

                $password = $adminLoginForm->createElement('text', 'password');
                $password->setRequired('true');
                $password->addErrorMessage('Please enter valid password');
                $adminLoginForm->addElement($password);
                $this->view->password = $password;

                $submit = $adminLoginForm->createElement('submit', 'Submit');
                $this->view->submit = $submit;

                if ($this->_request->isPost()) {
        			if ($adminLoginForm->isValid($_POST)) {
                        $adminUserModel = new Admin_Model_User();
                        $userExists = $adminUserModel->userExists(
                            $adminLoginForm->getValue('username'),
                            $adminLoginForm->getValue('password')
                        );
        				if ($userExists == true) {
                            $_SESSION['username'] = $adminLoginForm->getValue('username');
                            $this->_redirect('/admin/index/index');
                        }

        			}
        		}
    }

    public function logoutAction()
    {
        $_SESSION['username'] = '';
        $this->_redirect('/admin/login/index');

    }


}



