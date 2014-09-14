<?php

namespace Bl2\Exception;

/**
 * Exception signaling a bad HTTP request.
 */
class BadRequestException extends \Exception {

    private $missingParameter;

    function __construct($missingParameter) {
        $this->missingParameter = $missingParameter;
    }

    /**
     * Gets the missing HTTP parameter name.
     * @return string the name of the missing HTTP parameter.
     */
    public function getMissingParameter() {
        return $this->missingParameter;
    }
}