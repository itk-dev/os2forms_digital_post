<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ForsendelseAfsenderType StructType
 * @subpackage Structs
 */
class ForsendelseAfsenderType extends AbstractStructBase
{
    /**
     * The AfsenderAdresse
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: fjernprint:AfsenderAdresse
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $AfsenderAdresse = null;
    /**
     * Constructor method for ForsendelseAfsenderType
     * @uses ForsendelseAfsenderType::setAfsenderAdresse()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $afsenderAdresse
     */
    public function __construct(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $afsenderAdresse = null)
    {
        $this
            ->setAfsenderAdresse($afsenderAdresse);
    }
    /**
     * Get AfsenderAdresse value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType|null
     */
    public function getAfsenderAdresse(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
    {
        return $this->AfsenderAdresse;
    }
    /**
     * Set AfsenderAdresse value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $afsenderAdresse
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseAfsenderType
     */
    public function setAfsenderAdresse(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $afsenderAdresse = null): self
    {
        $this->AfsenderAdresse = $afsenderAdresse;
        
        return $this;
    }
}
