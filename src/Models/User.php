<?php
/**
 * Created by PhpStorm.
 * User: kemal
 * Date: 08/10/2018
 * Time: 21:54
 */

namespace App\Models;

class User
{

    protected $id;
    protected $email;
    protected $password;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function __construct($id, $email )
    {
        $this->id = $id;
        $this->email = $email;
    }


}
