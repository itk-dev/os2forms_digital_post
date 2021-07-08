<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ErrorListType StructType
 * @subpackage Structs
 */
class ErrorListType extends AbstractStructBase
{
    /**
     * The Error
     * Meta information extracted from the WSDL
     * - maxOccurs: unbounded
     * - minOccurs: 1
     * @var \Drupal\os2forms_digital_post\Client\StructType\ErrorType[]
     */
    protected array $Error = [];
    /**
     * Constructor method for ErrorListType
     * @uses ErrorListType::setError()
     * @param \Drupal\os2forms_digital_post\Client\StructType\ErrorType[] $error
     */
    public function __construct(array $error)
    {
        $this
            ->setError($error);
    }
    /**
     * Get Error value
     * @return \Drupal\os2forms_digital_post\Client\StructType\ErrorType[]
     */
    public function getError(): array
    {
        return $this->Error;
    }
    /**
     * This method is responsible for validating the values passed to the setError method
     * This method is willingly generated in order to preserve the one-line inline validation within the setError method
     * @param array $values
     * @return string A non-empty message if the values does not match the validation rules
     */
    public static function validateErrorForArrayConstraintsFromSetError(array $values = []): string
    {
        $message = '';
        $invalidValues = [];
        foreach ($values as $errorListTypeErrorItem) {
            // validation for constraint: itemType
            if (!$errorListTypeErrorItem instanceof \Drupal\os2forms_digital_post\Client\StructType\ErrorType) {
                $invalidValues[] = is_object($errorListTypeErrorItem) ? get_class($errorListTypeErrorItem) : sprintf('%s(%s)', gettype($errorListTypeErrorItem), var_export($errorListTypeErrorItem, true));
            }
        }
        if (!empty($invalidValues)) {
            $message = sprintf('The Error property can only contain items of type \Drupal\os2forms_digital_post\Client\StructType\ErrorType, %s given', is_object($invalidValues) ? get_class($invalidValues) : (is_array($invalidValues) ? implode(', ', $invalidValues) : gettype($invalidValues)));
        }
        unset($invalidValues);
        
        return $message;
    }
    /**
     * Set Error value
     * @throws InvalidArgumentException
     * @param \Drupal\os2forms_digital_post\Client\StructType\ErrorType[] $error
     * @return \Drupal\os2forms_digital_post\Client\StructType\ErrorListType
     */
    public function setError(array $error): self
    {
        // validation for constraint: array
        if ('' !== ($errorArrayErrorMessage = self::validateErrorForArrayConstraintsFromSetError($error))) {
            throw new InvalidArgumentException($errorArrayErrorMessage, __LINE__);
        }
        $this->Error = $error;
        
        return $this;
    }
    /**
     * Add item to Error value
     * @throws InvalidArgumentException
     * @param \Drupal\os2forms_digital_post\Client\StructType\ErrorType $item
     * @return \Drupal\os2forms_digital_post\Client\StructType\ErrorListType
     */
    public function addToError(\Drupal\os2forms_digital_post\Client\StructType\ErrorType $item): self
    {
        // validation for constraint: itemType
        if (!$item instanceof \Drupal\os2forms_digital_post\Client\StructType\ErrorType) {
            throw new InvalidArgumentException(sprintf('The Error property can only contain items of type \Drupal\os2forms_digital_post\Client\StructType\ErrorType, %s given', is_object($item) ? get_class($item) : (is_array($item) ? implode(', ', $item) : gettype($item))), __LINE__);
        }
        $this->Error[] = $item;
        
        return $this;
    }
}
