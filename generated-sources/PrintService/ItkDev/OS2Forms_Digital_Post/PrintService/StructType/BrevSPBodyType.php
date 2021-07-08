<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

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
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    protected \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType $ForsendelseI;
    /**
     * Constructor method for BrevSPBodyType
     * @uses BrevSPBodyType::setKanalvalg()
     * @uses BrevSPBodyType::setPrioritet()
     * @uses BrevSPBodyType::setForsendelseI()
     * @param string $kanalvalg
     * @param string $prioritet
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType $forsendelseI
     */
    public function __construct(string $kanalvalg, string $prioritet, \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType $forsendelseI)
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
     * @uses \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\KanalvalgType::valueIsValid()
     * @uses \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\KanalvalgType::getValidValues()
     * @throws InvalidArgumentException
     * @param string $kanalvalg
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
     */
    public function setKanalvalg(string $kanalvalg): self
    {
        // validation for constraint: enumeration
        if (!\ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\KanalvalgType::valueIsValid($kanalvalg)) {
            throw new InvalidArgumentException(sprintf('Invalid value(s) %s, please use one of: %s from enumeration class \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\KanalvalgType', is_array($kanalvalg) ? implode(', ', $kanalvalg) : var_export($kanalvalg, true), implode(', ', \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\KanalvalgType::getValidValues())), __LINE__);
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
     * @uses \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\PrioritetType::valueIsValid()
     * @uses \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\PrioritetType::getValidValues()
     * @throws InvalidArgumentException
     * @param string $prioritet
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
     */
    public function setPrioritet(string $prioritet): self
    {
        // validation for constraint: enumeration
        if (!\ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\PrioritetType::valueIsValid($prioritet)) {
            throw new InvalidArgumentException(sprintf('Invalid value(s) %s, please use one of: %s from enumeration class \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\PrioritetType', is_array($prioritet) ? implode(', ', $prioritet) : var_export($prioritet, true), implode(', ', \ItkDev\OS2Forms_Digital_Post\PrintService\EnumType\PrioritetType::getValidValues())), __LINE__);
        }
        $this->Prioritet = $prioritet;
        
        return $this;
    }
    /**
     * Get ForsendelseI value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function getForsendelseI(): \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
    {
        return $this->ForsendelseI;
    }
    /**
     * Set ForsendelseI value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType $forsendelseI
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
     */
    public function setForsendelseI(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType $forsendelseI): self
    {
        $this->ForsendelseI = $forsendelseI;
        
        return $this;
    }
}
