<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract super class for all entities.
 * @ORM\MappedSuperclass
 */
abstract class AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue
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

    /**
     * Gets the entity name for this entity. This is useful for the doctrine entity manager which will use the entity name.
     */
    public static function entityName() {
        return get_called_class();
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public abstract function validate();

//    /**
//     * @link according to http://stackoverflow.com/a/20268468 doctrine does not serialize referened objects, if they are lazy loaded and have not been loaded.
//     *
//     * This method provides a callback to load referenced entity objects which should be considered for JSON serialization.
//     * Overriding this methods allows implementing subclasses to load referenced objects to make sure those are considered when serializing complex objects trees to JSON.
//     * For each referenced object to be considered for serialization the getter has to be invoked.
//     */
//    public function loadReferencedObjects() {
//
//    }
}