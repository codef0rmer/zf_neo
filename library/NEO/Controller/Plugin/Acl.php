<?php
class NEO_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = new Zend_Acl();

        /* define Roles */
        $guestRole = new Zend_Acl_Role('guest');
        $userRole = new Zend_Acl_Role('user');
	$acl->addRole($guestRole)
   	    ->addRole($userRole, 'guest');

        /* define Resources i.e. modules, controllers, etc. */
	$acl->add(new Zend_Acl_Resource('login'))
  	    ->add(new Zend_Acl_Resource('admin'))
	    ->add(new Zend_Acl_Resource('default'));

        /* define Permissions i.e. allow/deny access to modules, controllers, etc. */
        $acl->allow('guest', 'default')           // allow guest user to access default module and its controllers
   	    ->deny('guest', 'admin')              // deny guest user to access admin module and its controllers
	    ->allow('user', 'admin');             // allow authenticated user to access admin module and its controllers

        $module = $request->module;
        $controller = $request->controller;
	$action = $request->action;
        $auth = Zend_Auth::getInstance();
	if ($auth->hasIdentity()) {
	    $identity = $auth->getIdentity();
	    $role = strtolower($identity->role);
            if ($role == 'user' && $module == 'admin' && $controller == 'login' && $action == 'index') {
                $request->setModuleName('admin');
                $request->setControllerName('index');
		$request->setActionName('index');
	    }
	} else {
	    $role = 'guest';
	}

	if ($acl->isAllowed($role, $module, $controller, $action) === false) {
	  $request->setModuleName('admin');
	  $request->setControllerName('login');
	  $request->setActionName('index');
	}
    }
}
