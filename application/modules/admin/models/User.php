<?php
class Admin_Model_User extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';

	/*public function userExists($username, $password)
	{
        $select = $this->select()
                       ->from('users', array('IF(COUNT(*) > 0, true, false)'))
                       ->where('username = ?', $username)
                       ->where('password = ?', md5($password));
        return $this->getAdapter()->fetchOne($select);
	}*/
}

