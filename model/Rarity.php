<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="rarity", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"}), @UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
 **/
class Rarity extends AbstractEntity {

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @Column(type="string", length=7)
     * @var string
     **/
    protected $color;

    /**
     * @Column(type="integer")
     * @var int
     **/
    protected $sortOrder;

    /**
     * Creates a new rarity by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the rarity.
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
     * @return array associative array containing validation errors (if any).
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
        return $errors;
    }
}

?>
