<?php

namespace Bl2\Util;

use Bl2\Exception\UnauthorizedException;

class HmacHashCalculator {

    private $entityManager;

    private $url;

//    private $data;

    private $microTime;

    private $sessionToken;

    private $sentHmacHash;

    function __construct() {
        $this->entityManager = EntityManagerFactory::getEntityManager();
        $this->url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    private function initCustomHeaders() {
        // TODO check microTime, sessionToken and sentHmacHash to not be empty
        if (!isset($_SERVER["HTTP_X_MICRO_TIME"])) {
            throw new UnauthorizedException("HTTP_X_MICRO_TIME must be set.");
        }
        $this->microTime = $_SERVER["HTTP_X_MICRO_TIME"];

        if (!isset($_SERVER["HTTP_X_SESSION_TOKEN"])) {
            throw new UnauthorizedException("HTTP_X_SESSION_TOKEN must be set.");
        }
        $this->sessionToken = $_SERVER["HTTP_X_SESSION_TOKEN"];

        if (!isset($_SERVER["HTTP_X_HMAC_HASH"])) {
            throw new UnauthorizedException("HTTP_X_HMAC_HASH must be set.");
        }
        $this->sentHmacHash = $_SERVER["HTTP_X_HMAC_HASH"];
    }

    private function calculateHmacHash($data, $secret) {
        $this->initCustomHeaders();
        $jsonData = isset($data) ? json_encode($data) : "";
        return hash_hmac("sha512", $this->url . ":" . $jsonData . ":" . $this->microTime, $secret);
    }

    /**
     * Checks the HMAC hash for the current HTTP request.
     *
     * @param $data stdClass|array The deserialized request body
     *
     * @throws UnauthorizedException in case the HMAC hash is invalid.
     */
    public function checkHmacHash($data) {
        $this->initCustomHeaders();

        // check if SessionToken $this->sessionToken  exists
        $sessionToken = $this->entityManager->getRepository('Bl2\Model\SessionToken')->findOneBy(array('sessionToken' => $this->sessionToken));
        if (!$sessionToken) {
            throw new UnauthorizedException();
        }

        $secret = $sessionToken->getSecret();

        $generatedHmacHash = $this->calculateHmacHash($data, $secret);

        if ($generatedHmacHash != $this->sentHmacHash) {
            throw new UnauthorizedException();
        }
    }
}