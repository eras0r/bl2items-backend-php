<?php

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Tools\Setup;

/**
 * Class providing access to a shared singleton instance of an {@link EntityManager}.
 */
final class EntityManagerFactory {

    private static $entityManager;

    /**
     * private constructor to avoid instantiation of factory class.
     */
    private function __construct() {
    }

    public static function getEntityManager() {
        if (!isset(self::$entityManager)) {
            self::initEntityManager();
        }

        return self::$entityManager;
    }

    private static function initEntityManager() {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/model"), $isDevMode, null, null, false);
        AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', __DIR__ . "/../vendor/jms/serializer/src");

        // the connection configuration
        $conn = array(
            'driver' => DB_DRIVER,
            'user' => DB_USER,
            'password' => DB_PASSWORD,
            'dbname' => DB_NAME
        );

        // obtaining the entity manager
        self::$entityManager = EntityManager::create($conn, $config);
    }
} 