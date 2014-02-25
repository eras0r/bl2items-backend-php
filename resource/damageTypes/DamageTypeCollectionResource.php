<?php

require_once 'vendor/autoload.php';
require_once 'DamageTypeResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;


/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link DamageType} entity.
 * @uri /damageTypes
 * @uri /damageTypes/
 */
class DamageTypeCollectionResource extends AbstractCollectionEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new DamageTypeResourceHelper());
    }

}

?>
