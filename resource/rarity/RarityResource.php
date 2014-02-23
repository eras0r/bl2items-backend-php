<?php

require_once 'vendor/autoload.php';

require_once 'model/Rarity.php';

use Tonic\Response;
use Doctrine\DBAL\DBALException;

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /rarities/:id
 * @uri /rarities/:id/
 */
class RarityResource extends AbstractRarityResource {

    /**
     * Gets a single rarity
     *
     * @method GET
     * @provides application/json
     */
    public function display() {
        $rarity = $this->getEntityManager()->find(Rarity::getEntityName(), $this->id);
        return json_encode($rarity->getJson());
    }

    /**
     * Updates a single rarity
     *
     * @method PUT
     * @accepts application/json
     * @provides application/json
     */
    public function update() {
        $r = json_decode($this->request->data, true);

        $errors = $this->validate($r);
        if (!empty($errors)) {
            return new Response(Response::NOTACCEPTABLE, json_encode($errors));
        } else {
            try {
                $rarity = $this->getEntityManager()->find(Rarity::getEntityName(), $this->id);
                $rarity->setName($r["name"]);
                $rarity->setColor($r["color"]);
                $rarity->setSortOrder($r["sortOrder"]);

                $this->getEntityManager()->persist($rarity);
                $this->getEntityManager()->flush();
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }

        return $this->display();
    }

    /**
     * Deletes a single rarity
     *
     * @method DELETE
     */
    public
    function remove() {
        $rarity = $this->getEntityManager()->find(Rarity::getEntityName(), $this->id);
        $this->getEntityManager()->remove($rarity);
        $this->getEntityManager()->flush();
        return new Response(Response::NOCONTENT);
    }

}
