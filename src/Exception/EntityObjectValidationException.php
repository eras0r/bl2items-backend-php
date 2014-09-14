<?php

namespace Bl2\Exception;

/**
 * Class containing entity object validation for an {@link AbstractEntity}.
 */
class EntityObjectValidationException extends \Exception {

    /**
     * @var array
     */
    private $validationErrors;

    /**
     * @param array $validationErrors
     */
    function __construct($validationErrors) {
        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors() {
        return $this->validationErrors;
    }
}