<?php

namespace Anax\User;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
    * @var string $tableName name of the database table.
    */
    protected $tableName = "ramverk1ProjUsers";

    /**
    * Columns in the table.
    *
    * @var integer $id primary key auto incremented.
    */
    public $id;
    public $username;
    public $mail;
    public $password;

        /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

        /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);

        return password_verify($password, $this->password);
    }

    public function valueExist($value, $getValue = false)
    {
        $allValues = $this->findAll();
        for ($i=0; $i < count($allValues); $i++) {
            if ($allValues[$i]->username == $value) {
                if ($getValue) {
                    return $allValues[$i];
                } else {
                    return true;
                }
            }
        }
        return false;
    }
}
