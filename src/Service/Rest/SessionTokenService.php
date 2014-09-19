<?php

namespace Bl2\Service\Rest;

use Bl2\Exception\BadRequestException;
use Bl2\Exception\UnauthorizedException;
use Bl2\Model\SessionToken;
use Bl2\Model\User;
use Bl2\Util\EntityManagerFactory;
use Bl2\Util\HashedPassword;
use Bl2\Util\PasswordUtil;
use Doctrine\ORM\EntityManager;
use Spore\ReST\Model\Request;

/**
 * /**
 * REST Service providing operations on the {@link SessionToken} entity.
 * @package Bl2\Service\Rest
 */
class SessionTokenService {

    /**
     * Doctrine ORM entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct() {
        $this->entityManager = EntityManagerFactory::getEntityManager();
    }

    /**
     * Does a login
     * @url /sessions/
     * @verbs POST
     *
     * @param Request $request
     *
     * @throws \Bl2\Exception\UnauthorizedException
     * @throws \Exception
     * @throws \Bl2\Exception\BadRequestException
     * @throws \Exception
     * @return array
     */
    public function login(Request $request) {
        try {
            // check HTTP request body parameters
            $this->checkRequestParameters($request->data);
            // get username from json body
            $username = $request->data->username;
            $password = $request->data->password;

            $user = $this->checkUser($username, $password);

            // create and save a new SessionToken and return it
            $sessionToken = $this->createAndSaveSessionToken($user, $password);
            return $sessionToken;
        } catch (BadRequestException $e) {
            // TODO proper error handling by using HTTP 403
            throw $e;
        } catch (UnauthorizedException $e) {
            // TODO proper error handling by using HTTP 403
            throw $e;
        }
    }

    /**
     * Does a logout
     * @url /sessions/:sessionToken
     * @verbs DELETE
     *
     * @param Request $request
     *
     * @throws \Bl2\Exception\UnauthorizedException
     * @throws \Exception
     * @throws \Bl2\Exception\BadRequestException
     * @throws \Exception
     * @return string
     */
    public function logout(Request $request) {
        try {
            $sessionTokenId = $request->params['sessionToken'];

            // check if SessionToken $this->sessionToken  exists
            $sessionToken = $this->entityManager->getRepository('Bl2\Model\SessionToken')->findOneBy(array('sessionToken' => $sessionTokenId));
            if (!$sessionToken) {
                throw new UnauthorizedException();
            }
            // delete $sessionToken
            $this->entityManager->remove($sessionToken);
            $this->entityManager->flush();

            return "Logout successful";
        } catch (BadRequestException $e) {
            // TODO proper error handling by using HTTP 403
            throw $e;
        } catch (UnauthorizedException $e) {
            // TODO proper error handling by using HTTP 403
            throw $e;
        }
    }

    /**
     * Used for CORS
     * @url /sessions(/:sessionToken)/
     * @verbs OPTIONS
     */
    public function options(Request $request) {
    }

    /**
     * Checks if the HTTP body contains all required parameters.
     *
     * @param $requestBody array the HTTP request body
     *
     * @throws BadRequestException exception being thrown in case at least one parameter is missing.
     */
    private function checkRequestParameters($requestBody) {
        if (!property_exists($requestBody, "username") || empty($requestBody->username)) {
            throw new BadRequestException("username");
        }

        if (!property_exists($requestBody, "password") || empty($requestBody->password)) {
            throw new BadRequestException("password");
        }
    }

    /**
     * Checks if the username is a valid user within the user database.
     *
     * @param $username string the username to be checked
     * @param $password string the users password
     *
     * @return User the user within the database.
     * @throws UnauthorizedException in case the username or password was invalid
     */
    private function checkUser($username, $password) {
        $user = $this->entityManager->getRepository('Bl2\Model\User')->findOneBy(array('username' => $username));

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
    private function generateInitialUserSecret($username, $password) {
        return hash(SECRET_HASH_ALGORITHM, $username . ":" . $password);
    }

    /**
     * Generates an actual session token
     *
     * @param $secret string the secret to be used
     *
     * @return string the generated session token
     */
    private function generateToken($secret) {
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
    private function createAndSaveSessionToken($user, $password) {
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
