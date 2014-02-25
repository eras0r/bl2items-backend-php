<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="rarity", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"}), @UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
 **/
class Rarity extends AbstractEntity {

    /**
     * @Id @Column(type="bigint") @GeneratedValue
     * @var int
     **/
    protected $id;

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
     * @param array $data associative array holding the properties for the rarity.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * Gets the id.
     * @return int the id
     */
    public function getId() {
        return $this->id;
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
     * @param $color the color to be set
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
     * @param $sortOrder the sort order to be set.
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

}

?>