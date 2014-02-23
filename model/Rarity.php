<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="d_rarity", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"}), @UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
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

    // constructor used for JSON
    public function __construct(array $data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function getSortOrder() {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

}

?>
