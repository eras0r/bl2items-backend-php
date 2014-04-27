<?php

require_once 'AbstractEntity.php';

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity
 * @ORM\Table(name="manufacturer", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"})})
 **/
class Manufacturer extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * Creates a new manufacturer by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the manufacturer.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * Gets the name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name the name to be set.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        $errors = array();
        if (empty($this->name)) {
            $errors["name"] = "Name is required";
        }
        return $errors;
    }
}

?>
