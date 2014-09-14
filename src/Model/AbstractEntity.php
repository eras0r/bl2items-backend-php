<?php

namespace Bl2\Model;

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
     * @throws \Bl2\Exception\EntityObjectValidationException in case of validation exceptions
     */
    public abstract function validate();
}