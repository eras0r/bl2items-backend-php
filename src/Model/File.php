<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a file.
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $mediatype;

    /**
     * @ORM\Column(type="blob")
     * @Serializer\Exclude
     * @var
     **/
    protected $data;

    /**
     * @ORM\Column(type="bigint")
     * @var int the file size in bytes
     */
    protected $size;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int the images with in pixels (null if the file is not an image)
     */
    protected $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int the images height in pixels (null if the file is not an image)
     */
    protected $height;

    /**
     * @var string the url to download the file
     */
    protected $downloadurl;

    public function __construct(array $data = array()) {
        parent::__construct($data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param string $mediatype
     */
    public function setMediatype($mediatype) {
        $this->mediatype = $mediatype;
    }

    /**
     * @return string
     */
    public function getMediatype() {
        return $this->mediatype;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @param string $downloadurl
     */
    public function setDownloadurl($downloadurl) {
        $this->downloadurl = $downloadurl;
    }

    /**
     * @return string
     */
    public function getDownloadurl() {
        return $this->downloadurl;
    }

    /**
     * @param int $height
     */
    public function setHeight($height) {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @param int $width
     */
    public function setWidth($width) {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    protected function doValidation() {
        parent::doValidation();
    }

    /**
     * @Serializer\PreSerialize
     */
    public function preSerialize() {
        $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"];

        if (($_SERVER["REQUEST_SCHEME"] === 'https' && $_SERVER["SERVER_PORT"] !== 443) || ($_SERVER["REQUEST_SCHEME"] === 'http' && $_SERVER["SERVER_PORT"] !== 80)) {
            $url .= sprintf(':%s', $_SERVER["SERVER_PORT"]);
        }

        $dirs = explode("/", $_SERVER["SCRIPT_NAME"]);

        // the first directory is empty because of the leading /
        $url .= "/" . $dirs[1] . "/download.php?id=" . $this->id;

        $this->downloadurl = $url;
    }
}