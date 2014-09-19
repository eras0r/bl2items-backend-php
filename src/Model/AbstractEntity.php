<?php

namespace Bl2\Model;

use Bl2\Exception\EntityObjectValidationException;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

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
    /**
     * @var array holds the validation errors
     * @Serializer\Exclude
     */
    private $validationErrors = array();

    /**
     * Create a new entity object by using the given array to initialize the new objects properties.
     *
     * @param array $data array holding the new entity objects property (key = property name, value = property value)
     */
    protected function __construct(array $data = array()) {
        foreach ($data as $key => $val) {
            if (property_exists(get_class($this), $key) && $key != "id") {
                $this->$key = $val;
            }
        }
    }

    /**
     * Adds a validation error for this entity.
     *
     * @param string $propertyName the name of the property on which the validation error occurred.
     * @param string $message validation error message
     */
    protected function addValidationError($propertyName, $message) {
        $this->validationErrors[$propertyName] = $message;
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
     * Validates this entity by adding a validation error for each validation error which has occurred.
     * This method does the real validation logic and should be overridden by subclasses to implement validation
     * business logic.
     */
    protected function doValidation() {
        $this->validationErrors = array();
    }

    /**
     * Validates the entity and throws an EntityObjectValidationException in case of validation errors.
     * @throws EntityObjectValidationException in case of validation exceptions
     */
    public final function validate() {
        // call validation
        $this->doValidation();

        if (!empty($this->validationErrors)) {
            throw new EntityObjectValidationException($this->validationErrors);
        }
    }
}