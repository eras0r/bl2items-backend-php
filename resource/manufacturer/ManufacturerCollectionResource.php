<?php

require_once 'vendor/autoload.php';

use Tonic\Response;
use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link Manufacturer} entity.
 * @uri /manufacturers
 * @uri /manufacturers/
 */
class ManufacturerCollectionResource extends AbstractManufacturerResource {

    /**
     * Gets a list containing all manufacturer.
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $manufacturerRepository = $this->getEntityManager()->getRepository($this->getEnityName());
        $manufacturers = array();

        foreach ($manufacturerRepository->findBy(array(), array('name' => 'asc')) as $m) {
            $manufacturers[] = $m->getJson();
        }

        return json_encode($manufacturers);
    }

    /**
     * Adds a new manufacturer
     *
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $m = json_decode($this->request->data, true);
        $errors = $this->validate($m);
        if (!empty($errors)) {
            return new Response(AbstractResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $manufacturer = new Manufacturer($m);
                $this->getEntityManager()->persist($manufacturer);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, json_encode($manufacturer->getJson()));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

}

?>
