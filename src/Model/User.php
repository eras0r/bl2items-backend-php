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
     * @Serializer\Exclude
     * @var string
     **/
    protected $algorithm;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Exclude
     * @var int
     **/
    protected $iterations;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Exclude
     * @var string
     **/
    protected $salt;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Exclude
     * @var string
     **/
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role", fetch="EAGER")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     **/
    protected $roles;

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
     * @param mixed $roles
     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->username)) {
            $this->addValidationError("username", "Username is required");
        }
        if (empty($this->password)) {
            $this->addValidationError("password", "Password is required");
        }
    }
}