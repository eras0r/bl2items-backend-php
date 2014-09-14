<?php

namespace Bl2\Model;

use Bl2\Exception\EntityObjectValidationException;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="rarity", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"}), @ORM\UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
 **/
class Rarity extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @ORM\Column(type="string", length=7)
     * @var string
     **/
    protected $color;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("sortOrder")
     * @var int
     **/
    protected $sortOrder;

    /**
     * Creates a new rarity by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the rarity.
     */
    public function __construct(array $data = array()) {
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
     * Gets the color.
     * @return string the color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Sets the color.
     *
     * @param $color string the color to be set
     */
    public function setColor($color) {
        $this->color = $color;
    }

    /**
     * Gets the sort order.
     * @return int the sort order
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Sets the sort order.
     *
     * @param $sortOrder int the sort order to be set.
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @throws \Bl2\Exception\EntityObjectValidationException in case of validation exceptions
     */
    public function validate() {
        $errors = array();
        if (empty($this->name)) {
            $errors["name"] = "Name is required";
        }
        if (empty($this->color)) {
            $errors["color"] = "Color is required";
        }
        if (empty($this->sortOrder)) {
            $errors["sortOrder"] = "Sort order is required";
        }

        if (!empty($errors)) {
            throw new EntityObjectValidationException($errors);
        }
    }
}
