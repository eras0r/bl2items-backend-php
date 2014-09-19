<?php

namespace Bl2\Service\Rest;

use Bl2\Model\AbstractEntity;
use Bl2\Model\User;
use Bl2\Service\AbstractRestService;
use Bl2\Util\PasswordUtil;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link User} entity.
 * @package Bl2\Service\Rest$
 */
class UserService extends AbstractRestService {

    /**
     * @var \Bl2\Util\PasswordUtil the password utility
     */
    private $passwordUtil;

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // TODO use dependency injection
        $this->passwordUtil = new PasswordUtil();
    }

    /**
     * Gets all users.
     * @url /users/
     * @verbs GET
     * @auth admin
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request) {
        return parent::getAll($request);
    }

    /**
     * Gets the user with the given id.
     * @url /users/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return AbstractEntity
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new user.
     * @url /users/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return AbstractEntity the created resource
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;

        $user = new User($properties);

        $salt = $this->passwordUtil->createRandomSalt();
        $hashedPassword = $this->passwordUtil->createHash($user->getPassword(), PBKDF2_HASH_ALGORITHM,
            PBKDF2_ITERATIONS, $salt);

        $user->setAlgorithm(PBKDF2_HASH_ALGORITHM);
        $user->setIterations(PBKDF2_ITERATIONS);
        $user->setSalt($salt);
        $user->setPassword($hashedPassword->getHash());

        return $this->create($request, $response, $user);
    }

    /**
     * Updates the user with the given id
     * @url /users/:id/
     * @verbs PUT
     *
     * @param Request $request the HTTP request
     *
     * @return AbstractEntity
     */
    public function update(Request $request) {
        $id = $request->params['id'];
        return $this->save($request, $id);
    }

    /**
     * Removes the user with the given id.
     * @url /users/:id/
     * @verbs DELETE
     *
     * @param Request $request the HTTP request
     * @param Response $response the HTTP response
     *
     * @return Response
     */
    public function remove(Request $request, Response $response) {
        return parent::remove($request, $response, $request->params['id']);
    }

    /**
     * HTTP OPTIONS request used for CORS.
     * @url /users(/:id)/
     * @verbs OPTIONS
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
        parent::options($request);
    }

    /**
     * Gets the name of the entity on which this service is based.
     * @return string the name of the entity on which this service is based.
     */
    protected function getEntityName() {
        return User::entityName();
    }
}
