<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initAutoload()
	{
        Zend_Session::start();
    }

}

