<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="damage_type", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"})})
 **/
class DamageType extends AbstractEntity {

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
     * @Column(type="integer")
     * @var int
     **/
    protected $sortOrder;

    /**
     * Creates a new damage type by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the damage type.
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
     *
     * @param string $name the name to be set.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the sort order
     * @return int the sort order
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Sets the sort order.
     *
     * @param int $sortOrder the sort order to be set.
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }
}

?>
