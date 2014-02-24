<?php

require_once 'AbstractEntityResource.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;

use Tonic\Application;
use Tonic\Resource;
use Tonic\Response;
use Tonic\Request;

class EntityObjectValidationException extends Exception {

    private $validationErrors;

    function __construct($validationErrors) {
        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors() {
        return $this->validationErrors;
    }

}

/**
 * Abstract super class for all RESTful resources which are based on a single object of an entity.
 */
abstract class AbstractSingleEntityResource extends AbstractEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     * @param AbstractResourceHelper $resourceHelper
     */
    function __construct(Application $app, Request $request, AbstractResourceHelper $resourceHelper) {
        parent::__construct($app, $request, $resourceHelper);
    }

    /**
     * Gets a single manufacturer
     *
     * @method GET
     * @provides application/json
     */
    public function display() {
        $entityObj = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
        return json_encode($entityObj->getJson());
    }

    /**
     * Deletes a single manufacturer
     *
     * @method DELETE
     */
    public function remove() {
        $manufacturer = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
        $this->getEntityManager()->remove($manufacturer);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

    /**
     * @return mixed the encoded JSON entity object
     * @throws EntityObjectValidationException if validation errors occured
     */
    protected function prepareEntityObjectUpdate() {
        $jsonData = json_decode($this->request->data, true);
        $errors = $this->getResourceHelper()->validate($jsonData);
        if (empty($errors)) {
            return $jsonData;
        } else {
            throw new EntityObjectValidationException($errors);
        }
    }

    protected function saveEntityObject($entityObject) {
        try {
            $this->getEntityManager()->persist($entityObject);
            $this->getEntityManager()->flush();
            return $this->display();
        } catch (DBALException $e) {
            return $this->handleUniqueKeyException($e);
        }
    }

}

