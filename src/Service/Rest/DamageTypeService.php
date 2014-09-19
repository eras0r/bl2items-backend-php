<?php

namespace Bl2\Service\Rest;

use Bl2\Model\DamageType;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link DamageType} entity.
 * @package Bl2\Service\Rest
 */
class DamageTypeService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all damage types.
     * @url /damage-types/
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
     * Gets the damage type with the given id.
     * @url /damage-types/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return DamageType
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new damage type.
     * @url /damage-types/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return DamageType the created damage type
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;
        return $this->create($request, $response, new DamageType($properties));
    }

    /**
     * Updates the damage type with the given id
     * @url /damage-types/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return DamageType the updated damage type
     */
    public function update(Request $request) {
        $id = $request->params['id'];
        return $this->save($request, $id);
    }

    /**
     * Removes the damage type with the given id.
     * @url /damage-types/:id/
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
     * @url /damage-types(/:id)/
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
        return DamageType::entityName();
    }
}
