<?php

require_once 'include/config.php';

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
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
     * @var Doctrine\ORM\EntityManager the doctrine entity manager
     */
    private $entityManager;

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
        if (!isset($this->entityManager)) {
            // Create a simple "default" Doctrine ORM configuration for Annotations
            $isDevMode = true;
            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/model"), $isDevMode);

            // the connection configuration
            $conn = array(
                'driver' => DB_DRIVER,
                'user' => DB_USER,
                'password' => DB_PASSWORD,
                'dbname' => DB_NAME
            );

            // obtaining the entity manager
            $this->entityManager = EntityManager::create($conn, $config);
        }

        return $this->entityManager;
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
}
