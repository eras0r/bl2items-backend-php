<?php

require_once 'vendor/autoload.php';

require_once 'model/DamageType.php';

use Tonic\Response;
use Doctrine\DBAL\DBALException;

/**
 * This class defines the resource which will provide a RESTful interface for all operations
 * based on collections of the {@link DamageType} entity.
 * @uri /damageTypes
 * @uri /damageTypes/
 */
class DamageTypeCollectionResource extends AbstractDamageTypeResource {

    /**
     * Gets a list containing all damage types.
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $damageTypeRepository = $this->getEntityManager()->getRepository(DamageType::getEntityName());
        $damageTypes = array();

        foreach ($damageTypeRepository->findBy(array(), array('sortOrder' => 'asc')) as $m) {
            $damageTypes[] = $m->getJson();
        }

        return json_encode($damageTypes);
    }

    /**
     * Adds a new damage type
     *
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $dt = json_decode($this->request->data, true);
        $errors = $this->validate($dt);
        if (!empty($errors)) {
            return new Response(AbstractResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $damageType = new DamageType($dt);
                $this->getEntityManager()->persist($damageType);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, json_encode($damageType->getJson()));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

}

?>
