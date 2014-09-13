<?php

namespace Bl2\Controller;

/**
 * Controller class for performing logouts from the system.
 */
class LogoutController {

    private $entityManager;

    function __construct() {
        $this->entityManager = EntityManagerFactory::getEntityManager();
    }

    public function logout($sessionTokenId) {
        // check if SessionToken $this->sessionToken  exists
        $sessionToken = $this->entityManager->getRepository('SessionToken')->findOneBy(array('sessionToken' =>
            $sessionTokenId));
        if (!$sessionToken) {
            throw new UnauthorizedException();
        }
        // delete $sessionToken
        $this->entityManager->remove($sessionToken);
        $this->entityManager->flush();
    }
}
