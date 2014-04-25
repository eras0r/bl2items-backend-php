<?php

/**
 * Abstract super class for all entities.
 */
abstract class AbstractEntity {

    /**
     * @Id @Column(type="bigint") @GeneratedValue
     * @var int
     **/
    protected $id;

    // constructor used for JSON
    protected function __construct(array $data) {
        foreach ($data as $key => $val) {
            if (property_exists(get_class($this), $key) && $key != "id") {
                $this->$key = $val;
            }
        }
    }

    /**
     * Gets the id.
     * @return int the id
     */
    public function getId() {
        return $this->id;
    }

    /*
     * Gets the JSON representation of this entity
     * TODO try using http://jmsyst.com/libs/serializer#documentation instead
     * TODO add         "jms/serializer-bundle": "dev-master" to composer.json
     */
    public function getJson() {
        return get_object_vars($this);
    }

    /**
     * Gets the entity name for this entity. This is useful for the doctrine entity manager which will use the entity name.
     */
    public static function getEntityName() {
        return get_called_class();
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public abstract function validate();
}