<?php

require_once 'include/config.php';

use Doctrine\DBAL\DBALException;
use JMS\Serializer\SerializerBuilder;
use Tonic\Application;
use Tonic\Request;
use Tonic\Resource;
use Tonic\Response;

/**
 * Abstract super class for all entity based tonic resources.
 */
abstract class AbstractEntityResource extends Resource {

    /**
     * HTTP status code used for validation errors
     */
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * @var AbstractResourceHelper the resource hellper
     */
    private $resourceHelper;

    /**
     * Constructor used by tonic.
     *
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     * @param AbstractResourceHelper $resourceHelper
     */
    function __construct(Application $app, Request $request, AbstractResourceHelper $resourceHelper) {
        parent::__construct($app, $request);
        $this->resourceHelper = $resourceHelper;
    }

    /**
     * Needed for CORS (UI can be on different domain than API).
     * e.g.     API:     http://localhost/
     *           UI:     http://localhost:9000
     * @method OPTIONS
     * @provides application/json
     */
    public function options() {
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
        return new Response(AbstractEntityResource::UNPROCESSABLE_ENTITY, json_encode($errors));
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
}
