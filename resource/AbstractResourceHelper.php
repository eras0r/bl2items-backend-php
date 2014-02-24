<?php

/**
 * Abstract resource helper, which is responsible for creating and validating entity objects.
 * There is a concrete implementation for each entity of this class.
 */
abstract class AbstractResourceHelper {

    /**
     * Gets the entity name for the ORM mapper on which theis resource is based on.
     * @return string the entity name which belongs to this repository.
     */
    public abstract function getEntityName();

    /**
     * Validates the given entity.
     * @param $entity associative array containing the entity object to be validated
     * @return array associative array containing validation errors (if any).
     */
    public abstract function validate($entity);

    /**
     *
     * Creates a instance of the entity on which this repository is based
     * @param array $properties array holding the property values for the entity instance to be created.
     * @return AbstractEntity a new entity object
     */
    public abstract function createNewEntityInstance(array $properties);

}
