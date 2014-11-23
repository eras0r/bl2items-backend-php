<?php

namespace Bl2\Service\Rest;

use Bl2\Model\Rarity;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link Rarity} entity.
 * @package Bl2\Service\Rest
 */
class RarityService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all rarities.
     * @url /rarities/
     * @verbs GET
     * @auth user
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request) {
        return parent::getAll($request);
    }

    /**
     * Gets the rarity with the given id.
     * @url /rarities/:id/
     * @verbs GET
     * @auth user
     *
     * @param Request $request the HTTP request
     *
     * @return Rarity
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new rarity.
     * @url /rarities/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return Rarity the created rarity
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;
        return $this->create($request, $response, new Rarity($properties));
    }

    /**
     * Updates the rarity with the given id
     * @url /rarities/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return Rarity the updated rarity
     */
    public function update(Request $request) {
        $properties = (array)$request->data;
        return $this->save(new Rarity($properties));
    }

    /**
     * Removes the rarity with the given id.
     * @url /rarities/:id/
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
     * @url /rarities(/:id)/
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
        return Rarity::entityName();
    }
}
