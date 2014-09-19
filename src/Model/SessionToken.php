<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a session token (which means an active session for an existing user).
 * @ORM\Entity
 * @ORM\Table(name="session_token")
 */
class SessionToken extends AbstractEntity {

    /**
     * @ORM\Column(type="string", length=128)
     * @Serializer\SerializedName("sessionToken")
     * @var string
     **/
    protected $sessionToken;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     * @Serializer\Exclude
     * @var User
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=128)
     * @Serializer\Exclude
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

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->sessionToken)) {
            $this->addValidationError("sessionToken", "SessionToken is required");
        }
        if ($this->user == null) {
            $this->addValidationError("user", "User is required");
        }
    }
}