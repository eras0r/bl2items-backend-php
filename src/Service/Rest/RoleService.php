<?php

namespace Bl2\Service\Rest;

use Bl2\Model\Role;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;

/**
 * REST Service providing operations on the {@link Role} entity.
 * @package Bl2\Service\Rest
 */
class RoleService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all roles.
     * @url /roles/
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
     * HTTP OPTIONS request used for CORS.
     * @url /roles(/:id)/
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
        return Role::entityName();
    }
}
