<?php

require_once 'vendor/autoload.php';
require_once 'resource/AbstractEntityResource.php';

use Tonic\Application;
use Tonic\Request;


/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Weapon} entity.
 * @uri /items
 * @uri /items/
 */
class ItemCollectionResource extends AbstractEntityResource {

    /**
     * Constructor used by tonic.
     *
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new WeaponResourceHelper());
    }

    /**
     * Gets a list containing all items.
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $this->checkHmacHash();

        $enityName = "abstractItem";

        // TODO check given GET parameter
        if (isset($_GET["itemType"])) {
            $enityName = $_GET["itemType"];
        }

        $repository = $this->getEntityManager()->getRepository($enityName);
        $result = $repository->findBy($this->getCriteria(), $this->getSortOrders());
        return $this->serialize($result);
    }

    private function getCriteria() {
        // TODO parse other GET parameters than "sort"
        return array();
    }
}

?>
