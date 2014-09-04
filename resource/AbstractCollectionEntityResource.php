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
     * Adds and saves a entity instance to the given resource.
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $properties = json_decode($this->request->data, true);
        $entityInstance = $this->getResourceHelper()->createNewEntityInstance($properties);
        $errors = $entityInstance->validate();
        if (!empty($errors)) {
            return new Response(AbstractEntityResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $this->getEntityManager()->persist($entityInstance);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, $this->serialize($entityInstance));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

    /**
     * Gets a list containing all objects of the entity this resource is based on.
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $this->checkHmacHash();
        $repository = $this->getEntityManager()->getRepository($this->getResourceHelper()->getEntityName());
        $result = $repository->findBy($this->getCriteria(), $this->getSortOrders());
        return $this->serialize($result);
    }

    protected function getCriteria() {
        // TODO parse other GET parameters than "sort"
        return array();
    }
}
