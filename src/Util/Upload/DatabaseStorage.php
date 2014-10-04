<?php
/**
 * Created by PhpStorm.
 * User: eras0r
 * Date: 9/23/14
 * Time: 9:23 PM
 */

namespace Bl2\Util\Upload;

use Bl2\Model\File;
use Bl2\Util\EntityManagerFactory;
use Bl2\Util\JsonSerializer;
use Doctrine\ORM\EntityManager;
use Upload\StorageInterface;

/**
 * Class DatabaseStorage
 * @package Bl2\Util\Upload
 */
class DatabaseStorage implements StorageInterface {

    /**
     * the entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * The id of the file in case an existing file will be overwritten
     * @var int
     */
    private $fileId;

    /**
     * @param int $fileId the id of the file in case a n existing file will be overwritten.
     */
    public function __construct($fileId = null) {
        $this->fileId = $fileId;
        $this->entityManager = EntityManagerFactory::getEntityManager();
    }

    /**
     * Upload file
     * This method is responsible for uploading an `\Upload\FileInfoInterface` instance
     * to its intended destination. If upload fails, an exception should be thrown.
     *
     * @param  \Upload\FileInfoInterface $fileInfo
     *
     * @throws \Exception                If upload fails
     */
    public function upload(\Upload\FileInfoInterface $fileInfo) {
        // TODO handle overwrite case
        if ($this->fileId != null) {
            $file = $this->getEntityManager()->find($this->getEntityName(), $this->fileId);
            if ($file == null) {
                throw new NotFoundException("No instance for entity '" . $this->getEntityName() . "' found for id '" . $this->fileId . "'");
            }
        } else {
            // upload a new file
            $file = new File();
        }

        $file->setName($fileInfo->getName());
        $file->setMediatype($fileInfo->getMimetype());
        $file->setSize($fileInfo->getSize());
        $file->setWidth($fileInfo->getDimensions()["width"]);
        $file->setHeight($fileInfo->getDimensions()["height"]);

        $data = file_get_contents($fileInfo->getPathname());
        $file->setData($data);

        $file->validate();
        $this->entityManager->persist($file);
        $this->entityManager->flush();

        $serializer = new JsonSerializer();
        $fileJson = $serializer->parse($file);
        echo $fileJson;
    }
}