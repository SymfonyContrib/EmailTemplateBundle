<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Renderer;

use SymfonyContrib\Bundle\EmailTemplateBundle\Email\Email;

interface RendererInterface
{
    /**
     * Render email template.
     *
     * @param mixed $name       Template name(s) to render
     * @param array $parameters Template parameters
     *
     * @return Email
     */
    function render($name, array $parameters = []);
}
