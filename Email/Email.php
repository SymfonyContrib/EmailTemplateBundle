<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Email;

/**
 *
 */
class Email
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
     * @return Email
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
     * @return Email
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
     * @param array|string $cc
     *
     * @return Email
     */
    public function setCc($cc)
    {
        if (empty($cc)) {
            $cc = [];
        }

        if (!is_array($cc)) {
            $cc = explode(',', $cc);
        }

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
     * @param array|string $bcc
     *
     * @return Email
     */
    public function setBcc($bcc)
    {
        if (empty($bcc)) {
            $bcc = [];
        }

        if (!is_array($bcc)) {
            $bcc = explode(',', $bcc);
        }

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
     * @return Email
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
     * @return Email
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
     * @return Email
     */
    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }
}
