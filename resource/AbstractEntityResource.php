<?php

require_once 'include/config.php';
require_once 'util/HmacHashCalculator.php';

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
     * @var AbstractResourceHelper the resource helper
     */
    private $resourceHelper;

    /**
     * @var HmacHashCalculator
     */
    private $hmacCalculator;

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
        $this->hmacCalculator = new HmacHashCalculator();
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

    /**
     * Checks the HMAC hash for the current HTTP request.
     * @throws UnauthorizedException in case the HMAC hash is invalid.
     */
    protected function checkHmacHash() {
        return $this->hmacCalculator->checkHmacHash();
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
