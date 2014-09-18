<?php

namespace Bl2\Util;

use Bl2\Exception\UnauthorizedException;
use Slim\Http\Request;

class HmacHashCalculator {

    private $entityManager;

    /**
     * the http request
     * @var Request
     */
    private $request;

    private $microTime;

    private $sessionToken;

    /**
     * @var string the HMAC hash sent by the client. This value will be compared with the calculated value from the
     * server.
     */
    private $sentHmacHash;

    function __construct($request) {
        $this->entityManager = EntityManagerFactory::getEntityManager();
        $this->request = $request;

        if ($this->request->headers("X_MICRO_TIME") == null) {
            throw new UnauthorizedException("X_MICRO_TIME header is not present.");
        }
        $this->microTime = $this->request->headers("X_MICRO_TIME");

        if ($this->request->headers("X_SESSION_TOKEN") == null) {
            throw new UnauthorizedException("X_SESSION_TOKEN header is not present.");
        }
        $this->sessionToken = $this->request->headers("X_SESSION_TOKEN");

        if ($this->request->headers("X_HMAC_HASH") == null) {
            throw new UnauthorizedException("X_HMAC_HASH is not present.");
        }
        $this->sentHmacHash = $this->request->headers("X_HMAC_HASH");
    }

    private function calculateHmacHash($data, $secret) {
        $jsonData = !empty($data) ? json_encode($data) : "";
        return hash_hmac("sha512", $this->getUrl() . ":" . $jsonData . ":" . $this->microTime, $secret);
    }

    /**
     * Extracts the url from the request.
     * @return string the complete url (including http:// or https:// and host part).
     */
    private function getUrl() {
        return $this->request->getUrl() . $this->request->getPath();
    }

    /**
     * Checks the HMAC hash for the current HTTP request.
     *
     * @param $data stdClass|array The deserialized request body
     *
     * @throws UnauthorizedException in case the HMAC hash is invalid.
     */
    public function checkHmacHash($data) {
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