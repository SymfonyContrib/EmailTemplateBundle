<?php

namespace SymfonyContrib\Bundle\EmailTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SymfonyContrib\Bundle\EmailTemplateBundle\Entity\EmailTemplate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends Controller
{
    public function listAction(Request $request)
    {
        // Get templates to override from configuration.
        $overridable = $this->container->getParameter('email_template.templates');

        // Get templates in database.
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('t')
            ->from('EmailTemplateBundle:EmailTemplate', 't', 't.name');

        $dbTemplates = $qb->getQuery()->getResult();

        return $this->render('@EmailTemplate/Admin/list.html.twig', [
            'db_templates' => $dbTemplates,
            'overridable'  => $overridable,
        ]);
    }

    public function formAction(Request $request, $name = null)
    {
        $templates = $this->container->getParameter('email_template.templates');
        $tokens    = isset($templates[$name]['tokens']) ? $templates[$name]['tokens'] : [];
        $em        = $this->getDoctrine()->getManager();

        if ($name) {
            // Doctrine template exists.
            $tpl = $em->getRepository('EmailTemplateBundle:EmailTemplate')->find($name);

            if (empty($tpl) && isset($templates[$name])) {
                // Doctrine template not found, look for overridable.
                $tpl = (new EmailTemplate())->setName($name);
            }
        } else {
            $tpl = new EmailTemplate();
        }

        if (!$tpl instanceof EmailTemplate) {
            throw new \InvalidArgumentException('Email template not found.');
        }

        $options = [
            'cancel_url' => $this->generateUrl('email_template_admin_list'),
        ];
        $form = $this->createForm('email_template_form', $tpl, $options);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($tpl);
            $em->flush();

            return $this->redirectToRoute('email_template_admin_list');
        }

        return $this->render('@EmailTemplate/Admin/form.html.twig', [
            'form'   => $form->createView(),
            'name'   => $name,
            'tokens' => $tokens,
        ]);
    }

    /**
     * Delete a Doctrine template with confirmation.
     *
     * @param string $name Name of template.
     *
     * @return Response
     */
    public function deleteAction($name)
    {
        $data = $this->getDoctrine()
            ->getRepository('EmailTemplateBundle:EmailTemplate')
            ->find($name);

        $options = [
            'message'             => 'Are you sure you want to <strong>DELETE "' . $name . '"</strong>?',
            'warning'             => 'This can not be undone!',
            'confirm_button_text' => 'Delete',
            'cancel_link_text'    => 'Cancel',
            'confirm_action'      => [$this, 'dataDelete'],
            'confirm_action_args' => [
                'data' => $data,
            ],
            'cancel_url'          => $this->generateUrl('email_template_admin_list'),
        ];

        return $this->forward('ConfirmBundle:Confirm:confirm', ['options' => $options]);
    }

    /**
     * Delete confirmation callback.
     *
     * @param array $args
     *
     * @return RedirectResponse
     */
    public function dataDelete(array $args)
    {
        $data = $args['data'];
        $em   = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $msg = 'Deleted ' . $data->getName();
        $this->addFlash('success', $msg);

        return $this->redirectToRoute('email_template_admin_list');
    }
}
