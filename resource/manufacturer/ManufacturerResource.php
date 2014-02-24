<?php

require_once 'vendor/autoload.php';
require_once 'ManufacturerResourceHelper.php';

use Tonic\Application;
use Tonic\Response;
use Tonic\Request;

use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on single instances of the {@link Manufacturer} entity.
 * @uri /manufacturers/:id
 * @uri /manufacturers/:id/
 */
class ManufacturerResource extends AbstractSingleEntityResource {

    /**
     * Constructor used by tonic.
     * @param Tonic\Application $app
     * @param Tonic\Request $request
     */
    function __construct(Application $app, Request $request) {
        parent::__construct($app, $request, new ManufacturerResourceHelper());
    }

    /**
     * Updates a single manufacturer
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update() {
        $m = json_decode($this->request->data, true);

        $errors = $this->getResourceHelper()->validate($m);
        if (!empty($errors)) {
            return new Response(Response::NOTACCEPTABLE, json_encode($errors));
        } else {
            try {
                $manufacturer = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
                $manufacturer->setName($m["name"]);

                $this->getEntityManager()->persist($manufacturer);
                $this->getEntityManager()->flush();
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }

        return $this->display();
    }

    /**
     * Deletes a single manufacturer
     *
     * @method DELETE
     */
    public function remove() {
        $manufacturer = $this->getEntityManager()->find($this->getResourceHelper()->getEntityName(), $this->id);
        $this->getEntityManager()->remove($manufacturer);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

}
