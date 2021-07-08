<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for KontaktOplysningType StructType
 * @subpackage Structs
 */
class KontaktOplysningType extends AbstractStructBase
{
    /**
     * The PersonName
     * Meta information extracted from the WSDL
     * - ref: itst:PersonName
     * @var string|null
     */
    protected ?string $PersonName = null;
    /**
     * The CoNavn
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: fjernprint:CoNavn
     * @var string|null
     */
    protected ?string $CoNavn = null;
    /**
     * The StreetName
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - ref: dkcc2005:StreetName
     * @var string|null
     */
    protected ?string $StreetName = null;
    /**
     * The StreetBuildingIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - ref: dkcc:StreetBuildingIdentifier
     * @var string|null
     */
    protected ?string $StreetBuildingIdentifier = null;
    /**
     * The FloorIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc:FloorIdentifier
     * @var string|null
     */
    protected ?string $FloorIdentifier = null;
    /**
     * The SuiteIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc:SuiteIdentifier
     * @var string|null
     */
    protected ?string $SuiteIdentifier = null;
    /**
     * The MailDeliverySublocationIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc:MailDeliverySublocationIdentifier
     * @var string|null
     */
    protected ?string $MailDeliverySublocationIdentifier = null;
    /**
     * The PostCodeIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005:PostCodeIdentifier
     * @var string|null
     */
    protected ?string $PostCodeIdentifier = null;
    /**
     * The DistrictSubdivisionIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005:DistrictSubdivisionIdentifier
     * @var string|null
     */
    protected ?string $DistrictSubdivisionIdentifier = null;
    /**
     * The PostOfficeBoxIdentifier
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-2:PostOfficeBoxIdentifier
     * @var int|null
     */
    protected ?int $PostOfficeBoxIdentifier = null;
    /**
     * The PostalAddressFirstLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - ref: dkcc2005-3:PostalAddressFirstLineText
     * @var string|null
     */
    protected ?string $PostalAddressFirstLineText = null;
    /**
     * The PostalAddressSecondLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-3:PostalAddressSecondLineText
     * @var string|null
     */
    protected ?string $PostalAddressSecondLineText = null;
    /**
     * The PostalAddressThirdLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-3:PostalAddressThirdLineText
     * @var string|null
     */
    protected ?string $PostalAddressThirdLineText = null;
    /**
     * The PostalAddressFourthLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-3:PostalAddressFourthLineText
     * @var string|null
     */
    protected ?string $PostalAddressFourthLineText = null;
    /**
     * The PostalAddressFifthLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-3:PostalAddressFifthLineText
     * @var string|null
     */
    protected ?string $PostalAddressFifthLineText = null;
    /**
     * The PostalAddressSixthLineText
     * Meta information extracted from the WSDL
     * - choice: CoNavn | StreetName | StreetBuildingIdentifier | FloorIdentifier | SuiteIdentifier | MailDeliverySublocationIdentifier | PostCodeIdentifier | DistrictSubdivisionIdentifier | PostOfficeBoxIdentifier | PostalAddressFirstLineText |
     * PostalAddressSecondLineText | PostalAddressThirdLineText | PostalAddressFourthLineText | PostalAddressFifthLineText | PostalAddressSixthLineText
     * - choiceMaxOccurs: 1
     * - choiceMinOccurs: 1
     * - minOccurs: 0
     * - ref: dkcc2005-3:PostalAddressSixthLineText
     * @var string|null
     */
    protected ?string $PostalAddressSixthLineText = null;
    /**
     * The CountryIdentificationCode
     * Meta information extracted from the WSDL
     * - ref: dkcc:CountryIdentificationCode
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType $CountryIdentificationCode = null;
    /**
     * Constructor method for KontaktOplysningType
     * @uses KontaktOplysningType::setPersonName()
     * @uses KontaktOplysningType::setCoNavn()
     * @uses KontaktOplysningType::setStreetName()
     * @uses KontaktOplysningType::setStreetBuildingIdentifier()
     * @uses KontaktOplysningType::setFloorIdentifier()
     * @uses KontaktOplysningType::setSuiteIdentifier()
     * @uses KontaktOplysningType::setMailDeliverySublocationIdentifier()
     * @uses KontaktOplysningType::setPostCodeIdentifier()
     * @uses KontaktOplysningType::setDistrictSubdivisionIdentifier()
     * @uses KontaktOplysningType::setPostOfficeBoxIdentifier()
     * @uses KontaktOplysningType::setPostalAddressFirstLineText()
     * @uses KontaktOplysningType::setPostalAddressSecondLineText()
     * @uses KontaktOplysningType::setPostalAddressThirdLineText()
     * @uses KontaktOplysningType::setPostalAddressFourthLineText()
     * @uses KontaktOplysningType::setPostalAddressFifthLineText()
     * @uses KontaktOplysningType::setPostalAddressSixthLineText()
     * @uses KontaktOplysningType::setCountryIdentificationCode()
     * @param string $personName
     * @param string $coNavn
     * @param string $streetName
     * @param string $streetBuildingIdentifier
     * @param string $floorIdentifier
     * @param string $suiteIdentifier
     * @param string $mailDeliverySublocationIdentifier
     * @param string $postCodeIdentifier
     * @param string $districtSubdivisionIdentifier
     * @param int $postOfficeBoxIdentifier
     * @param string $postalAddressFirstLineText
     * @param string $postalAddressSecondLineText
     * @param string $postalAddressThirdLineText
     * @param string $postalAddressFourthLineText
     * @param string $postalAddressFifthLineText
     * @param string $postalAddressSixthLineText
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType $countryIdentificationCode
     */
    public function __construct(?string $personName = null, ?string $coNavn = null, ?string $streetName = null, ?string $streetBuildingIdentifier = null, ?string $floorIdentifier = null, ?string $suiteIdentifier = null, ?string $mailDeliverySublocationIdentifier = null, ?string $postCodeIdentifier = null, ?string $districtSubdivisionIdentifier = null, ?int $postOfficeBoxIdentifier = null, ?string $postalAddressFirstLineText = null, ?string $postalAddressSecondLineText = null, ?string $postalAddressThirdLineText = null, ?string $postalAddressFourthLineText = null, ?string $postalAddressFifthLineText = null, ?string $postalAddressSixthLineText = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType $countryIdentificationCode = null)
    {
        $this
            ->setPersonName($personName)
            ->setCoNavn($coNavn)
            ->setStreetName($streetName)
            ->setStreetBuildingIdentifier($streetBuildingIdentifier)
            ->setFloorIdentifier($floorIdentifier)
            ->setSuiteIdentifier($suiteIdentifier)
            ->setMailDeliverySublocationIdentifier($mailDeliverySublocationIdentifier)
            ->setPostCodeIdentifier($postCodeIdentifier)
            ->setDistrictSubdivisionIdentifier($districtSubdivisionIdentifier)
            ->setPostOfficeBoxIdentifier($postOfficeBoxIdentifier)
            ->setPostalAddressFirstLineText($postalAddressFirstLineText)
            ->setPostalAddressSecondLineText($postalAddressSecondLineText)
            ->setPostalAddressThirdLineText($postalAddressThirdLineText)
            ->setPostalAddressFourthLineText($postalAddressFourthLineText)
            ->setPostalAddressFifthLineText($postalAddressFifthLineText)
            ->setPostalAddressSixthLineText($postalAddressSixthLineText)
            ->setCountryIdentificationCode($countryIdentificationCode);
    }
    /**
     * Get PersonName value
     * @return string|null
     */
    public function getPersonName(): ?string
    {
        return $this->PersonName;
    }
    /**
     * Set PersonName value
     * @param string $personName
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPersonName(?string $personName = null): self
    {
        // validation for constraint: string
        if (!is_null($personName) && !is_string($personName)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($personName, true), gettype($personName)), __LINE__);
        }
        $this->PersonName = $personName;
        
        return $this;
    }
    /**
     * Get CoNavn value
     * @return string|null
     */
    public function getCoNavn(): ?string
    {
        return isset($this->CoNavn) ? $this->CoNavn : null;
    }
    /**
     * This method is responsible for validating the value passed to the setCoNavn method
     * This method is willingly generated in order to preserve the one-line inline validation within the setCoNavn method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateCoNavnForChoiceConstraintsFromSetCoNavn($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property CoNavn can\'t be set as the property %s is already set. Only one property must be set among these properties: CoNavn, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set CoNavn value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $coNavn
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setCoNavn(?string $coNavn = null): self
    {
        // validation for constraint: string
        if (!is_null($coNavn) && !is_string($coNavn)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($coNavn, true), gettype($coNavn)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($coNavnChoiceErrorMessage = self::validateCoNavnForChoiceConstraintsFromSetCoNavn($coNavn))) {
            throw new InvalidArgumentException($coNavnChoiceErrorMessage, __LINE__);
        }
        if (is_null($coNavn) || (is_array($coNavn) && empty($coNavn))) {
            unset($this->CoNavn);
        } else {
            $this->CoNavn = $coNavn;
        }
        
        return $this;
    }
    /**
     * Get StreetName value
     * @return string|null
     */
    public function getStreetName(): ?string
    {
        return isset($this->StreetName) ? $this->StreetName : null;
    }
    /**
     * This method is responsible for validating the value passed to the setStreetName method
     * This method is willingly generated in order to preserve the one-line inline validation within the setStreetName method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateStreetNameForChoiceConstraintsFromSetStreetName($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property StreetName can\'t be set as the property %s is already set. Only one property must be set among these properties: StreetName, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set StreetName value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $streetName
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setStreetName(?string $streetName = null): self
    {
        // validation for constraint: string
        if (!is_null($streetName) && !is_string($streetName)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($streetName, true), gettype($streetName)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($streetNameChoiceErrorMessage = self::validateStreetNameForChoiceConstraintsFromSetStreetName($streetName))) {
            throw new InvalidArgumentException($streetNameChoiceErrorMessage, __LINE__);
        }
        if (is_null($streetName) || (is_array($streetName) && empty($streetName))) {
            unset($this->StreetName);
        } else {
            $this->StreetName = $streetName;
        }
        
        return $this;
    }
    /**
     * Get StreetBuildingIdentifier value
     * @return string|null
     */
    public function getStreetBuildingIdentifier(): ?string
    {
        return isset($this->StreetBuildingIdentifier) ? $this->StreetBuildingIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setStreetBuildingIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setStreetBuildingIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateStreetBuildingIdentifierForChoiceConstraintsFromSetStreetBuildingIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property StreetBuildingIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: StreetBuildingIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set StreetBuildingIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $streetBuildingIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setStreetBuildingIdentifier(?string $streetBuildingIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($streetBuildingIdentifier) && !is_string($streetBuildingIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($streetBuildingIdentifier, true), gettype($streetBuildingIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($streetBuildingIdentifierChoiceErrorMessage = self::validateStreetBuildingIdentifierForChoiceConstraintsFromSetStreetBuildingIdentifier($streetBuildingIdentifier))) {
            throw new InvalidArgumentException($streetBuildingIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($streetBuildingIdentifier) || (is_array($streetBuildingIdentifier) && empty($streetBuildingIdentifier))) {
            unset($this->StreetBuildingIdentifier);
        } else {
            $this->StreetBuildingIdentifier = $streetBuildingIdentifier;
        }
        
        return $this;
    }
    /**
     * Get FloorIdentifier value
     * @return string|null
     */
    public function getFloorIdentifier(): ?string
    {
        return isset($this->FloorIdentifier) ? $this->FloorIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setFloorIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setFloorIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateFloorIdentifierForChoiceConstraintsFromSetFloorIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property FloorIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: FloorIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set FloorIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $floorIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setFloorIdentifier(?string $floorIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($floorIdentifier) && !is_string($floorIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($floorIdentifier, true), gettype($floorIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($floorIdentifierChoiceErrorMessage = self::validateFloorIdentifierForChoiceConstraintsFromSetFloorIdentifier($floorIdentifier))) {
            throw new InvalidArgumentException($floorIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($floorIdentifier) || (is_array($floorIdentifier) && empty($floorIdentifier))) {
            unset($this->FloorIdentifier);
        } else {
            $this->FloorIdentifier = $floorIdentifier;
        }
        
        return $this;
    }
    /**
     * Get SuiteIdentifier value
     * @return string|null
     */
    public function getSuiteIdentifier(): ?string
    {
        return isset($this->SuiteIdentifier) ? $this->SuiteIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setSuiteIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setSuiteIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateSuiteIdentifierForChoiceConstraintsFromSetSuiteIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property SuiteIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: SuiteIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set SuiteIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $suiteIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setSuiteIdentifier(?string $suiteIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($suiteIdentifier) && !is_string($suiteIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($suiteIdentifier, true), gettype($suiteIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($suiteIdentifierChoiceErrorMessage = self::validateSuiteIdentifierForChoiceConstraintsFromSetSuiteIdentifier($suiteIdentifier))) {
            throw new InvalidArgumentException($suiteIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($suiteIdentifier) || (is_array($suiteIdentifier) && empty($suiteIdentifier))) {
            unset($this->SuiteIdentifier);
        } else {
            $this->SuiteIdentifier = $suiteIdentifier;
        }
        
        return $this;
    }
    /**
     * Get MailDeliverySublocationIdentifier value
     * @return string|null
     */
    public function getMailDeliverySublocationIdentifier(): ?string
    {
        return isset($this->MailDeliverySublocationIdentifier) ? $this->MailDeliverySublocationIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setMailDeliverySublocationIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setMailDeliverySublocationIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateMailDeliverySublocationIdentifierForChoiceConstraintsFromSetMailDeliverySublocationIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property MailDeliverySublocationIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: MailDeliverySublocationIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set MailDeliverySublocationIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $mailDeliverySublocationIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setMailDeliverySublocationIdentifier(?string $mailDeliverySublocationIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($mailDeliverySublocationIdentifier) && !is_string($mailDeliverySublocationIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($mailDeliverySublocationIdentifier, true), gettype($mailDeliverySublocationIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($mailDeliverySublocationIdentifierChoiceErrorMessage = self::validateMailDeliverySublocationIdentifierForChoiceConstraintsFromSetMailDeliverySublocationIdentifier($mailDeliverySublocationIdentifier))) {
            throw new InvalidArgumentException($mailDeliverySublocationIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($mailDeliverySublocationIdentifier) || (is_array($mailDeliverySublocationIdentifier) && empty($mailDeliverySublocationIdentifier))) {
            unset($this->MailDeliverySublocationIdentifier);
        } else {
            $this->MailDeliverySublocationIdentifier = $mailDeliverySublocationIdentifier;
        }
        
        return $this;
    }
    /**
     * Get PostCodeIdentifier value
     * @return string|null
     */
    public function getPostCodeIdentifier(): ?string
    {
        return isset($this->PostCodeIdentifier) ? $this->PostCodeIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostCodeIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostCodeIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostCodeIdentifierForChoiceConstraintsFromSetPostCodeIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostCodeIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: PostCodeIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostCodeIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postCodeIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostCodeIdentifier(?string $postCodeIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($postCodeIdentifier) && !is_string($postCodeIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postCodeIdentifier, true), gettype($postCodeIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postCodeIdentifierChoiceErrorMessage = self::validatePostCodeIdentifierForChoiceConstraintsFromSetPostCodeIdentifier($postCodeIdentifier))) {
            throw new InvalidArgumentException($postCodeIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($postCodeIdentifier) || (is_array($postCodeIdentifier) && empty($postCodeIdentifier))) {
            unset($this->PostCodeIdentifier);
        } else {
            $this->PostCodeIdentifier = $postCodeIdentifier;
        }
        
        return $this;
    }
    /**
     * Get DistrictSubdivisionIdentifier value
     * @return string|null
     */
    public function getDistrictSubdivisionIdentifier(): ?string
    {
        return isset($this->DistrictSubdivisionIdentifier) ? $this->DistrictSubdivisionIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setDistrictSubdivisionIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setDistrictSubdivisionIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validateDistrictSubdivisionIdentifierForChoiceConstraintsFromSetDistrictSubdivisionIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property DistrictSubdivisionIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: DistrictSubdivisionIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set DistrictSubdivisionIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $districtSubdivisionIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setDistrictSubdivisionIdentifier(?string $districtSubdivisionIdentifier = null): self
    {
        // validation for constraint: string
        if (!is_null($districtSubdivisionIdentifier) && !is_string($districtSubdivisionIdentifier)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($districtSubdivisionIdentifier, true), gettype($districtSubdivisionIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($districtSubdivisionIdentifierChoiceErrorMessage = self::validateDistrictSubdivisionIdentifierForChoiceConstraintsFromSetDistrictSubdivisionIdentifier($districtSubdivisionIdentifier))) {
            throw new InvalidArgumentException($districtSubdivisionIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($districtSubdivisionIdentifier) || (is_array($districtSubdivisionIdentifier) && empty($districtSubdivisionIdentifier))) {
            unset($this->DistrictSubdivisionIdentifier);
        } else {
            $this->DistrictSubdivisionIdentifier = $districtSubdivisionIdentifier;
        }
        
        return $this;
    }
    /**
     * Get PostOfficeBoxIdentifier value
     * @return int|null
     */
    public function getPostOfficeBoxIdentifier(): ?int
    {
        return isset($this->PostOfficeBoxIdentifier) ? $this->PostOfficeBoxIdentifier : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostOfficeBoxIdentifier method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostOfficeBoxIdentifier method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostOfficeBoxIdentifierForChoiceConstraintsFromSetPostOfficeBoxIdentifier($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostOfficeBoxIdentifier can\'t be set as the property %s is already set. Only one property must be set among these properties: PostOfficeBoxIdentifier, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostOfficeBoxIdentifier value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param int $postOfficeBoxIdentifier
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostOfficeBoxIdentifier(?int $postOfficeBoxIdentifier = null): self
    {
        // validation for constraint: int
        if (!is_null($postOfficeBoxIdentifier) && !(is_int($postOfficeBoxIdentifier) || ctype_digit($postOfficeBoxIdentifier))) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide an integer value, %s given', var_export($postOfficeBoxIdentifier, true), gettype($postOfficeBoxIdentifier)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postOfficeBoxIdentifierChoiceErrorMessage = self::validatePostOfficeBoxIdentifierForChoiceConstraintsFromSetPostOfficeBoxIdentifier($postOfficeBoxIdentifier))) {
            throw new InvalidArgumentException($postOfficeBoxIdentifierChoiceErrorMessage, __LINE__);
        }
        if (is_null($postOfficeBoxIdentifier) || (is_array($postOfficeBoxIdentifier) && empty($postOfficeBoxIdentifier))) {
            unset($this->PostOfficeBoxIdentifier);
        } else {
            $this->PostOfficeBoxIdentifier = $postOfficeBoxIdentifier;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressFirstLineText value
     * @return string|null
     */
    public function getPostalAddressFirstLineText(): ?string
    {
        return isset($this->PostalAddressFirstLineText) ? $this->PostalAddressFirstLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressFirstLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressFirstLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressFirstLineTextForChoiceConstraintsFromSetPostalAddressFirstLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressFirstLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressFirstLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressFirstLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressFirstLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressFirstLineText(?string $postalAddressFirstLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressFirstLineText) && !is_string($postalAddressFirstLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressFirstLineText, true), gettype($postalAddressFirstLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressFirstLineTextChoiceErrorMessage = self::validatePostalAddressFirstLineTextForChoiceConstraintsFromSetPostalAddressFirstLineText($postalAddressFirstLineText))) {
            throw new InvalidArgumentException($postalAddressFirstLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressFirstLineText) || (is_array($postalAddressFirstLineText) && empty($postalAddressFirstLineText))) {
            unset($this->PostalAddressFirstLineText);
        } else {
            $this->PostalAddressFirstLineText = $postalAddressFirstLineText;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressSecondLineText value
     * @return string|null
     */
    public function getPostalAddressSecondLineText(): ?string
    {
        return isset($this->PostalAddressSecondLineText) ? $this->PostalAddressSecondLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressSecondLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressSecondLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressSecondLineTextForChoiceConstraintsFromSetPostalAddressSecondLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressSecondLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressSecondLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressSecondLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressSecondLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressSecondLineText(?string $postalAddressSecondLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressSecondLineText) && !is_string($postalAddressSecondLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressSecondLineText, true), gettype($postalAddressSecondLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressSecondLineTextChoiceErrorMessage = self::validatePostalAddressSecondLineTextForChoiceConstraintsFromSetPostalAddressSecondLineText($postalAddressSecondLineText))) {
            throw new InvalidArgumentException($postalAddressSecondLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressSecondLineText) || (is_array($postalAddressSecondLineText) && empty($postalAddressSecondLineText))) {
            unset($this->PostalAddressSecondLineText);
        } else {
            $this->PostalAddressSecondLineText = $postalAddressSecondLineText;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressThirdLineText value
     * @return string|null
     */
    public function getPostalAddressThirdLineText(): ?string
    {
        return isset($this->PostalAddressThirdLineText) ? $this->PostalAddressThirdLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressThirdLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressThirdLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressThirdLineTextForChoiceConstraintsFromSetPostalAddressThirdLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressThirdLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressThirdLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressThirdLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressThirdLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressThirdLineText(?string $postalAddressThirdLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressThirdLineText) && !is_string($postalAddressThirdLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressThirdLineText, true), gettype($postalAddressThirdLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressThirdLineTextChoiceErrorMessage = self::validatePostalAddressThirdLineTextForChoiceConstraintsFromSetPostalAddressThirdLineText($postalAddressThirdLineText))) {
            throw new InvalidArgumentException($postalAddressThirdLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressThirdLineText) || (is_array($postalAddressThirdLineText) && empty($postalAddressThirdLineText))) {
            unset($this->PostalAddressThirdLineText);
        } else {
            $this->PostalAddressThirdLineText = $postalAddressThirdLineText;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressFourthLineText value
     * @return string|null
     */
    public function getPostalAddressFourthLineText(): ?string
    {
        return isset($this->PostalAddressFourthLineText) ? $this->PostalAddressFourthLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressFourthLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressFourthLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressFourthLineTextForChoiceConstraintsFromSetPostalAddressFourthLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFifthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressFourthLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressFourthLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressFourthLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressFourthLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressFourthLineText(?string $postalAddressFourthLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressFourthLineText) && !is_string($postalAddressFourthLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressFourthLineText, true), gettype($postalAddressFourthLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressFourthLineTextChoiceErrorMessage = self::validatePostalAddressFourthLineTextForChoiceConstraintsFromSetPostalAddressFourthLineText($postalAddressFourthLineText))) {
            throw new InvalidArgumentException($postalAddressFourthLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressFourthLineText) || (is_array($postalAddressFourthLineText) && empty($postalAddressFourthLineText))) {
            unset($this->PostalAddressFourthLineText);
        } else {
            $this->PostalAddressFourthLineText = $postalAddressFourthLineText;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressFifthLineText value
     * @return string|null
     */
    public function getPostalAddressFifthLineText(): ?string
    {
        return isset($this->PostalAddressFifthLineText) ? $this->PostalAddressFifthLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressFifthLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressFifthLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressFifthLineTextForChoiceConstraintsFromSetPostalAddressFifthLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressSixthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressFifthLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressFifthLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressFifthLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressFifthLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressFifthLineText(?string $postalAddressFifthLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressFifthLineText) && !is_string($postalAddressFifthLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressFifthLineText, true), gettype($postalAddressFifthLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressFifthLineTextChoiceErrorMessage = self::validatePostalAddressFifthLineTextForChoiceConstraintsFromSetPostalAddressFifthLineText($postalAddressFifthLineText))) {
            throw new InvalidArgumentException($postalAddressFifthLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressFifthLineText) || (is_array($postalAddressFifthLineText) && empty($postalAddressFifthLineText))) {
            unset($this->PostalAddressFifthLineText);
        } else {
            $this->PostalAddressFifthLineText = $postalAddressFifthLineText;
        }
        
        return $this;
    }
    /**
     * Get PostalAddressSixthLineText value
     * @return string|null
     */
    public function getPostalAddressSixthLineText(): ?string
    {
        return isset($this->PostalAddressSixthLineText) ? $this->PostalAddressSixthLineText : null;
    }
    /**
     * This method is responsible for validating the value passed to the setPostalAddressSixthLineText method
     * This method is willingly generated in order to preserve the one-line inline validation within the setPostalAddressSixthLineText method
     * This has to validate that the property which is being set is the only one among the given choices
     * @param mixed $value
     * @return string A non-empty message if the values does not match the validation rules
     */
    public function validatePostalAddressSixthLineTextForChoiceConstraintsFromSetPostalAddressSixthLineText($value): string
    {
        $message = '';
        if (is_null($value)) {
            return $message;
        }
        $properties = [
            'CoNavn',
            'StreetName',
            'StreetBuildingIdentifier',
            'FloorIdentifier',
            'SuiteIdentifier',
            'MailDeliverySublocationIdentifier',
            'PostCodeIdentifier',
            'DistrictSubdivisionIdentifier',
            'PostOfficeBoxIdentifier',
            'PostalAddressFirstLineText',
            'PostalAddressSecondLineText',
            'PostalAddressThirdLineText',
            'PostalAddressFourthLineText',
            'PostalAddressFifthLineText',
            'PostCodeIdentifier',
        ];
        try {
            foreach ($properties as $property) {
                if (isset($this->{$property})) {
                    throw new InvalidArgumentException(sprintf('The property PostalAddressSixthLineText can\'t be set as the property %s is already set. Only one property must be set among these properties: PostalAddressSixthLineText, %s.', $property, implode(', ', $properties)), __LINE__);
                }
            }
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }
    /**
     * Set PostalAddressSixthLineText value
     * This property belongs to a choice that allows only one property to exist. It is
     * therefore removable from the request, consequently if the value assigned to this
     * property is null, the property is removed from this object
     * @throws InvalidArgumentException
     * @param string $postalAddressSixthLineText
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setPostalAddressSixthLineText(?string $postalAddressSixthLineText = null): self
    {
        // validation for constraint: string
        if (!is_null($postalAddressSixthLineText) && !is_string($postalAddressSixthLineText)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($postalAddressSixthLineText, true), gettype($postalAddressSixthLineText)), __LINE__);
        }
        // validation for constraint: choice(CoNavn, StreetName, StreetBuildingIdentifier, FloorIdentifier, SuiteIdentifier, MailDeliverySublocationIdentifier, PostCodeIdentifier, DistrictSubdivisionIdentifier, PostOfficeBoxIdentifier, PostalAddressFirstLineText, PostalAddressSecondLineText, PostalAddressThirdLineText, PostalAddressFourthLineText, PostalAddressFifthLineText, PostalAddressSixthLineText)
        if ('' !== ($postalAddressSixthLineTextChoiceErrorMessage = self::validatePostalAddressSixthLineTextForChoiceConstraintsFromSetPostalAddressSixthLineText($postalAddressSixthLineText))) {
            throw new InvalidArgumentException($postalAddressSixthLineTextChoiceErrorMessage, __LINE__);
        }
        if (is_null($postalAddressSixthLineText) || (is_array($postalAddressSixthLineText) && empty($postalAddressSixthLineText))) {
            unset($this->PostalAddressSixthLineText);
        } else {
            $this->PostalAddressSixthLineText = $postalAddressSixthLineText;
        }
        
        return $this;
    }
    /**
     * Get CountryIdentificationCode value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType|null
     */
    public function getCountryIdentificationCode(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType
    {
        return $this->CountryIdentificationCode;
    }
    /**
     * Set CountryIdentificationCode value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType $countryIdentificationCode
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KontaktOplysningType
     */
    public function setCountryIdentificationCode(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CountryIdentificationCodeType $countryIdentificationCode = null): self
    {
        $this->CountryIdentificationCode = $countryIdentificationCode;
        
        return $this;
    }
}
