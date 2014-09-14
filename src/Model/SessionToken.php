<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a session token (which means an active session for an existing user).
 * @ORM\Entity
 * @ORM\Table(name="session_token")
 */
class SessionToken extends AbstractEntity implements \JsonSerializable {

    /**
     * @ORM\Column(type="string", length=128)
     * @Serializer\SerializedName("sessionToken")
     * @var string
     **/
    protected $sessionToken;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     * @var User
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=128)
     * @var string
     **/
    protected $secret;

    /**
     * Creates a new SessionToken by initializing is properties by using the values given in the associative array.
     *
     * @param array $data associative array holding the properties for the SessionToken.
     */
    public function __construct(array $data = array()) {
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getSessionToken() {
        return $this->sessionToken;
    }

    /**
     * @param string $sessionToken
     */
    public function setSessionToken($sessionToken) {
        $this->sessionToken = $sessionToken;
    }

    /**
     * @return \User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret) {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getSecret() {
        return $this->secret;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        // validate super class
        $errors = array();

        if (empty($this->sessionToken)) {
            $errors["sessionToken"] = "SessionToken is required";
        }
        if ($this->user == null) {
            $errors["user"] = "User is required";
        }

        return $errors;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize() {
        return [
            'sessionToken' => $this->sessionToken
        ];
    }
}