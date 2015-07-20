<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Twig\Loader;

use SymfonyContrib\Bundle\EmailTemplateBundle\Entity\Repository\EmailTemplateRepository;
use SymfonyContrib\Bundle\EmailTemplateBundle\Entity\EmailTemplate;

/**
 *
 */
class EmailDoctrineLoader implements \Twig_LoaderInterface, \Twig_ExistsLoaderInterface
{
    const PREFIX = 'et:';

    /** @var  EmailTemplateRepository */
    protected $doctrineRepo;

    public function __construct(EmailTemplateRepository $doctrineRepo)
    {
        $this->doctrineRepo = $doctrineRepo;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        try {
            $this->getTemplate($name);

            return  true;
        } catch (\Twig_Error_Loader $exception) {
            return false;
        }
    }

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        // Build twig source from entity parts.
        $template = $this->getTemplate($name);

        $source  = '{%- block from -%}';
        $source .= $template->getFrom();
        $source .= '{%- endblock -%}';

        $source .= '{%- block cc -%}';
        $source .= $template->getCc() ? implode(',', $template->getCc()) : '';
        $source .= '{%- endblock -%}';

        $source .= '{%- block bcc -%}';
        $source .= $template->getBcc() ? implode(',', $template->getBcc()) : '';
        $source .= '{%- endblock -%}';

        $source .= '{%- block subject -%}';
        $source .= $template->getSubject();
        $source .= '{%- endblock -%}';

        $source .= '{%- block html_body -%}';
        $source .= $template->getHtmlBody();
        $source .= '{%- endblock -%}';

        $source .= '{%- block txt_body -%}';
        $source .= $template->getTxtBody();
        $source .= '{%- endblock -%}';

        return $source;
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        return '__email_template__' . $this->parseName($name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string  $name The template name.
     * @param integer $time The last modification time of the cached template.
     *
     * @return bool True if the template is fresh, false otherwise.
     *
     * @throws \Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        $lastModified = $this->getTemplate($name)->getUpdatedAt()->getTimestamp();

        return $lastModified <= $time;
    }

    /**
     * @param string $name
     *
     * @return EmailTemplate
     *
     * @throws \Twig_Error_Loader
     */
    protected function getTemplate($name)
    {
        $this->validateName($name);

        $name     = $this->parseName($name);
        $template = $this->doctrineRepo->find($name);

        if ($template === null) {
            throw new \Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
        }

        return $template;
    }

    protected function validateName($name)
    {
        if (strpos($name, "\0") !== false) {
            throw new \Twig_Error_Loader('A template name cannot contain NUL bytes.');
        }

        if (strpos($name, self::PREFIX) !== 0) {
            throw new \Twig_Error_Loader('Invalid Doctrine email template name.');
        }
    }

    protected function parseName($name)
    {
        return preg_replace('~^' . self::PREFIX . '~', '', $name, 1);
    }
}
