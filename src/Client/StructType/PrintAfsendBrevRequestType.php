<?php

declare(strict_types=1);

namespace Drupal\os2forms_digital_post\Client\StructType;

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
     * @var \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
     */
    protected \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType $BrevSPBody;
    /**
     * The InvocationContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: invctx:InvocationContext
     * @var \Drupal\os2forms_digital_post\Client\StructType\InvocationContextType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\InvocationContextType $InvocationContext = null;
    /**
     * The AuthorityContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: authctx:AuthorityContext
     * @var \Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType $AuthorityContext = null;
    /**
     * The CallContext
     * Meta information extracted from the WSDL
     * - maxOccurs: 1
     * - minOccurs: 0
     * - ref: callctx:CallContext
     * @var \Drupal\os2forms_digital_post\Client\StructType\CallContextType|null
     */
    protected ?\Drupal\os2forms_digital_post\Client\StructType\CallContextType $CallContext = null;
    /**
     * Constructor method for PrintAfsendBrevRequestType
     * @uses PrintAfsendBrevRequestType::setBrevSPBody()
     * @uses PrintAfsendBrevRequestType::setInvocationContext()
     * @uses PrintAfsendBrevRequestType::setAuthorityContext()
     * @uses PrintAfsendBrevRequestType::setCallContext()
     * @param \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType $brevSPBody
     * @param \Drupal\os2forms_digital_post\Client\StructType\InvocationContextType $invocationContext
     * @param \Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType $authorityContext
     * @param \Drupal\os2forms_digital_post\Client\StructType\CallContextType $callContext
     */
    public function __construct(\Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType $brevSPBody, ?\Drupal\os2forms_digital_post\Client\StructType\InvocationContextType $invocationContext = null, ?\Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType $authorityContext = null, ?\Drupal\os2forms_digital_post\Client\StructType\CallContextType $callContext = null)
    {
        $this
            ->setBrevSPBody($brevSPBody)
            ->setInvocationContext($invocationContext)
            ->setAuthorityContext($authorityContext)
            ->setCallContext($callContext);
    }
    /**
     * Get BrevSPBody value
     * @return \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
     */
    public function getBrevSPBody(): \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType
    {
        return $this->BrevSPBody;
    }
    /**
     * Set BrevSPBody value
     * @param \Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType $brevSPBody
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType
     */
    public function setBrevSPBody(\Drupal\os2forms_digital_post\Client\StructType\BrevSPBodyType $brevSPBody): self
    {
        $this->BrevSPBody = $brevSPBody;
        
        return $this;
    }
    /**
     * Get InvocationContext value
     * @return \Drupal\os2forms_digital_post\Client\StructType\InvocationContextType|null
     */
    public function getInvocationContext(): ?\Drupal\os2forms_digital_post\Client\StructType\InvocationContextType
    {
        return $this->InvocationContext;
    }
    /**
     * Set InvocationContext value
     * @param \Drupal\os2forms_digital_post\Client\StructType\InvocationContextType $invocationContext
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType
     */
    public function setInvocationContext(?\Drupal\os2forms_digital_post\Client\StructType\InvocationContextType $invocationContext = null): self
    {
        $this->InvocationContext = $invocationContext;
        
        return $this;
    }
    /**
     * Get AuthorityContext value
     * @return \Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType|null
     */
    public function getAuthorityContext(): ?\Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType
    {
        return $this->AuthorityContext;
    }
    /**
     * Set AuthorityContext value
     * @param \Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType $authorityContext
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType
     */
    public function setAuthorityContext(?\Drupal\os2forms_digital_post\Client\StructType\AuthorityContextType $authorityContext = null): self
    {
        $this->AuthorityContext = $authorityContext;
        
        return $this;
    }
    /**
     * Get CallContext value
     * @return \Drupal\os2forms_digital_post\Client\StructType\CallContextType|null
     */
    public function getCallContext(): ?\Drupal\os2forms_digital_post\Client\StructType\CallContextType
    {
        return $this->CallContext;
    }
    /**
     * Set CallContext value
     * @param \Drupal\os2forms_digital_post\Client\StructType\CallContextType $callContext
     * @return \Drupal\os2forms_digital_post\Client\StructType\PrintAfsendBrevRequestType
     */
    public function setCallContext(?\Drupal\os2forms_digital_post\Client\StructType\CallContextType $callContext = null): self
    {
        $this->CallContext = $callContext;
        
        return $this;
    }
}
