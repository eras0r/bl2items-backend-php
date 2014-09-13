<?php

namespace Bl2\Controller;

/**
 * Controller class for performing login to the system.
 */
class LoginController {

    private $entityManager;

    function __construct() {
        $this->entityManager = EntityManagerFactory::getEntityManager();
    }

    /**
     * Checks if the HTTP body contains all required parameters.
     *
     * @param $requestBody the HTTP request body
     *
     * @throws BadRequestException exception being thrown in case at least one parameter is missing.
     */
    public function checkRequestParameters($requestBody) {
        if (!property_exists($requestBody, "username")) {
            throw new BadRequestException("username");
        }

        if (!property_exists($requestBody, "password")) {
            throw new BadRequestException("password");
        }
    }

    /**
     * Checks if the username is a valid user within the user database.
     *
     * @param $username the username to be checked
     * @param $password the users password
     *
     * @return User the user within the database.
     * @throws UnauthorizedException in case the username or password was invalid
     */
    public function checkUser($username, $password) {
        $user = $this->entityManager->getRepository('User')->findOneBy(array('username' => $username));

        if ($user != null) {
            $passwordUtil = new PasswordUtil();

            $hashedPassword = new HashedPassword($user->getAlgorithm(), $user->getIterations(), $user->getSalt(),
                $user->getPassword());

            // validate password
            if ($passwordUtil->validatePassword($password, $hashedPassword)) {
                return $user;
            }
        }

        // user does not exist or wrong password
        throw new UnauthorizedException();
    }

    /**
     * Generates the initial secret.
     *
     * @param string $username the username
     * @param string $password the password
     *
     * @return string the initial secret
     */
    public function generateInitialUserSecret($username, $password) {
        return hash(SECRET_HASH_ALGORITHM, $username . ":" . $password);
    }

    /**
     * Generates an actual session token
     *
     * @param $secret the secret to be used
     *
     * @return string the generated session token
     */
    public function generateToken($secret) {
        $bytes = openssl_random_pseudo_bytes(TOKEN_BYTE_SIZE);
        $token = bin2hex($bytes);
        return hash(SECRET_HASH_ALGORITHM, $secret . ":" . $token);
    }

    /**
     * Creates and saves a session token for the given user
     *
     * @param User $user the user
     * @param string $password the user's password (in plain text)
     *
     * @return SessionToken the creates session token
     */
    public function createAndSaveSessionToken($user, $password) {
        $sessionToken = new SessionToken();
        $sessionToken->setUser($user);

        $initialSecret = $this->generateInitialUserSecret($user->getUsername(), $password);
        $sessionToken->setSessionToken($this->generateToken($initialSecret));

        $secret = hash(SECRET_HASH_ALGORITHM, $initialSecret . ":" . $sessionToken->getSessionToken());
        $sessionToken->setSecret($secret);

        $this->entityManager->persist($sessionToken);
        $this->entityManager->flush();

        return $sessionToken;
    }
}