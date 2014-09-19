<?php

namespace Bl2\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a user.
 * @ORM\Entity
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="unique_username", columns={"username"})})
 */
class User extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $username;

    /**
     * @ORM\Column(type="string", length=16)
     * @var string
     **/
    protected $algorithm;

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected $iterations;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $salt;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     **/
    private $roles;

    /**
     * Creates a new user by initializing its properties with the values given by the array.
     *
     * @param array $data array holding the properties for the new user.
     */
    public function __construct(array $data) {
        parent::__construct($data);
        if ($this->roles == null) {
            $this->roles = new ArrayCollection();
        }
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm) {
        $this->algorithm = $algorithm;
    }

    /**
     * @return string
     */
    public function getAlgorithm() {
        return $this->algorithm;
    }

    /**
     * @param int $iterations
     */
    public function setIterations($iterations) {
        $this->iterations = $iterations;
    }

    /**
     * @return int
     */
    public function getIterations() {
        return $this->iterations;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        // validate super class
        $errors = array();

        if (empty($this->username)) {
            $errors["username"] = "Username is required";
        }
        if (empty($this->password)) {
            $errors["password"] = "Password is required";
        }

        return $errors;
    }
}