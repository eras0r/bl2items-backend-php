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


    /**
     * Creates a new manufacturer by initializing is properties by using hte values given in the associative array.
     * @param array $data associative array holding the properties for the manufacturer.
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

}

?>
