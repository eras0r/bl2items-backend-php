<?php

namespace Bl2\Exception;

/**
 * Exception signaling the user has not been authorized and needs to login.
 */
class UnauthorizedException extends \Exception {

    function __construct() {
    }
}