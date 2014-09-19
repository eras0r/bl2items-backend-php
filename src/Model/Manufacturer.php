<?php

namespace Bl2\Model;

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

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->name)) {
            $this->addValidationError("name", "Name is required");
        }
    }
}
