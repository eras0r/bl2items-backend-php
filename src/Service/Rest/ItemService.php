<?php

namespace Bl2\Service\Rest;

use Bl2\Model\AbstractItem;
use Bl2\Model\Rarity;
use Bl2\Service\AbstractRestService;
use Spore\ReST\Model\Request;

/**
 * REST Service providing operations on the {@link AbstractItem} entity.
 * @package Bl2\Service\Rest
 */
class ItemService extends AbstractRestService {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all rarities.
     * @url /items/
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
     * Gets the rarity with the given id.
     * @url /items/:id/
     * @verbs GET
     *
     * @param Request $request the HTTP request
     *
     * @return Rarity
     */
    public function get(Request $request) {
        return parent::load($request, $request->params['id']);
    }

    /**
     * HTTP OPTIONS request used for CORS.
     * @url /items(/:id)/
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
        return AbstractItem::entityName();
    }
}
