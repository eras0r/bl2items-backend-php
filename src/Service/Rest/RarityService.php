<?php

namespace Bl2\Service\Rest;

use Bl2\Service\AbstractEntity;
use Bl2\Service\AbstractEntityResource;
use Bl2\Service\AbstractRestService;
use Bl2\Service\Response;
use Bl2\Util\ResourceHelper\RarityResourceHelper;
use Spore\ReST\Model\Request;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Rarity} entity.
 */
class RarityService extends AbstractRestService {

    function __construct() {
        // TODO use dependency injection
        parent::__construct(new RarityResourceHelper());
    }

    /**
     * Gets all rarities.
     * @url /rarities/
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
     * Gets the rarity with the given id.
     * @url /rarities/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return \Bl2\Model\AbstractEntity
     */
    public function get(Request $request) {
        return parent::get($request, $request->params['id']);
    }

    /**
     * Creates a new rarity.
     * @url /rarities/
     * @verbs POST
     * @auth admin
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request) {
        return parent::add($request);
    }

    /**
     * Updates the rarity with the given id
     * @url /rarities/:id/
     * @verbs PUT
     *
     * @param Request $request the HTTP request
     *
     * @return \Bl2\Model\AbstractEntity
     */
    public function update(Request $request) {
        return parent::update($request, $request->params['id']);
    }

    /**
     * Removes the rarity with the given id.
     * @url /rarities/:id/
     * @verbs DELETE
     *
     * @param Request $request the HTTP request
     *
     * @return Response
     */
    public function remove(Request $request) {
        return parent::remove($request, $request->params['id']);
    }

    /**
     * HTTP OPTIONS request used for CORS.
     * @url /rarities(/:id)/
     * @verbs OPTIONS
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
        return parent::options($request);
    }
}
