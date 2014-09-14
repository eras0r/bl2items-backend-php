<?php

namespace Bl2\Exception;

/**
 * Exception signaling that the requested resource was not found.
 */
class NotFoundException extends \Exception {

    function __construct($message) {
        parent::__construct($message);
    }
}