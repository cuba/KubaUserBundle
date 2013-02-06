<?php

namespace Kuba\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Kuba\UserBundle\Utilities\TextUtilities;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Kuba\UserBundle\Entity\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", name="username_canonical", length=25, unique=true)
     */
    private $usernameCanonical;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="email_canonical", length=60, unique=true)
     */
    private $emailCanonical;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->disable();
        $this->generateSalt();
    }
    
    public function setUsername($username){
        $this->username = $username;
        $this->setUsernameCanonical(TextUtilities::canonicalize($username));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    public function setUsernameCanonical($usernameCanonical){
        $this->usernameCanonical = $usernameCanonical;
    }

    /**
     * @inheritDoc
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }
    
    public function generateSalt(){
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    public function setPassword($password){
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    
    
    public function setEmail($email){
        $this->email = $email;
        $this->setEmailCanonical(TextUtilities::canonicalize($email));
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmailCanonical($emailCanonical){
        $this->emailCanonical = $emailCanonical;
    }

    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        //$this->password = null;
        //$this->salt = null;
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
    
    public function setEnabled($enabled = true){
        $this->isActive = $enabled;
    }
    
    public function enable()
    {
        $this->setEnabled(true);
    }
    
    public function disable()
    {
        $this->setEnabled(false);
    }
}