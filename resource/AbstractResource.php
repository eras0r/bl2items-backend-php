<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;

use Tonic\Application;
use Tonic\Resource;
use Tonic\Response;
use Tonic\Request;

require_once 'vendor/autoload.php';

require_once 'include/config.php';

abstract class AbstractResource extends Resource {

    private $entityManager;

    // constructor for resources do have to invoke parent constructor and must have exactly this signature
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request);
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

    protected abstract function validate($entity);

    protected function handleUniqueKeyException(DBALException $e) {
        if ($e->getPrevious()->getCode() === '23000') {
            $errors = array();
            if (\preg_match("%key 'unique_(?P<key>.+)'%", $e->getMessage(), $match)) {
                $constraintName = $match['key'];
                $errors[$constraintName] = "Already exists!";
            }
        }
        return new Response(Response::CONFLICT, json_encode($errors));
    }

    /**
     * Needed for CORS (UI can be on different domain than API).
     * e.g.     API:     http://localhost/
     *           UI:     http://localhost:9000
     * @method OPTIONS
     * @provides application/json
     */
    function options() {

    }

}
