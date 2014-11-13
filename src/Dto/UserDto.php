<?php
/**
 * Created by PhpStorm.
 * User: eras0r
 * Date: 10/4/14
 * Time: 1:10 PM
 */

namespace Bl2\Dto;

/**
 * DTO object representing a user which can be used to transmit to the client.
 * This object is used for example for the current session.
 * @package Bl2\Dto
 */
class UserDto {

    /**
     * @var
     */
    private $username;

    /**
     * @var
     */
    private $roles;

    function __construct($username) {
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