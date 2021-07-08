<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ForsendelseModtagerType StructType
 * @subpackage Structs
 */
class ForsendelseModtagerType extends AbstractStructBase
{
    /**
     * The AfsendelseModtager
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: dkal:AfsendelseModtager
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType $AfsendelseModtager = null;
    /**
     * The ModtagerAdresse
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: fjernprint:ModtagerAdresse
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $ModtagerAdresse = null;
    /**
     * Constructor method for ForsendelseModtagerType
     * @uses ForsendelseModtagerType::setAfsendelseModtager()
     * @uses ForsendelseModtagerType::setModtagerAdresse()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType $afsendelseModtager
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $modtagerAdresse
     */
    public function __construct(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType $afsendelseModtager = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $modtagerAdresse = null)
    {
        $this
            ->setAfsendelseModtager($afsendelseModtager)
            ->setModtagerAdresse($modtagerAdresse);
    }
    /**
     * Get AfsendelseModtager value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType|null
     */
    public function getAfsendelseModtager(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType
    {
        return $this->AfsendelseModtager;
    }
    /**
     * Set AfsendelseModtager value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType $afsendelseModtager
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType
     */
    public function setAfsendelseModtager(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\SlutbrugerIdentitetType $afsendelseModtager = null): self
    {
        $this->AfsendelseModtager = $afsendelseModtager;
        
        return $this;
    }
    /**
     * Get ModtagerAdresse value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType|null
     */
    public function getModtagerAdresse(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
    {
        return $this->ModtagerAdresse;
    }
    /**
     * Set ModtagerAdresse value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $modtagerAdresse
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType
     */
    public function setModtagerAdresse(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType $modtagerAdresse = null): self
    {
        $this->ModtagerAdresse = $modtagerAdresse;
        
        return $this;
    }
}
