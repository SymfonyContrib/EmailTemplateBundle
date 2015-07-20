<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Builder;

use SymfonyContrib\Bundle\EmailTemplateBundle\Message\SwiftMailerMessage;
use SymfonyContrib\Bundle\EmailTemplateBundle\Renderer\TwigRenderer;

/**
 *
 */
class MessageBuilder
{
    /** @var TwigRenderer */
    public $renderer;

    /** @var array */
    public $defaults;

    public function __construct(TwigRenderer $renderer, array $defaults = [])
    {
        $this->renderer = $renderer;
        $this->defaults = $defaults;
    }

    public function build($templateName, array $parameters = [])
    {
        // Get the rendered email parts.
        $email = $this->renderer->render($templateName, $parameters);

        // Build a message object.
        $message = new SwiftMailerMessage();
        $message->setFrom($email->getFrom() ?: $this->defaults['from'])
            ->setCc($email->getCc())
            ->setBcc($email->getBcc())
            ->setSubject($email->getSubject())
            ->setBody($email->getHtmlBody(), 'text/html')
            ->addPart($email->getTxtBody(), 'text/plain');

        return $message;
    }
}
