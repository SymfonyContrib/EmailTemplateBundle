<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Renderer;

use SymfonyContrib\Bundle\EmailTemplateBundle\Email\Email;

/**
 *
 */
class TwigRenderer implements RendererInterface
{
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render email template.
     *
     * @param string|array $name       Template to render
     * @param array        $parameters Template parameters
     *
     * @return Email
     */
    function render($name, array $parameters = [])
    {
        $template = $this->twig->resolveTemplate($name);

        $email = new Email();
        $email
            ->setName($name)
            ->setFrom($template->renderBlock('from', $parameters))
            ->setCc($template->renderBlock('cc', $parameters))
            ->setBcc($template->renderBlock('bcc', $parameters))
            ->setSubject($template->renderBlock('subject', $parameters))
            ->setHtmlBody($template->renderBlock('html_body', $parameters))
            ->setTxtBody($template->renderBlock('txt_body', $parameters));

        return $email;
    }
}
