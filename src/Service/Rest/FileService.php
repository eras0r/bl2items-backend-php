<?php

namespace Bl2\Service\Rest;

use Bl2\Model\File;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;

/**
 * REST Service providing operations on the {@link File} entity.
 * @package Bl2\Service\Rest
 */
class FileService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all files.
     * @url /files/
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
     * Gets the file with the given id.
     * @url /files/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return File
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * Removes the file with the given id.
     * @url /files/:id/
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
     * @url /files(/:id)/
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
        return File::entityName();
    }
}
