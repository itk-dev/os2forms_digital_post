<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for BrevSPBodyType StructType
 * @subpackage Structs
 */
class BrevSPBodyType extends AbstractStructBase
{
    /**
     * The Kanalvalg
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var string
     */
    protected string $Kanalvalg;
    /**
     * The Prioritet
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var string
     */
    protected string $Prioritet;
    /**
     * The ForsendelseI
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType
     */
    protected \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType $ForsendelseI;
    /**
     * Constructor method for BrevSPBodyType
     * @uses BrevSPBodyType::setKanalvalg()
     * @uses BrevSPBodyType::setPrioritet()
     * @uses BrevSPBodyType::setForsendelseI()
     * @param string $kanalvalg
     * @param string $prioritet
     * @param \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType $forsendelseI
     */
    public function __construct(string $kanalvalg, string $prioritet, \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType $forsendelseI)
    {
        $this
            ->setKanalvalg($kanalvalg)
            ->setPrioritet($prioritet)
            ->setForsendelseI($forsendelseI);
    }
    /**
     * Get Kanalvalg value
     * @return string
     */
    public function getKanalvalg(): string
    {
        return $this->Kanalvalg;
    }
    /**
     * Set Kanalvalg value
     * @uses \Drupal\os2forms_digital_post\Client\EnumType\KanalvalgType::valueIsValid()
     * @uses \Drupal\os2forms_digital_post\Client\EnumType\KanalvalgType::getValidValues()
     * @throws InvalidArgumentException
     * @param string $kanalvalg
     * @return \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
     */
    public function setKanalvalg(string $kanalvalg): self
    {
        // validation for constraint: enumeration
        if (!\Drupal\os2forms_digital_post\Client\EnumType\KanalvalgType::valueIsValid($kanalvalg)) {
            throw new InvalidArgumentException(sprintf('Invalid value(s) %s, please use one of: %s from enumeration class \Drupal\os2forms_digital_post\Client\EnumType\KanalvalgType', is_array($kanalvalg) ? implode(', ', $kanalvalg) : var_export($kanalvalg, true), implode(', ', \Drupal\os2forms_digital_post\Client\EnumType\KanalvalgType::getValidValues())), __LINE__);
        }
        $this->Kanalvalg = $kanalvalg;
        
        return $this;
    }
    /**
     * Get Prioritet value
     * @return string
     */
    public function getPrioritet(): string
    {
        return $this->Prioritet;
    }
    /**
     * Set Prioritet value
     * @uses \Drupal\os2forms_digital_post\Client\EnumType\PrioritetType::valueIsValid()
     * @uses \Drupal\os2forms_digital_post\Client\EnumType\PrioritetType::getValidValues()
     * @throws InvalidArgumentException
     * @param string $prioritet
     * @return \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
     */
    public function setPrioritet(string $prioritet): self
    {
        // validation for constraint: enumeration
        if (!\Drupal\os2forms_digital_post\Client\EnumType\PrioritetType::valueIsValid($prioritet)) {
            throw new InvalidArgumentException(sprintf('Invalid value(s) %s, please use one of: %s from enumeration class \Drupal\os2forms_digital_post\Client\EnumType\PrioritetType', is_array($prioritet) ? implode(', ', $prioritet) : var_export($prioritet, true), implode(', ', \Drupal\os2forms_digital_post\Client\EnumType\PrioritetType::getValidValues())), __LINE__);
        }
        $this->Prioritet = $prioritet;
        
        return $this;
    }
    /**
     * Get ForsendelseI value
     * @return \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType
     */
    public function getForsendelseI(): \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType
    {
        return $this->ForsendelseI;
    }
    /**
     * Set ForsendelseI value
     * @param \Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType $forsendelseI
     * @return \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
     */
    public function setForsendelseI(\Drupal\os2forms_digital_post\Client\StructType\ForsendelseIType $forsendelseI): self
    {
        $this->ForsendelseI = $forsendelseI;
        
        return $this;
    }
}
