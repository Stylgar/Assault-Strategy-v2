<?php

namespace W4f\GameBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provides information about the user.
 * 
 * Used both for a subscription and to return information about a user.
 * 
 * @ORM\Entity
 * @ORM\Table(name="account")
 * 
 * Note: to regenerate the entities, go to api folder and launch
 * ==> php app/console doctrine:generate:entities W4fGameBundle --no-backup
 * 
 * Then to update database: php app/console doctrine:schema:update --force
 */
class UserInfo {
    
    /**
     * The user id
     * @var integer 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * The user login
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $login;
    
    /**
     * The user's email
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $email;
    
    /**
     * The user's password. Only filled in in case of creation of login attempt.
     * Password should never been retrieved from database.
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return UserInfo
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserInfo
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return UserInfo
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
