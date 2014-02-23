<?php

require_once 'AbstractEntity.php';

/**
 * @Entity @Table(name="manufacturer", uniqueConstraints={@UniqueConstraint(name="unique_name", columns={"name"})})
 **/
class Manufacturer extends AbstractEntity {

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

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

?>
