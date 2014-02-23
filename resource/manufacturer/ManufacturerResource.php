<?php

require_once 'vendor/autoload.php';

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
        $manufacturer = $this->getEntityManager()->find('Manufacturer', $this->id);
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
                $manufacturer = $this->getEntityManager()->find('Manufacturer', $this->id);

                $manufacturer->setName($m["name"]);
                $manufacturer->setColor($m["color"]);

                $this->getEntityManager()->persist($manufacturer);
                $this->getEntityManager()->flush();
            } catch (DBALException $e) {
                if ($e->getPrevious()->getCode() === '23000') {
                    $errors = array();
                    if (\preg_match("%key 'unique_(?P<key>.+)'%", $e->getMessage(), $match)) {
                        $constraintName = $match['key'];
                        $errors[$constraintName] = "Already exists!";
                    }
                }
                return new Response(Response::CONFLICT, json_encode($errors));
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
        $manufacturer = $this->getEntityManager()->find('Manufacturer', $this->id);
        $this->getEntityManager()->remove($manufacturer);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

}
