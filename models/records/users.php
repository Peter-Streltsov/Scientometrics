<?php

namespace Scientometrics\Models\Records;

use Scientometrics\Models\Records as Records;

class Users extends Records\BaseModel
{
    private $email;
    private $password;
    private $status;
    private $author_alias;
    private $added;
    private $data;


    /**
     * Undocumented function
     *
     * @return void
     */
    public function list()
    {
        return $this;
    }


    /**
     * saving new user data
     *
     * @return void
     */
    public function save()
    {
        $this->fluent->insertInto('users')->values($this->name, $this->password, $this->author_alias);
    }

    /** SETTERS */

    /**
     * setter - user's email
     *
     * @param [string] $email
     * @return object
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    } // end function


    /**
     * setter - user's password
     *
     * @param [type] $password
     * @return object
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    } // end function


    /**
     * setter - user's alias (key) for 'authors'
     *
     * @param [integer] $alias
     * @return object
     */
    public function setAuthorAlias($alias)
    {
        $this->author_alias = $alias;
        return $this;
    }

    
    /**
     * setter - date user added
     *
     * @return object
     */
    public function setAdded()
    {
        $this->added = date('Y-m-d');
        return $this;
    }

    /** GETTERS */

    /**
     * getter - userdata
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
