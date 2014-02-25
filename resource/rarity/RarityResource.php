<?php

require_once 'vendor/autoload.php';
require_once 'RarityResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on single instances of the {@link Rarity} entity.
 * @uri /rarities/:id
 * @uri /rarities/:id/
 */
class RarityResource extends AbstractSingleEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new RarityResourceHelper());
    }

}
