<?php

namespace Bl2\Service\Rest;

use Bl2\Model\Character;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link Character} entity.
 * @package Bl2\Service\Rest
 */
class CharacterService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all characters.
     * @url /characters/
     * @verbs GET
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request) {
        return parent::getAll($request);
    }

    /**
     * Gets the character with the given id.
     * @url /characters/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return Character
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new character.
     * @url /characters/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return Character the created character
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;

        $character = new Character($properties);

        return $this->create($request, $response, $character);
    }

    /**
     * Updates the character with the given id
     * @url /characters/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return Character the updated character
     */
    public function update(Request $request) {
        $properties = (array)$request->data;

        $character = new Character($properties);

        return $this->save($character);
    }

    /**
     * Removes the character with the given id.
     * @url /characters/:id/
     * @verbs DELETE
     * @auth admin
     *
     * @param Request $request the HTTP request
     * @param Response $response the HTTP response
     *
     * @return string
     */
    public function remove(Request $request, Response $response) {
        return parent::remove($request, $response, $request->params['id']);
    }

    /**
     * HTTP OPTIONS request used for CORS.
     * @url /characters(/:id)/
     * @verbs OPTIONS
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
        parent::options($request);
    }

    /**
     * Gets skills for the character with the given id.
     * @url /characters/:id/skills/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return array
     */
    public function getSkills(Request $request) {
        $charcater =  parent::load($request, $request->params['id']);
        return $charcater->getSkills();
    }

    /**
     * Gets the name of the entity on which this service is based.
     * @return string the name of the entity on which this service is based.
     */
    protected function getEntityName() {
        return Character::entityName();
    }
}
