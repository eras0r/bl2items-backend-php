<?php

namespace Bl2\Exception;

class UniqueKeyConstraintException extends \Exception {

    /**
     * @var array
     */
    private $constraintViolations;

    /**
     * @param array $constraintViolations
     */
    function __construct($constraintViolations) {
        $this->constraintViolations = $constraintViolations;
    }

    /**
     * Gets the violated constraints.
     * @return array an array holding all violated constraints
     */
    public function getConstraintViolations() {
        return $this->constraintViolations;
    }
}