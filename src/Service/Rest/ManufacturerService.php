<?php

namespace Bl2\Service\Rest;

use Bl2\Model\Manufacturer;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link Manufacturer} entity.
 * @package Bl2\Service\Rest
 */
class ManufacturerService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all manufacturers.
     * @url /manufacturers/
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
     * Gets the manufacturer with the given id.
     * @url /manufacturers/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return Manufacturer
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Creates a new manufacturer.
     * @url /manufacturers/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request the HTTP request.
     * @param Response $response the HTTP response.
     *
     * @return Manufacturer the created manufacturer
     */
    public function add(Request $request, Response $response) {
        // cast stdClass to array
        $properties = (array)$request->data;
        return $this->create($request, $response, new Manufacturer($properties));
    }

    /**
     * Updates the manufacturer with the given id
     * @url /manufacturers/:id/
     * @verbs PUT
     * @auth admin
     *
     * @param Request $request the HTTP request
     *
     * @return Manufacturer the updated manufacturer
     */
    public function update(Request $request) {
        $id = $request->params['id'];
        return $this->save($request, $id);
    }

    /**
     * Removes the manufacturer with the given id.
     * @url /manufacturers/:id/
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
     * @url /manufacturers(/:id)/
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
        return Manufacturer::entityName();
    }
}
