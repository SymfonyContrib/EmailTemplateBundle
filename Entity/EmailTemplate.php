<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 *
 */
class EmailTemplate
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $from;

    /** @var  array */
    protected $cc;

    /** @var  array */
    protected $bcc;

    /** @var  string */
    protected $subject;

    /** @var  string */
    protected $txtBody;

    /** @var  string */
    protected $htmlBody;

    /** @var  \DateTime */
    protected $createdAt;

    /** @var  \DateTime */
    protected $updatedAt;

    public function __construct()
    {
        $this->updatedAt = $this->createdAt = new \DateTime();
    }

    /**
     * Doctrine lifecycle callback.
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        if (!$args->hasChangedField('updatedAt')) {
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return EmailTemplate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return EmailTemplate
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param array $cc
     *
     * @return EmailTemplate
     */
    public function setCc(array $cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @return array
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param array $bcc
     *
     * @return EmailTemplate
     */
    public function setBcc(array $bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return EmailTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getTxtBody()
    {
        return $this->txtBody;
    }

    /**
     * @param string $txtBody
     *
     * @return EmailTemplate
     */
    public function setTxtBody($txtBody)
    {
        $this->txtBody = $txtBody;

        return $this;
    }

    /**
     * @return string
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * @param string $htmlBody
     *
     * @return EmailTemplate
     */
    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return EmailTemplate
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return EmailTemplate
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
