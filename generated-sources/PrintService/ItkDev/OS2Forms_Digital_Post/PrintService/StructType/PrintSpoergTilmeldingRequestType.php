<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PrintSpoergTilmeldingRequestType StructType
 * @subpackage Structs
 */
class PrintSpoergTilmeldingRequestType extends AbstractStructBase
{
    /**
     * The TilmeldingRequest
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType
     */
    protected \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType $TilmeldingRequest;
    /**
     * The InvocationContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: invctx:InvocationContext
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $InvocationContext = null;
    /**
     * The AuthorityContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: authctx:AuthorityContext
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $AuthorityContext = null;
    /**
     * The CallContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: callctx:CallContext
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType|null
     */
    protected ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $CallContext = null;
    /**
     * Constructor method for PrintSpoergTilmeldingRequestType
     * @uses PrintSpoergTilmeldingRequestType::setTilmeldingRequest()
     * @uses PrintSpoergTilmeldingRequestType::setInvocationContext()
     * @uses PrintSpoergTilmeldingRequestType::setAuthorityContext()
     * @uses PrintSpoergTilmeldingRequestType::setCallContext()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType $tilmeldingRequest
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext
     */
    public function __construct(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType $tilmeldingRequest, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext = null)
    {
        $this
            ->setTilmeldingRequest($tilmeldingRequest)
            ->setInvocationContext($invocationContext)
            ->setAuthorityContext($authorityContext)
            ->setCallContext($callContext);
    }
    /**
     * Get TilmeldingRequest value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType
     */
    public function getTilmeldingRequest(): \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType
    {
        return $this->TilmeldingRequest;
    }
    /**
     * Set TilmeldingRequest value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType $tilmeldingRequest
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType
     */
    public function setTilmeldingRequest(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\TilmeldingRequestType $tilmeldingRequest): self
    {
        $this->TilmeldingRequest = $tilmeldingRequest;
        
        return $this;
    }
    /**
     * Get InvocationContext value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType|null
     */
    public function getInvocationContext(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType
    {
        return $this->InvocationContext;
    }
    /**
     * Set InvocationContext value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType
     */
    public function setInvocationContext(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext = null): self
    {
        $this->InvocationContext = $invocationContext;
        
        return $this;
    }
    /**
     * Get AuthorityContext value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType|null
     */
    public function getAuthorityContext(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType
    {
        return $this->AuthorityContext;
    }
    /**
     * Set AuthorityContext value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType
     */
    public function setAuthorityContext(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext = null): self
    {
        $this->AuthorityContext = $authorityContext;
        
        return $this;
    }
    /**
     * Get CallContext value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType|null
     */
    public function getCallContext(): ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType
    {
        return $this->CallContext;
    }
    /**
     * Set CallContext value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintSpoergTilmeldingRequestType
     */
    public function setCallContext(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext = null): self
    {
        $this->CallContext = $callContext;
        
        return $this;
    }
}
