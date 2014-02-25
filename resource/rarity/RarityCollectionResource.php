<?php

require_once 'vendor/autoload.php';
require_once 'RarityResourceHelper.php';

use Tonic\Application;
use Tonic\Request;


/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Rarity} entity.
 * @uri /rarities
 * @uri /rarities/
 */
class RarityCollectionResource extends AbstractCollectionEntityResource {

    /**
     * Constructor used by tonic.
     *
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new RarityResourceHelper());
    }
}

?>
