<?php
/**
 * Created by PhpStorm.
 * User: eras0r
 * Date: 10/4/14
 * Time: 1:10 PM
 */

namespace Bl2\Dto;

use JMS\Serializer\Annotation as Serializer;

/**
 * DTO object representing a user which can be used to transmit to the client.
 * This object is used for example for the current session.
 * @package Bl2\Dto
 */
class UserDto {

    /**
     * @Serializer\SerializedName("sessionToken")
     * @var string the user's session token
     */
    private $sessionToken;

    /**
     * @var
     */
    private $username;

    /**
     * @var
     */
    private $roles;

    function __construct($sessionToken, $username) {
        $this->sessionToken = $sessionToken;
        $this->username = $username;
        $this->roles = array();
    }

    public function addRole($role) {
        $this->roles[] = $role;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * @param string $sessionToken
     */
    public function setSessionToken($sessionToken) {
        $this->sessionToken = $sessionToken;
    }

    /**
     * @return string
     */
    public function getSessionToken() {
        return $this->sessionToken;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }
}