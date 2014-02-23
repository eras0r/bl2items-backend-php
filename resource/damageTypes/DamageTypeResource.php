<?php

require_once 'vendor/autoload.php';

require_once 'model/DamageType.php';

use Tonic\Response;
use Doctrine\DBAL\DBALException;


/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on single instances of the {@link DamageType} entity.
 * @uri /damageTypes/:id
 * @uri /damageTypes/:id/
 */
class DamageTypeResource extends AbstractDamageTypeResource {

    /**
     * Gets a single damage type
     *
     * @method GET
     * @provides application/json
     * @return string the JSON representation of the damage type
     */
    public function display() {
        $damageType = $this->getEntityManager()->find(DamageType::getEntityName(), $this->id);
        return json_encode($damageType->getJson());
    }

    /**
     * Updates a single damage type
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     * @return string|Tonic\Response
     */
    public function update() {
        $dt = json_decode($this->request->data, true);
        $errors = $this->validate($dt);

        if (!empty($errors)) {
            return new Response(Response::NOTACCEPTABLE, json_encode($errors));
        } else {
            try {
                $damageType = $this->getEntityManager()->find(DamageType::getEntityName(), $this->id);
                $damageType->setName($dt["name"]);
                $damageType->setSortOrder($dt["sortOrder"]);

                $this->getEntityManager()->persist($damageType);
                $this->getEntityManager()->flush();
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }

        return $this->display();
    }

    /**
     * Deletes a single damage type.
     *
     * @method DELETE
     * @return Tonic\Response
     */
    public function remove() {
        $damageType = $this->getEntityManager()->find(DamageType::getEntityName(), $this->id);
        $this->getEntityManager()->remove($damageType);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

}
