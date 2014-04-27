<?php

/**
 * Class containing entity object validation for an {@link AbstractEntity}.
 */
class EntityObjectValidationException extends Exception {

    private $validationErrors;

    function __construct($validationErrors) {
        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors() {
        return $this->validationErrors;
    }
}