<?php

namespace Bl2\Service;

use Bl2\Exception\NotFoundException;
use Bl2\Exception\UniqueKeyConstraintException;
use Bl2\Model\AbstractEntity;
use Bl2\Util\AbstractResourceHelper;
use Doctrine\DBAL\DBALException;
use Spore\ReST\Model\Request;

/**
 * Abstract super class for REST services.
 */
abstract class AbstractRestService {

    /**
     * @var AbstractResourceHelper the resource helper
     */
    private $resourceHelper;

    /**
     * @param AbstractResourceHelper $resourceHelper
     */
    function __construct(AbstractResourceHelper $resourceHelper) {
        $this->resourceHelper = $resourceHelper;
        // TODO use dependency injection

    }

    /**
     * Gets a list containing all objects of the entity this resource is based on.
     */
    public function getAll(Request $request) {
        $repository = $this->getEntityManager()->getRepository($this->getResourceHelper()->getEntityName());
        $result = $repository->findBy($this->getCriteria(), $this->getSortOrders());
        return $result;
    }

    /**
     * Retrieves a single resource.
     *
     * @param Request $request the HTTP request
     * @param $id int the id of the resource to be retrieved.
     *
     * @return AbstractEntity the retrieved resource object.
     * @throws \Bl2\Exception\NotFoundException
     */
    public function get(Request $request, $id) {
        $entityObj = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $id);
        if ($entityObj == null) {
            throw new NotFoundException("No instance for entity '" . $this->getResourceHelper()->getEntityName() . "' found for id '$id'");
        }
        return $entityObj;
    }

    /**
     * Adds and saves a new resource.
     *
     * @param Request $request the HTTP request.
     *
     * @return AbstractEntity the newly created resource.
     */
    public function add(Request $request) {
        // cast stdClass to array
        $properties = (array)$request->data;
        $entityInstance = $this->getResourceHelper()->createNewEntityInstance($properties);

        $entityInstance->validate();

        try {
            $this->getEntityManager()->persist($entityInstance);
            $this->getEntityManager()->flush();
            return $entityInstance;
        } catch (DBALException $e) {
            return $this->handleUniqueKeyException($e);
        }
    }

    /**
     * Completely updates a resource by writing each field of the resource.
     *
     * @param Request $request the HTTP request
     * @param $id int the id of the resource to be updated
     *
     * @return AbstractEntity the updated resource
     */
    public function update(Request $request, $id) {
        // cast stdClass to array
        $jsonData = (array)$request->data;

        /* @var $entityObject AbstractEntity */
        $entityObject = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $id);
        $this->getResourceHelper()->updateEntityObject($entityObject, $jsonData);
        $entityObject->validate();

        try {
            $this->getEntityManager()->persist($entityObject);
            $this->getEntityManager()->flush();
            return $this->get($request, $id);
        } catch (DBALException $e) {
            return $this->handleUniqueKeyException($e);
        }
    }

    /**
     * Removes (deletes) a resource.
     *
     * @param Request $request the HTTP request.
     * @param $id int the id of the resource to be removed
     *
     * @return Response TODO proper return value
     */
    public function remove(Request $request, $id) {
        $entityObject = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $id);
        $this->getEntityManager()->remove($entityObject);
        $this->getEntityManager()->flush();
        // FIXME proper return value
        return new Response(Response::NOCONTENT);
    }

    /**
     * Used for HTTP OPTIONS requests.
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
    }

    protected function getEntityManager() {
        return $this->getResourceHelper()->getEntityManager();
    }

    protected function handleUniqueKeyException(DBALException $e) {
        $errors = array();
        if ($e->getPrevious()->getCode() === '23000') {
            if (\preg_match("%key 'unique_(?P<key>.+)'%", $e->getMessage(), $match)) {
                $constraintName = $match['key'];
                $errors[$constraintName] = "Already exists!";
            }
        }
        throw new UniqueKeyConstraintException($errors);
    }

    /**
     * Gets the resource helper
     * @return AbstractResourceHelper the resource helper
     */
    protected function getResourceHelper() {
        return $this->resourceHelper;
    }

    /**
     * Serializes the given object
     *
     * @param $data mixed the object to be serialized
     * @param $format string the format to be used for serialization (defaults to json).
     *
     * @return mixed the serialized object
     */
    protected function serialize($data, $format = 'json') {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($data, $format);
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

    /**
     * Gets the filter criteria to be applied for the {@link getAll()} method.
     * @return array array holding the filter criteria.
     */
    protected function getCriteria() {
        // TODO parse other GET parameters than "sort"
        return array();
    }
}
