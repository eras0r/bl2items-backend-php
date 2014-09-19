<?php

namespace Bl2\Service;

use Bl2\Exception\NotFoundException;
use Bl2\Exception\UniqueKeyConstraintException;
use Bl2\Model\AbstractEntity;
use Bl2\Util\AbstractResourceHelper;
use Bl2\Util\EntityManagerFactory;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Spore\ReST\Model\Request;
use Spore\ReST\Model\Response;
use Spore\ReST\Model\Status;

/**
 * Abstract super class for REST services.
 */
abstract class AbstractRestService {

    /**
     * @var AbstractResourceHelper the resource helper
     */
    private $resourceHelper;

    /**
     * @var EntityManager the entity manager.
     */
    private $entityManager;

    /**
     * Constructor
     */
    function __construct() {
        // TODO use dependency injection
        $this->entityManager = EntityManagerFactory::getEntityManager();
    }

    /**
     * Gets a list containing all objects of the entity this resource is based on.
     *
     * @param Request $request the HTTP request
     *
     * @return array all objects of the entity this resource is based on.
     */
    public function getAll(Request $request) {
        $repository = $this->getEntityManager()->getRepository($this->getEntityName());
        $result = $repository->findBy($this->getCriteria(), $this->getSortOrders());
        return $result;
    }

    /**
     * Retrieves a single resource.
     *
     * @param Request $request the HTTP request
     * @param int $id the id of the resource to be retrieved.
     *
     * @return AbstractEntity the retrieved resource object.
     * @throws \Bl2\Exception\NotFoundException
     */
    public function load(Request $request, $id) {
        $entityObj = $this->getEntityManager()->find($this->getEntityName(), $id);
        if ($entityObj == null) {
            throw new NotFoundException("No instance for entity '" . $this->getEntityName() . "' found for id '$id'");
        }
        return $entityObj;
    }

    /**
     * Creates and saves a new entity object.
     *
     * @param Request $request the HTTP request
     * @param Response $response the HTTP response
     * @param AbstractEntity $entityObject the new entity object to be saved
     *
     * @return AbstractEntity the newly created resource.
     */
    public function create(Request $request, Response $response, $entityObject) {
        $persistedEntityObject = $this->persistEntityObject($entityObject);

        // change HTTP response status and add location header for newly created objects
        $response->status = Status::CREATED;
        $response->headers["Location"] = $this->getResourceUrl($request, $persistedEntityObject);

        return $persistedEntityObject;
    }

    /**
     * Saves the given entity object.
     *
     * @param Request $request the HTTP request
     * @param int $id the id of the entity object to be saved
     *
     * @return AbstractEntity the updated resource
     */
    public function save(Request $request, $id) {
        // cast stdClass to array
        $properties = (array)$request->data;

        // load the entity object
        /** @var AbstractEntity $entityObject */
        $entityObject = $this->load($request, $id);

        // apply properties from JSON data
        $entityObject->applyPropertiesFromJson($properties);

        return $this->persistEntityObject($entityObject);
    }

    /**
     * Removes (deletes) a resource.
     *
     * @param Request $request the HTTP request
     * @param \Spore\ReST\Model\Response $response the HTTP response
     * @param $id int the id of the resource to be removed
     *
     * @return string
     */
    public function remove(Request $request, Response $response, $id) {
        $entityObject = $this->getEntityManager()->find($this->getEntityName(), $id);
        $this->getEntityManager()->remove($entityObject);
        $this->getEntityManager()->flush();
        $response->status = Status::NO_CONTENT;
        return "Resource removed";
    }

    /**
     * Used for HTTP OPTIONS requests.
     *
     * @param Request $request the HTTP request
     */
    public function options(Request $request) {
    }

    protected function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param DBALException $e
     *
     * @throws \Bl2\Exception\UniqueKeyConstraintException
     */
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

    protected function persistEntityObject(AbstractEntity $entityObject) {
        $entityObject->validate();

        try {
            $this->getEntityManager()->persist($entityObject);
            $this->getEntityManager()->flush();
            return $entityObject;
        } catch (DBALException $e) {
            $this->handleUniqueKeyException($e);
        }
    }

    /**
     * Gets the name of the entity on which this service is based.
     * @return string the name of the entity on which this service is based.
     */
    protected abstract function getEntityName();

    private function getResourceUrl($request, $entityInstance) {
        return $request->request()->getUrl() . $request->request()->getPath() . '/' . $entityInstance->getId();
    }
}
