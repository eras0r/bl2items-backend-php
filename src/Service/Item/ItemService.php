<?php

namespace Bl2\Service\Item;

use Bl2\Service\AbstractRestService;
use Bl2\Service\Weapon\WeaponResourceHelper;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Weapon} entity.
 */
class ItemService extends AbstractRestService {

    /**
     * @param Request $request
     */
    // FIXME use request as parameter
//    function __construct(Request $request) {
//        // TODO use dependency injection
//        parent::__construct($request, new WeaponResourceHelper());
//    }

    function __construct() {
        // TODO use dependency injection
        parent::__construct(new WeaponResourceHelper());
    }

    /**
     * Gets a list containing all items.
     * @url /items
     * @verbs GET
     */
    public function getAll() {
        $this->checkHmacHash();

        $enityName = 'Bl2\Model\AbstractItem';
//        $enityName = "AbstractItem";

        // TODO check given GET parameter
        if (isset($_GET["itemType"])) {
            $enityName = $_GET["itemType"];
        }

        $repository = $this->getEntityManager()->getRepository($enityName);
        $result = $repository->findBy($this->getCriteria(), $this->getSortOrders());
        return $this->serialize($result);
    }

    protected  function getCriteria() {
        // TODO parse other GET parameters than "sort"
        return array();
    }
}
