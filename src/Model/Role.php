<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a role.
 * @ORM\Entity
 * @ORM\Table(name="role", uniqueConstraints={@ORM\UniqueConstraint(name="unique_rolename", columns={"rolename"})})
 */
class Role extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $rolename;

    /**
     * Creates a new role by initializing its properties with the values given by the array.
     *
     * @param array $data array holding the properties for the new role.
     */
    public function __construct(array $data = array()) {
        parent::__construct($data);
    }

    /**
     * @param string $rolename
     */
    public function setRolename($rolename) {
        $this->rolename = $rolename;
    }

    /**
     * @return string
     */
    public function getRolename() {
        return $this->rolename;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        // TODO validation
    }
}