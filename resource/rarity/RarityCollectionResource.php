<?php

require_once 'vendor/autoload.php';

require_once 'model/Rarity.php';

use Tonic\Response;
use Doctrine\DBAL\DBALException;

/**
 * This class defines an example resource that is wired into the URI /example
 * @uri /rarities
 * @uri /rarities/
 */
class RarityCollectionResource extends AbstractRarityResource {

    /**
     * Gets a list containing all rarities.
     *
     * @json
     * @method GET
     * @provides application/json
     */
    public function getAll() {
        $rarityRepository = $this->getEntityManager()->getRepository(Rarity::getEntityName());
        $rarities = array();

        foreach ($rarityRepository->findBy(array(), array('sortOrder' => 'asc')) as $r) {
            $rarities[] = $r->getJson();
        }

        return json_encode($rarities);
    }

    /**
     * Adds a new rarity
     *
     * @method POST
     * @accepts application/json
     */
    public function add() {
        // json decode to associative array
        $r = json_decode($this->request->data, true);
        $errors = $this->validate($r);
        if (!empty($errors)) {
            return new Response(AbstractResource::UNPROCESSABLE_ENTITY, json_encode($errors));
        } else {
            try {
                $rarity = new Rarity($r);
                $this->getEntityManager()->persist($rarity);
                $this->getEntityManager()->flush();
                return new Response(Response::CREATED, json_encode($rarity->getJson()));
            } catch (DBALException $e) {
                return $this->handleUniqueKeyException($e);
            }
        }
    }

}

?>
