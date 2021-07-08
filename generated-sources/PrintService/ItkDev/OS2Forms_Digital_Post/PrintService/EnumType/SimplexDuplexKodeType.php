<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\EnumType;

use WsdlToPhp\PackageBase\AbstractStructEnumBase;

/**
 * This class stands for SimplexDuplexKodeType EnumType
 * @subpackage Enumerations
 */
class SimplexDuplexKodeType extends AbstractStructEnumBase
{
    /**
     * Constant for value 'Simplex'
     * @return string 'Simplex'
     */
    const VALUE_SIMPLEX = 'Simplex';
    /**
     * Constant for value 'Duplex'
     * @return string 'Duplex'
     */
    const VALUE_DUPLEX = 'Duplex';
    /**
     * Return allowed values
     * @uses self::VALUE_SIMPLEX
     * @uses self::VALUE_DUPLEX
     * @return string[]
     */
    public static function getValidValues(): array
    {
        return [
            self::VALUE_SIMPLEX,
            self::VALUE_DUPLEX,
        ];
    }
}
