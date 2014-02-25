<?php

require_once 'AbstractEntityResource.php';

use Doctrine\DBAL\DBALException;
use Tonic\Application;
use Tonic\Request;
use Tonic\Response;

/**
 * Abstract super class for all RESTful resources which are based on a collection of an entity's objects.
 */
abstract class AbstractCollectionEntityResource extends AbstractEntityResource {

    /**
     * Constructor used by tonic.
     *
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     * @param AbstractResourceHelper $resourceHelper
     */
    function __construct(Application $app, Request $request, AbstractResourceHelper $resourceHelper) {
        parent::__construct($app, $request, $resourceHelper);
    }

    /**
     * Adds a new damage type
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $properties = json_decode($this->request->data, true);
        $errors = $this->getResourceHelper()->validate($properties);
        if (!empty($errors)) {
            return new Response(AbstractEntityResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $damageType = $this->getResourceHelper()->createNewEntityInstance($properties);
                $this->getEntityManager()->persist($damageType);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, json_encode($damageType->getJson()));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

    /**
     * Gets a list containing all manufacturer.
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $manufacturerRepository = $this->getEntityManager()->getRepository($this->getResourceHelper()->getEntityName());
        $manufacturers = array();

        foreach ($manufacturerRepository->findBy($this->getCriteria(), $this->getSortOrders()) as $m) {
            $manufacturers[] = $m->getJson();
        }

        return json_encode($manufacturers);
    }

    protected function getCriteria() {
        // TODO parse other GET parameters than "sort"
        return array();
    }

    /**
     * Gets the sort order based on the GET parameter named "sort".
     * There can be multiple sort order parameters separated by comma ",".
     * If the parameter start with a "-" this means this parameter will be sorted in descending order.
     * @return array the sort order array as used by the doctrine repository (the key is the name of the property
     * to be sorted, the value if either "asc" or "desc".
     */
    protected function getSortOrders() {
        // parse sort order
        if (isset($_GET["sort"])) {
            $sortOrders = array();
            foreach (explode(",", $_GET["sort"]) as $value) {
                if (strpos($value, "-") === 0) {
                    $sortOrders[substr($value, 1)] = "desc";
                } else {
                    $sortOrders[$value] = "asc";
                }
            }
            return $sortOrders;
        } else {
            return array();
        }
    }
}
