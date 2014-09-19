<?php

namespace Bl2\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Entity object representing a shield.
 * @ORM\Entity
 * @ORM\Table(name="shield")
 */
class Shield extends AbstractItem {

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected $capacity;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("rechargeRate")
     * @var int
     **/
    protected $rechargeRate;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("rechargeDelay")
     * @var double
     **/
    protected $rechargeDelay;

    // optional properties (depending on shield type)

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("maxHealth")
     * @var int
     **/
    protected $maxHealth;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("boosterChance")
     * @var double
     **/
    protected $boosterChance;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("elementalResistance")
     * @var double
     **/
    protected $elementalResistance;

    /**
     * @ORM\Column(type="decimal")
     * @Serializer\SerializedName("absorbChance")
     * @var double
     **/
    protected $absorbChance;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("ampDamage")
     * @var int
     **/
    protected $ampDamage;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("ampShotDrain")
     * @var int
     **/
    protected $ampShotDrain;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("novaDamage")
     * @var int
     **/
    protected $novaDamage;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("novaRadius")
     * @var int
     **/
    protected $novaRadius;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("roidDamage")
     * @var int
     **/
    protected $roidDamage;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\SerializedName("spikeDamage")
     * @var int
     **/
    protected $spikeDamage;

    /**
     * Creates a new shield by initializing is properties by using the values given in the associative array.
     *
     * @param array $data associative array holding the properties for the shield.
     */
    public function __construct(array $data) {
        parent::__construct($data);
    }

    /**
     * @param float $absorbChance
     */
    public function setAbsorbChance($absorbChance) {
        $this->absorbChance = $absorbChance;
    }

    /**
     * @return float
     */
    public function getAbsorbChance() {
        return $this->absorbChance;
    }

    /**
     * @param int $ampDamage
     */
    public function setAmpDamage($ampDamage) {
        $this->ampDamage = $ampDamage;
    }

    /**
     * @return int
     */
    public function getAmpDamage() {
        return $this->ampDamage;
    }

    /**
     * @param int $ampShotDrain
     */
    public function setAmpShotDrain($ampShotDrain) {
        $this->ampShotDrain = $ampShotDrain;
    }

    /**
     * @return int
     */
    public function getAmpShotDrain() {
        return $this->ampShotDrain;
    }

    /**
     * @param float $boosterChance
     */
    public function setBoosterChance($boosterChance) {
        $this->boosterChance = $boosterChance;
    }

    /**
     * @return float
     */
    public function getBoosterChance() {
        return $this->boosterChance;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity($capacity) {
        $this->capacity = $capacity;
    }

    /**
     * @return int
     */
    public function getCapacity() {
        return $this->capacity;
    }

    /**
     * @param float $elementalResistance
     */
    public function setElementalResistance($elementalResistance) {
        $this->elementalResistance = $elementalResistance;
    }

    /**
     * @return float
     */
    public function getElementalResistance() {
        return $this->elementalResistance;
    }

    /**
     * @param int $maxHealth
     */
    public function setMaxHealth($maxHealth) {
        $this->maxHealth = $maxHealth;
    }

    /**
     * @return int
     */
    public function getMaxHealth() {
        return $this->maxHealth;
    }

    /**
     * @param int $novaDamage
     */
    public function setNovaDamage($novaDamage) {
        $this->novaDamage = $novaDamage;
    }

    /**
     * @return int
     */
    public function getNovaDamage() {
        return $this->novaDamage;
    }

    /**
     * @param int $novaRadius
     */
    public function setNovaRadius($novaRadius) {
        $this->novaRadius = $novaRadius;
    }

    /**
     * @return int
     */
    public function getNovaRadius() {
        return $this->novaRadius;
    }

    /**
     * @param float $rechargeDelay
     */
    public function setRechargeDelay($rechargeDelay) {
        $this->rechargeDelay = $rechargeDelay;
    }

    /**
     * @return float
     */
    public function getRechargeDelay() {
        return $this->rechargeDelay;
    }

    /**
     * @param int $rechargeRate
     */
    public function setRechargeRate($rechargeRate) {
        $this->rechargeRate = $rechargeRate;
    }

    /**
     * @return int
     */
    public function getRechargeRate() {
        return $this->rechargeRate;
    }

    /**
     * @param int $roidDamage
     */
    public function setRoidDamage($roidDamage) {
        $this->roidDamage = $roidDamage;
    }

    /**
     * @return int
     */
    public function getRoidDamage() {
        return $this->roidDamage;
    }

    /**
     * @param int $spikeDamage
     */
    public function setSpikeDamage($spikeDamage) {
        $this->spikeDamage = $spikeDamage;
    }

    /**
     * @return int
     */
    public function getSpikeDamage() {
        return $this->spikeDamage;
    }

    protected function doValidation() {
        parent::doValidation();

        if (empty($this->capacity)) {
            $this->addValidationError("capacity", "Capacity is required");
        }
        if (empty($this->rechargeRate)) {
            $this->addValidationError("rechargeRate", "Recharge rate is required");
        }
        if (empty($this->rechargeDelay)) {
            $this->addValidationError("rechargeDelay", "recharge delay is required");
        }
    }
}