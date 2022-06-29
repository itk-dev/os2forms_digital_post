<?php

declare(strict_types=1);

namespace ItkDev\OS2Forms_Digital_Post\PrintService\StructType;

use InvalidArgumentException;
use WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PrintAfsendBrevRequestType StructType
 * @subpackage Structs
 */
class PrintAfsendBrevRequestType extends AbstractStructBase
{
    /**
     * The BrevSPBody
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 1
     * @var \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
     */
    protected \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType $BrevSPBody;
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
     * Constructor method for PrintAfsendBrevRequestType
     * @uses PrintAfsendBrevRequestType::setBrevSPBody()
     * @uses PrintAfsendBrevRequestType::setInvocationContext()
     * @uses PrintAfsendBrevRequestType::setAuthorityContext()
     * @uses PrintAfsendBrevRequestType::setCallContext()
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType $brevSPBody
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext
     */
    public function __construct(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType $brevSPBody, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\InvocationContextType $invocationContext = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\AuthorityContextType $authorityContext = null, ?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext = null)
    {
        $this
            ->setBrevSPBody($brevSPBody)
            ->setInvocationContext($invocationContext)
            ->setAuthorityContext($authorityContext)
            ->setCallContext($callContext);
    }
    /**
     * Get BrevSPBody value
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
     */
    public function getBrevSPBody(): \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType
    {
        return $this->BrevSPBody;
    }
    /**
     * Set BrevSPBody value
     * @param \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType $brevSPBody
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType
     */
    public function setBrevSPBody(\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\BrevSPBodyType $brevSPBody): self
    {
        $this->BrevSPBody = $brevSPBody;
        
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
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType
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
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType
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
     * @return \ItkDev\OS2Forms_Digital_Post\PrintService\StructType\PrintAfsendBrevRequestType
     */
    public function setCallContext(?\ItkDev\OS2Forms_Digital_Post\PrintService\StructType\CallContextType $callContext = null): self
    {
        $this->CallContext = $callContext;
        
        return $this;
    }
}
