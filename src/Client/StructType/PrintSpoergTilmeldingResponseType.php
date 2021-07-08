<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PrintSpoergTilmeldingResponseType StructType
 * @subpackage Structs
 */
class PrintSpoergTilmeldingResponseType extends AbstractStructBase
{
    /**
     * The tilmeldt
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var bool
     */
    protected bool $tilmeldt;
    /**
     * Constructor method for PrintSpoergTilmeldingResponseType
     * @uses PrintSpoergTilmeldingResponseType::setTilmeldt()
     * @param bool $tilmeldt
     */
    public function __construct(bool $tilmeldt)
    {
        $this
            ->setTilmeldt($tilmeldt);
    }
    /**
     * Get tilmeldt value
     * @return bool
     */
    public function getTilmeldt(): bool
    {
        return $this->tilmeldt;
    }
    /**
     * Set tilmeldt value
     * @param bool $tilmeldt
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintSpoergTilmeldingResponseType
     */
    public function setTilmeldt(bool $tilmeldt): self
    {
        // validation for constraint: boolean
        if (!is_null($tilmeldt) && !is_bool($tilmeldt)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a bool, %s given', var_export($tilmeldt, true), gettype($tilmeldt)), __LINE__);
        }
        $this->tilmeldt = $tilmeldt;
        
        return $this;
    }
}
