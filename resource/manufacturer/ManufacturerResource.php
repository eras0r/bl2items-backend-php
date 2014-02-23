<?php

require_once 'vendor/autoload.php';

require_once "model/Manufacturer.php";

use Tonic\Response;
use Doctrine\DBAL\DBALException;

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /manufacturers/:id
 * @uri /manufacturers/:id/
 */
class ManufacturerResource extends AbstractManufacturerResource {

    /**
     * Gets a single manufacturer
     *
     * @method GET
     * @provides application/json
     */
    public function display() {
        $manufacturer = $this->getEntityManager()->find(Manufacturer::getEntityName(), $this->id);
        return json_encode($manufacturer->getJson());
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

        $errors = $this->validate($m);
        if (!empty($errors)) {
            return new Response(Response::NOTACCEPTABLE, json_encode($errors));
        } else {
            try {
                $manufacturer = $this->getEntityManager()->find(Manufacturer::getEntityName(), $this->id);
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
    public
    function remove() {
        $manufacturer = $this->getEntityManager()->find(Manufacturer::getEntityName(), $this->id);
        $this->getEntityManager()->remove($manufacturer);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

}
