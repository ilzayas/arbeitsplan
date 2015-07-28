<?php

namespace Proyecto\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('TareaBundle:Default:index.html.twig', array('name' => $name));
    }

    public function uploadAction() {
        $document = new Document();
        $form = $this->createFormBuilder($document)
                ->add('name')
                ->add('file')
                ->getForm()
        ;

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($document);
                $em->flush();

                return $this->redirect($this->generateUrl('task_new'));
            }
        }

        return array('form' => $form->createView());
    }
    /*
     * para los datos que se deben enviar para el lateral, y que se cargan en todas las paginas
     */
    public function lateralAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $rolU = $user->getRol()->getRol();

        if ($rolU == 'ROLE_USER') {
            $clients = $this->get('paraLateral')->servicioClientesDadoUser($user);
        } else {
            $clients = $this->get('paraLateral')->servicioClientesActivos();
        }
        $tasksErledig = $this->get('paraLateral')->servicioTareasErledigt($user);
        $taskHeute = $this->get('paraLateral')->servicioTareasHeute($user);

        return $this->render('lateral.html.twig', array('clients' => $clients,
                    'tasksHeute' => $taskHeute, 'tasksErledig' => $tasksErledig));
    }

}
