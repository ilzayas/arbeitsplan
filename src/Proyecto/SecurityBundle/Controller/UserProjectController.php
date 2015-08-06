<?php

namespace Proyecto\SecurityBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Proyecto\SecurityBundle\Entity\UserProject;
use Proyecto\SecurityBundle\Form\UserProjectType;
use Symfony\Component\Validator\Constraints\DateTime;
use Proyecto\TaskBundle\Entity\History as History;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * UserProject controller.
 *
 * @Route("/userproject")
 */
class UserProjectController extends Controller {

    /**
     * Lists all UserProject entities.
     *
     * @Route("/", name="userproject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
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
            $entities = $em->getRepository('ProyectoSecurityBundle:UserProject')->findAll();
            return array(
                'entities' => $entities,
            );
        }
    }

    /*
     * mi registrar, para registrar usuarios
     * basado en piquera taxi
     */

    public function registrarAction() {
        $request = $this->getRequest();
        $user = new UserProject();
        $form = $this->createForm(new UserProjectType(), $user);
        $string = array();
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
                $roles = $this->getDoctrine()->getRepository('TareaBundle:Rol');
                $states = $this->getDoctrine()->getRepository('TareaBundle:State');
                $user->setRol($roles->findOneBy(array('rol' => 'ROLE_USER')));
                $user->setState($states->findOneBy(array('state' => 'CREATE')));
                $beginingDate = new \DateTime("now");
                $user->setBeginningDate($beginingDate);
                $user->setEndingDate(null);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $userOnline = $this->container->get('security.context')->getToken()->getUser();
                if (is_null($userOnline)) {
                    return $this->redirect($this->generateUrl("login"));
                } else {
                    return $this->redirect($this->generateUrl("userList"));
                }
            } else {
                $string = $this->convertirErrores($form);
                return $this->render('ProyectoSecurityBundle:UserProject:new.html.twig', array(
                            'form' => $form->createView(), 'errors' => $string));
            }
        }
        return $this->render('ProyectoSecurityBundle:UserProject:new.html.twig', array('form' => $form->createView(), 'errors' => $string));
    }

    /**
     * Creates a new UserProject entity.
     *
     * @Route("/", name="userproject_create")
     * @Method("POST")
     * @Template("ProyectoSecurityBundle:UserProject:new.html.twig")
     */
//    public function createAction(Request $request) {
//        $entity = new UserProject();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('ProyectoSecurityBundle:UserProject:index.html.twig', array('id' => $entity->getId())));
//        }
//
//        return array(
//            'entity' => $entity,
//            'form' => $form->createView(),
//        );
    //   }

    /**
     * Creates a form to create a UserProject entity.
     *
     * @param UserProject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createCreateForm(UserProject $entity) {
//        $form = $this->createForm(new UserProjectType(), $entity, array(
//            'action' => $this->generateUrl('register'),
//            'method' => 'POST',
//        ));
//
//        $form->add('submit', 'submit', array('label' => 'Create'));
//
//        return $form;
//    }

    /**
     * Displays a form to create a new UserProject entity.
     *
     * @Route("/new", name="userproject_new")
     * @Method("GET")
     * @Template()
     */
//    public function newAction() {
//        $entity = new UserProject();
//        $form = $this->createCreateForm($entity);
//
//        return array(
//            'entity' => $entity,
//            'form' => $form->createView(),
//        );
//    }

    /**
     * Finds and displays a UserProject entity.
     *
     * @Route("/{id}", name="userproject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserProject entity.
     *
     * @Route("/{id}/edit", name="userproject_edit")
     * @Method("GET")
     * @Template()
     */
//    public function editAction($id) {
//        $em = $this->getDoctrine()->getManager();
//        $entity = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find UserProject entity.');
//        }
//        $editForm = $this->createEditForm($entity);
//        $errors = $editForm->getErrors();
//        //$deleteForm = $this->createDeleteForm($id);
//        return array(
//            'entity' => $entity,
//            'edit_form' => $editForm->createView(),
//            'errors' => $errors,
//                // 'delete_form' => $deleteForm->createView(),
//        );
//    }

    /**
     * Creates a form to edit a UserProject entity.
     *
     * @param UserProject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(UserProject $entity) {
        $form = $this->createForm(new \Proyecto\SecurityBundle\Form\EditUserType(), $entity, array(
            'action' => $this->generateUrl('userUpdate', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Aktualisieren'));
        return $form;
    }

    /**
     * Edits an existing UserProject entity.
     *
     * @Route("/{id}", name="userproject_update")
     * @Method("PUT")
     * @Template("ProyectoSecurityBundle:UserProject:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProject entity.');
        }
        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            //return $this->redirect($this->generateUrl('userEdit', array('id' => $id)));
            return $this->redirect($this->generateUrl('userList'));
        } else {
            $errors = $editForm->getErrors();
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'errors' => $errors,
                //'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UserProject entity, hecho por ily para probar edicion.------------pincho bien
     *
     * @Route("/{id}", name="userproject_update")
     * @Method("PUT")
     * @Template("ProyectoSecurityBundle:UserProject:edit.html.twig")
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserProject entity.');
        }
        $editForm = $this->createForm(new \Proyecto\SecurityBundle\Form\EditUserType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);
            $em->persist($entity);
            $em->flush();
            //return $this->redirect($this->generateUrl('userEdit', array('id' => $id)));
            return $this->redirect($this->generateUrl('userList'));
        } else {
            $errors = $editForm->getErrors();
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'errors' => $errors,
                //'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UserProject entity.
     *
     * @Route("/{id}", name="userproject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserProject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('userList'));
    }

    /**
     * Creates a form to delete a UserProject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('userproject_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /*
     * para obtener los errores del formulario
     */

    private function getErrorMessages(\Symfony\Component\Form\Form $form) {
        $errors = array();
        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        } foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        } return $errors;
    }

    private function convertirErrores(\Symfony\Component\Form\Form $form) {
        $string = array();
        $errors = $this->getErrorMessages($form);
        foreach ($errors as $campo => $errores) {
            if (is_array($errores)) {
                foreach ($errores as $error) {
                    if (is_array($error)) {
                        foreach ($error as $nError) {
                            $mensaje = var_export($nError, true);
                            $string[] = $campo . ': ' . $mensaje;
                        }
                    } else {
                        $mensaje = var_export($error, true);
                        $string[] = $campo . ': ' . $mensaje;
                    }
                }
            }
        }
        return $string;
    }

    //funcion para desactivar el usuario
    public function desactivarAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
        $endingDate = new \DateTime("now");
        if ($user) {
            $user->setEndingDate($endingDate);
            $user->setIsActive(false);
            $em->persist($user);
        } else {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $em->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    //funcion para activar el usuario
    public function activarAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
        $beginningDate = new \DateTime("now");
        if ($user) {
            $user->setBeginningDate($beginningDate);
            $user->setEndingDate(null);
            $user->setIsActive(true);
            $em->persist($user);
        } else {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $em->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    public function changeRolAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ProyectoSecurityBundle:UserProject')->find($id);
        $idRol = $user->getRol()->getId();
        $rol = $em->getRepository('TareaBundle:Rol')->find($idRol);

        if ($rol->getRol() == "ROLE_USER") {
            $role = $em->getRepository('TareaBundle:Rol')->getRolAdmin();
            $user->setRol($role);
            $em->persist($user);
            $em->flush();
        } else {
            $role = $em->getRepository('TareaBundle:Rol')->getRolUser();
            $user->setRol($role);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

}
