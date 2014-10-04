<?php

namespace Bl2\Util;

use Bl2\Exception\UnauthorizedException;
use Bl2\Model\User;
use Slim\Http\Request;

class HmacHashCalculator {

    const HEADER_MICRO_TIME = "X_MICRO_TIME";

    const HEADER_SESSION_TOKEN = "X_SESSION_TOKEN";

    const HEADER_HMAC_HASH = "X_HMAC_HASH";

    /**
     * @var \Doctrine\ORM\EntityManager the entity manager.
     */
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

        if ($this->request->headers(self::HEADER_MICRO_TIME) == null) {
            throw new UnauthorizedException(self::HEADER_MICRO_TIME . " header is not present.");
        }
        $this->microTime = $this->request->headers(self::HEADER_MICRO_TIME);

        if ($this->request->headers(self::HEADER_SESSION_TOKEN) == null) {
            throw new UnauthorizedException(self::HEADER_SESSION_TOKEN . " header is not present.");
        }
        $this->sessionToken = $this->request->headers(self::HEADER_SESSION_TOKEN);

        if ($this->request->headers(self::HEADER_HMAC_HASH) == null) {
            throw new UnauthorizedException(self::HEADER_HMAC_HASH . " is not present.");
        }
        $this->sentHmacHash = $this->request->headers(self::HEADER_HMAC_HASH);
    }

    private function calculateHmacHash($data, $secret) {
        $jsonData = !empty($data) ? json_encode($data, JSON_UNESCAPED_SLASHES) : "";
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
     * Checks the HMAC hash for the current HTTP request and return the currently logged in user on success.
     * @return User the logged in user
     * @throws \Bl2\Exception\UnauthorizedException in case the sent HMAC hash value is incorrect.
     */
    public function checkHmacHash() {
        // check if SessionToken $this->sessionToken  exists
        $sessionToken = $this->entityManager->getRepository('Bl2\Model\SessionToken')->findOneBy(array('sessionToken' => $this->sessionToken));
        if (!$sessionToken) {
            throw new UnauthorizedException();
        }

        $secret = $sessionToken->getSecret();

        $data = $this->request->getBody();

        // consider uploaded file metadata for hash calulation
        foreach ($_FILES as $fileName => $file) {
            $data[$fileName]["name"] = $file["name"];
            $data[$fileName]["type"] = $file["type"];
            $data[$fileName]["size"] = $file["size"];
        }

        $generatedHmacHash = $this->calculateHmacHash($data, $secret);

        if ($generatedHmacHash != $this->sentHmacHash) {
            throw new UnauthorizedException();
        }

        return $sessionToken->getUser();
    }
}