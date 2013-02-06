<?php

namespace Kuba\UserBundle\Form\Model;

class Registration
{
    public $username;

    public $password;
    
    public $email;

    public function __construct(){
    }
    
    public function isPasswordMatchingUsername()
    {
        return ($this->username === $this->password);
    }
}