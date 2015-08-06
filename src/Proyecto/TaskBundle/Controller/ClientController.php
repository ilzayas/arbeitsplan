<?php

namespace Proyecto\TaskBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Proyecto\TaskBundle\Entity\Client;
use Proyecto\TaskBundle\Form\ClientType;

/**
 * Client controller.
 *
 * @Route("/client")
 */
class ClientController extends Controller {

    /**
     * Lists all Client entities.
     *
     * @Route("/", name="client")
     * @Method("GET")
     * @Template()
     */
    public function listClientAction() {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $rolU = $user->getRol()->getRol();
        $session = $request->getSession();

        if ($rolU == 'ROLE_USER') {
            $session->getFlashBag()->set('error_msg', "Sie haben keine Berechtigung, um diese Aktion durchzuführen!");
            return $this->redirect($request->server->get('HTTP_REFERER'));
            //throw new Exception('Sie haben keine Berechtigung, um diese Aktion durchzuführen');
        } else {
            $clients = $em->getRepository('TareaBundle:Client')->findAll();
            return $this->render('TareaBundle:Client:listClient.html.twig', array('clients' => $clients));
        }
    }

    /*
     * mi registrar, para registrar usuarios
     * basado en piquera taxi
     */

    public function registrarClienteAction() {
        $request = $this->getRequest();
        $client = new Client();
        $formClient = $this->createForm(new ClientType(), $client);
        $color = substr(md5(time()), 0, 6);
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod("POST")) {
            $formClient->handleRequest($request);
            if ($formClient->isValid()) {
                $client->setUserProject($user);
                $client->setColor($color);
                $client->setIsActive(true);              
                $em->persist($client);
                $em->flush();
                return $this->redirect($this->generateUrl("taskList"));
            }
        }
       return $this->render('TareaBundle:Client:new.html.twig', array('formClient' => $formClient->createView()));            
    }

//    public function registrarClienteAction(Request $request) {
//        $client = new Client();
//        $formClient = $this->createForm(new ClientType(), $client);
//        if ($request->isMethod('POST')) {
//
//            $formClient->bind($request);
//
//            if ($formClient->isValid()) {
//                $data = $formClient->getData();
//                $user = $this->get('security.context')->getToken()->getUser();
//                $client->setUserProject($user);
//                $client->setColor("color");
//                $client->setName("client");
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($client);
//                $em->flush();
//                $response['success'] = true;
//            } else {
//
//                $response['success'] = false;
//                $response['cause'] = 'whatever';
//            }
//
//            return new JsonResponse($response);
//        }
//        return array('postform' => $formClient->createView());
//    }
    //--------------------------fin de nuevo cliente

    /**
     * Return a ajax response
     */
//    public function registrarClienteAction() {
//        $request = $this->get('request');
//        $name = $request->request->get('formName');
//        if ($name == "") {
//            $name = "Neue Liste";
//        }
//        $client = new Client();
//
//        //if ($name != "") {//if the user has written his name
//            //$greeting = 'Hello ' . $name . '. How are you today?';
//            $user = $this->get('security.context')->getToken()->getUser();
//            $client->setUserProject($user);
//            $client->setColor("color");
//            $client->setName($name);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($client);
//            $em->flush();
//            $clients = $this->listClientAction();
//            $return = array("responseCode" => 200);
//        //} else {
//            //$return = array("responseCode" => 400);j
//       // }
//
//        //$return = json_encode($return); //jscon encode the array
//        //return new Response(json_encode($return), 200, array('Content-Type' => 'application/json')); //make sure it has the correct content type
//        return new Response(json_encode($return), 200, array('client' => $clients));
//    }

    /**
     * Creates a new Client entity.
     *
     * @Route("/", name="client_create")
     * @Method("POST")
     * @Template("TareaBundle:Client:new.html.twig")
     */
//    public function createAction(Request $request)
//    {
//        $entity = new Client();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('tasklist', array('id' => $entity->getId())));
//        }
//
//        return $this->render('TareaBundle:Task:index.html.twig', array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        ));
//    }

    /**
     * Creates a form to create a Client entity.
     *
     * @param Client $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createCreateForm(Client $entity)
//    {
//        $form = $this->createForm(new ClientType(), $entity, array(
//            'action' => $this->generateUrl('tasklist'),
//            'method' => 'POST',
//        ));
//
//        $form->add('submit', 'submit', array('label' => 'Create'));
//
//        return $form;
//    }

    /**
     * Displays a form to create a new Client entity.
     *
     * @Route("/new", name="client_new")
     * @Method("GET")
     * @Template()
     */
//    public function newAction()
//    {
//        $entity = new Client();
//        $form   = $this->createCreateForm($entity);
//
//        return $this->render('TareaBundle:Task:index.html.twig', array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        ));
//    }

    /**
     * Finds and displays a Client entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TareaBundle:Client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method("GET")
     * @Template()
     */
//    public function editAction($id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('TareaBundle:Client')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Client entity.');
//        }
//
//        $editForm = $this->createEditForm($entity);
//        // $deleteForm = $this->createDeleteForm($id);
//
//        return array(
//            'entity' => $entity,
//            'edit_form' => $editForm->createView(),
//                //'delete_form' => $deleteForm->createView(),
//        );
//    }
//
//    /**
//     * Creates a form to edit a Client entity.
//     *
//     * @param Client $entity The entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createEditForm(Client $entity) {
//        $form = $this->createForm(new ClientType(), $entity, array(
//            'action' => $this->generateUrl('client_update', array('id' => $entity->getId(),
//            )),
//            'method' => 'PUT',
//        ));
//
//        // $form->add('submit', 'submit', array('label' => 'Update'));
//
//        return $form;
//    }
//
//    /**
//     * Edits an existing Client entity.
//     *
//     * @Route("/{id}", name="client_update")
//     * @Method("PUT")
//     * @Template("TareaBundle:Client:edit.html.twig")
//     */
//    public function updateAction($id) {
//        $request = $this->getRequest();
//        $em = $this->getDoctrine()->getManager();
//        $entity = $em->getRepository('TareaBundle:Client')->find($id);
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Client entity.');
//        }
//        $editForm = $this->createForm(new ClientType(), $entity);
//        $editForm->handleRequest($request);
//        if ($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('tasklist'));
//        }
//
//        return $this->render('TareaBundle:Client:edit.html.twig', array(
//                    'entity' => $entity,
//                    'edit_form' => $editForm->createView(),
//                        // 'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    public function editIlyAction($id) {
//        $request = $this->getRequest();
//        $em = $this->getDoctrine()->getManager();
//        $entity = $em->getRepository('TareaBundle:Client')->find($id);
//        $clientName = $this->get('request')->get('name');
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Client entity.');
//        }
//
//        $entity->setName($clientName);
//        $em->persist($entity);
//        $em->flush();
//        return $this->redirect($request->server->get('HTTP_REFERER'));
//    }
    
    /**
     * Edits an existing Client entity, hecho por ily para probar edicion.
     *
     * @Route("/{id}", name="clientEdit")
     * @Method("PUT")
     * @Template("TareaBundle:Client:edit.html.twig")
     */
    public function clientEditAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TareaBundle:Client')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProject entity.');
        }
        $editForm = $this->createForm(new ClientType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($request->server->get('HTTP_REFERER'));
        } else {
            $errors = $editForm->getErrors();
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'errors' => $errors,
        );
    }

    /**
     * Deletes a Client entity. No elimina, modifica su estado a desactivado
     *
     * @Route("/{id}", name="aktivieren")
     * @Method("UPDATE")
     */
    public function desactivarAction($id) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $rolU = $user->getRol()->getRol();
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('TareaBundle:Client');
        $client = $clients->find($id);
        if ($rolU == 'ROLE_USER') {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        } elseif ($client) {
            $client->setIsActive(false);
            $em->persist($client);
        } else {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $em->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));       
    }
    
    public function activarAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('TareaBundle:Client')->find($id);
        if ($client) {
            $client->setIsActive(true);
            $em->persist($client);
        } else {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $em->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * Creates a form to delete a Client entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('client_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
