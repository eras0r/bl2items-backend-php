<?php

namespace Bl2\Service\Rest;

use Bl2\Model\Shield;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link Shield} entity.
 * @package Bl2\Service\Rest
 */
class ShieldService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all shields.
     * @url /shields/
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
     * Gets the shield with the given id.
     * @url /shields/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return Shield
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new shield.
     * @url /shields/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return Shield the created shield
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;
        return $this->create($request, $response, new Shield($properties));
    }

    /**
     * Updates the shield with the given id
     * @url /shields/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return Shield the updated shield
     */
    public function update(Request $request) {
        $id = $request->params['id'];
        return $this->save($request, $id);
    }

    /**
     * Removes the shield with the given id.
     * @url /shields/:id/
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
     * @url /shields(/:id)/
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
        return Shield::entityName();
    }
}
