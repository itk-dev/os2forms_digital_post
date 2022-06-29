<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ForsendelseIType StructType
 * @subpackage Structs
 */
class ForsendelseIType extends AbstractStructBase
{
    /**
     * The AfsendelseIdentifikator
     * Meta information extracted from the WSDL
     * - base: string
     * - maxLength: 38
     * - minLength: 1
     * - ref: fjernprint:AfsendelseIdentifikator
     * @var string|null
     */
    protected ?string $AfsendelseIdentifikator = null;
    /**
     * The ForsendelseTypeIdentifikator
     * Meta information extracted from the WSDL
     * - base: positiveInteger
     * - minOccurs: 0
     * - ref: fjernprint:ForsendelseTypeIdentifikator
     * @var int|null
     */
    protected ?int $ForsendelseTypeIdentifikator = null;
    /**
     * The ForsendelseModtager
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:ForsendelseModtager
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType $ForsendelseModtager = null;
    /**
     * The FilformatNavn
     * Meta information extracted from the WSDL
     * - base: string
     * - maxLength: 10
     * - ref: dkal:FilformatNavn
     * @var string|null
     */
    protected ?string $FilformatNavn = null;
    /**
     * The MeddelelseIndholdData
     * Meta information extracted from the WSDL
     * - ref: dkal:MeddelelseIndholdData
     * @var string|null
     */
    protected ?string $MeddelelseIndholdData = null;
    /**
     * The TransaktionsParametreI
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:TransaktionsParametreI
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType $TransaktionsParametreI = null;
    /**
     * The DokumentParametre
     * Meta information extracted from the WSDL
     * - ref: fjernprint:DokumentParametre
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType $DokumentParametre = null;
    /**
     * The KanalUafhaengigeParametreI
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:KanalUafhaengigeParametreI
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType $KanalUafhaengigeParametreI = null;
    /**
     * The PrintParametre
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:PrintParametre
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType $PrintParametre = null;
    /**
     * The DigitalPostParametre
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:DigitalPostParametre
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType $DigitalPostParametre = null;
    /**
     * The PostParametre
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:PostParametre
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType $PostParametre = null;
    /**
     * The BilagSamling
     * Meta information extracted from the WSDL
     * - minOccurs: 0
     * - ref: fjernprint:BilagSamling
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType $BilagSamling = null;
    /**
     * Constructor method for ForsendelseIType
     * @uses ForsendelseIType::setAfsendelseIdentifikator()
     * @uses ForsendelseIType::setForsendelseTypeIdentifikator()
     * @uses ForsendelseIType::setForsendelseModtager()
     * @uses ForsendelseIType::setFilformatNavn()
     * @uses ForsendelseIType::setMeddelelseIndholdData()
     * @uses ForsendelseIType::setTransaktionsParametreI()
     * @uses ForsendelseIType::setDokumentParametre()
     * @uses ForsendelseIType::setKanalUafhaengigeParametreI()
     * @uses ForsendelseIType::setPrintParametre()
     * @uses ForsendelseIType::setDigitalPostParametre()
     * @uses ForsendelseIType::setPostParametre()
     * @uses ForsendelseIType::setBilagSamling()
     * @param string $afsendelseIdentifikator
     * @param int $forsendelseTypeIdentifikator
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType $forsendelseModtager
     * @param string $filformatNavn
     * @param string $meddelelseIndholdData
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType $transaktionsParametreI
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType $dokumentParametre
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType $kanalUafhaengigeParametreI
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType $printParametre
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType $digitalPostParametre
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType $postParametre
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType $bilagSamling
     */
    public function __construct(?string $afsendelseIdentifikator = null, ?int $forsendelseTypeIdentifikator = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType $forsendelseModtager = null, ?string $filformatNavn = null, ?string $meddelelseIndholdData = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType $transaktionsParametreI = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType $dokumentParametre = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType $kanalUafhaengigeParametreI = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType $printParametre = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType $digitalPostParametre = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType $postParametre = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType $bilagSamling = null)
    {
        $this
            ->setAfsendelseIdentifikator($afsendelseIdentifikator)
            ->setForsendelseTypeIdentifikator($forsendelseTypeIdentifikator)
            ->setForsendelseModtager($forsendelseModtager)
            ->setFilformatNavn($filformatNavn)
            ->setMeddelelseIndholdData($meddelelseIndholdData)
            ->setTransaktionsParametreI($transaktionsParametreI)
            ->setDokumentParametre($dokumentParametre)
            ->setKanalUafhaengigeParametreI($kanalUafhaengigeParametreI)
            ->setPrintParametre($printParametre)
            ->setDigitalPostParametre($digitalPostParametre)
            ->setPostParametre($postParametre)
            ->setBilagSamling($bilagSamling);
    }
    /**
     * Get AfsendelseIdentifikator value
     * @return string|null
     */
    public function getAfsendelseIdentifikator(): ?string
    {
        return $this->AfsendelseIdentifikator;
    }
    /**
     * Set AfsendelseIdentifikator value
     * @param string $afsendelseIdentifikator
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setAfsendelseIdentifikator(?string $afsendelseIdentifikator = null): self
    {
        // validation for constraint: string
        if (!is_null($afsendelseIdentifikator) && !is_string($afsendelseIdentifikator)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($afsendelseIdentifikator, true), gettype($afsendelseIdentifikator)), __LINE__);
        }
        // validation for constraint: maxLength(38)
        if (!is_null($afsendelseIdentifikator) && mb_strlen((string) $afsendelseIdentifikator) > 38) {
            throw new InvalidArgumentException(sprintf('Invalid length of %s, the number of characters/octets contained by the literal must be less than or equal to 38', mb_strlen((string) $afsendelseIdentifikator)), __LINE__);
        }
        // validation for constraint: minLength(1)
        if (!is_null($afsendelseIdentifikator) && mb_strlen((string) $afsendelseIdentifikator) < 1) {
            throw new InvalidArgumentException(sprintf('Invalid length of %s, the number of characters/octets contained by the literal must be greater than or equal to 1', mb_strlen((string) $afsendelseIdentifikator)), __LINE__);
        }
        $this->AfsendelseIdentifikator = $afsendelseIdentifikator;
        
        return $this;
    }
    /**
     * Get ForsendelseTypeIdentifikator value
     * @return int|null
     */
    public function getForsendelseTypeIdentifikator(): ?int
    {
        return $this->ForsendelseTypeIdentifikator;
    }
    /**
     * Set ForsendelseTypeIdentifikator value
     * @param int $forsendelseTypeIdentifikator
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setForsendelseTypeIdentifikator(?int $forsendelseTypeIdentifikator = null): self
    {
        // validation for constraint: int
        if (!is_null($forsendelseTypeIdentifikator) && !(is_int($forsendelseTypeIdentifikator) || ctype_digit($forsendelseTypeIdentifikator))) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide an integer value, %s given', var_export($forsendelseTypeIdentifikator, true), gettype($forsendelseTypeIdentifikator)), __LINE__);
        }
        $this->ForsendelseTypeIdentifikator = $forsendelseTypeIdentifikator;
        
        return $this;
    }
    /**
     * Get ForsendelseModtager value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType|null
     */
    public function getForsendelseModtager(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType
    {
        return $this->ForsendelseModtager;
    }
    /**
     * Set ForsendelseModtager value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType $forsendelseModtager
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setForsendelseModtager(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseModtagerType $forsendelseModtager = null): self
    {
        $this->ForsendelseModtager = $forsendelseModtager;
        
        return $this;
    }
    /**
     * Get FilformatNavn value
     * @return string|null
     */
    public function getFilformatNavn(): ?string
    {
        return $this->FilformatNavn;
    }
    /**
     * Set FilformatNavn value
     * @param string $filformatNavn
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setFilformatNavn(?string $filformatNavn = null): self
    {
        // validation for constraint: string
        if (!is_null($filformatNavn) && !is_string($filformatNavn)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($filformatNavn, true), gettype($filformatNavn)), __LINE__);
        }
        // validation for constraint: maxLength(10)
        if (!is_null($filformatNavn) && mb_strlen((string) $filformatNavn) > 10) {
            throw new InvalidArgumentException(sprintf('Invalid length of %s, the number of characters/octets contained by the literal must be less than or equal to 10', mb_strlen((string) $filformatNavn)), __LINE__);
        }
        $this->FilformatNavn = $filformatNavn;
        
        return $this;
    }
    /**
     * Get MeddelelseIndholdData value
     * @return string|null
     */
    public function getMeddelelseIndholdData(): ?string
    {
        return $this->MeddelelseIndholdData;
    }
    /**
     * Set MeddelelseIndholdData value
     * @param string $meddelelseIndholdData
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setMeddelelseIndholdData(?string $meddelelseIndholdData = null): self
    {
        // validation for constraint: string
        if (!is_null($meddelelseIndholdData) && !is_string($meddelelseIndholdData)) {
            throw new InvalidArgumentException(sprintf('Invalid value %s, please provide a string, %s given', var_export($meddelelseIndholdData, true), gettype($meddelelseIndholdData)), __LINE__);
        }
        $this->MeddelelseIndholdData = $meddelelseIndholdData;
        
        return $this;
    }
    /**
     * Get TransaktionsParametreI value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType|null
     */
    public function getTransaktionsParametreI(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType
    {
        return $this->TransaktionsParametreI;
    }
    /**
     * Set TransaktionsParametreI value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType $transaktionsParametreI
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setTransaktionsParametreI(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TransaktionsParametreIType $transaktionsParametreI = null): self
    {
        $this->TransaktionsParametreI = $transaktionsParametreI;
        
        return $this;
    }
    /**
     * Get DokumentParametre value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType|null
     */
    public function getDokumentParametre(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType
    {
        return $this->DokumentParametre;
    }
    /**
     * Set DokumentParametre value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType $dokumentParametre
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setDokumentParametre(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DokumentParametreType $dokumentParametre = null): self
    {
        $this->DokumentParametre = $dokumentParametre;
        
        return $this;
    }
    /**
     * Get KanalUafhaengigeParametreI value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType|null
     */
    public function getKanalUafhaengigeParametreI(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType
    {
        return $this->KanalUafhaengigeParametreI;
    }
    /**
     * Set KanalUafhaengigeParametreI value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType $kanalUafhaengigeParametreI
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setKanalUafhaengigeParametreI(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\KanalUafhaengigeParametreIType $kanalUafhaengigeParametreI = null): self
    {
        $this->KanalUafhaengigeParametreI = $kanalUafhaengigeParametreI;
        
        return $this;
    }
    /**
     * Get PrintParametre value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType|null
     */
    public function getPrintParametre(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType
    {
        return $this->PrintParametre;
    }
    /**
     * Set PrintParametre value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType $printParametre
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setPrintParametre(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintParametreType $printParametre = null): self
    {
        $this->PrintParametre = $printParametre;
        
        return $this;
    }
    /**
     * Get DigitalPostParametre value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType|null
     */
    public function getDigitalPostParametre(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType
    {
        return $this->DigitalPostParametre;
    }
    /**
     * Set DigitalPostParametre value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType $digitalPostParametre
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setDigitalPostParametre(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\DigitalPostParametreType $digitalPostParametre = null): self
    {
        $this->DigitalPostParametre = $digitalPostParametre;
        
        return $this;
    }
    /**
     * Get PostParametre value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType|null
     */
    public function getPostParametre(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType
    {
        return $this->PostParametre;
    }
    /**
     * Set PostParametre value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType $postParametre
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setPostParametre(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PostParametreType $postParametre = null): self
    {
        $this->PostParametre = $postParametre;
        
        return $this;
    }
    /**
     * Get BilagSamling value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType|null
     */
    public function getBilagSamling(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType
    {
        return $this->BilagSamling;
    }
    /**
     * Set BilagSamling value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType $bilagSamling
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\ForsendelseIType
     */
    public function setBilagSamling(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BilagSamlingType $bilagSamling = null): self
    {
        $this->BilagSamling = $bilagSamling;
        
        return $this;
    }
}
