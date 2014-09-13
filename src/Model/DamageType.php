<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="damage_type", uniqueConstraints={@ORM\UniqueConstraint(name="unique_name", columns={"name"}), @ORM\UniqueConstraint(name="unique_sortOrder", columns={"sortOrder"})})
 **/
class DamageType extends AbstractEntity {

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("sortOrder")
     * @var int
     **/
    protected $sortOrder;

    /**
     * @ORM\Column(type="string", length=7)
     * @var string
     **/
    protected $color;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\SerializedName("damageLabel")
     * @var string
     **/
    protected $damageLabel;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\SerializedName("chanceLabel")
     * @var string
     **/
    protected $chanceLabel;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\SerializedName("additionalText")
     * @var string
     **/
    protected $additionalText;

    /**
     * Creates a new damage type by initializing is properties by using hte values given in the associative array.
     *
     * @param array $data associative array holding the properties for the damage type.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * Gets the name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name the name to be set.
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the sort order
     * @return int the sort order
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Sets the sort order.
     *
     * @param int $sortOrder the sort order to be set.
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return string
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color) {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getDamageLabel() {
        return $this->damageLabel;
    }

    /**
     * @param string $damageLabel
     */
    public function setDamageLabel($damageLabel) {
        $this->damageLabel = $damageLabel;
    }

    /**
     * @return string
     */
    public function getChanceLabel() {
        return $this->chanceLabel;
    }

    /**
     * @param string $chanceLabel
     */
    public function setChanceLabel($chanceLabel) {
        $this->chanceLabel = $chanceLabel;
    }

    /**
     * @return string
     */
    public function getAdditionalText() {
        return $this->additionalText;
    }

    /**
     * @param string $additionalText
     */
    public function setAdditionalText($additionalText) {
        $this->additionalText = $additionalText;
    }

    /**
     * Validates the entity and returns an array containing validation errors (if any).
     * @return array associative array containing validation errors (if any).
     */
    public function validate() {
        $errors = array();
        if (empty($this->name)) {
            $errors["name"] = "Name is required";
        }
        if (empty($this->sortOrder)) {
            $errors["sortOrder"] = "Sort order is required";
        }
        return $errors;
    }
}
