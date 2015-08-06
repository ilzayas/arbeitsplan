<?php

namespace Proyecto\TaskBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Proyecto\TaskBundle\Entity\Task;
use Proyecto\TaskBundle\Form\TaskType;
use Proyecto\TaskBundle\Entity\UserTaskClient as UserTask;
use Proyecto\TaskBundle\Entity\History as History;
use Proyecto\TaskBundle\Entity\Document as Document;

/**
 * Task controller.
 *
 * @Route("/task")
 */
class TaskController extends Controller {

    /**
     * Lists all Task entities en la pag de inicio.
     *
     * @Route("/", name="task")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $tasksMorgen = $this->get('paraLateral')->servicioTareasMorgen($user);
        $tasksErledig = $this->get('paraLateral')->servicioTareasErledigt($user);
        $tasks30Tagen = $this->get('paraLateral')->servicioTareas30Tagen($user);
        $tasksKeinFalligDatum = $this->get('paraLateral')->servicioTareasSinFecha($user);
        $taskHeute = $this->get('paraLateral')->servicioTareasHeute($user);
        $tareasPasadas = $this->get('paraLateral')->servicioTareasPasadas($user);
        $tareasFuturas = $this->get('paraLateral')->servicioTareasFuturas($user);
        $alle = $this->getDoctrine()->getManager()->getRepository('TareaBundle:Task')->findAll();

        return $this->render('TareaBundle:Task:index.html.twig', array(
                    'tasksMorgen' => $tasksMorgen, 'tasksErledig' => $tasksErledig,
                    'tasks30Tagen' => $tasks30Tagen, 'tasksKeinFalligDatum' => $tasksKeinFalligDatum,
                    'tasksHeute' => $taskHeute, 'alle' => $alle,
                    'tareasPasadas' => $tareasPasadas, 'tareasFuturas' => $tareasFuturas,
        ));
    }

    /**
     * Lists all Task entities.
     *
     * @Route("/", name="task")
     * @Method("GET")
     * @Template()
     */
    public function listAlleAction() {
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('TareaBundle:Task')->findAll();
        $pagename = 'Alle Aufgaben';

        return $this->render('TareaBundle:Task:alle.html.twig', array('tasks' => $tasks,
                    'pagename' => $pagename,
        ));
    }

    /*
     * registrar tareas
     */

    public function registrarTareaAction() {
        $request = $this->getRequest();
        $task = new Task();
        $history = new History();
        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);
        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($request->isMethod("POST")) {
            if ($form->isValid()) {
                $task = $form->getData();
                $this->name($task);
                $em = $this->getDoctrine()->getManager();
                $bDate = $this->getFechaInicio($task->getBeginningDate());
                $client = $task->getClient();

                $task->addHistory($history, "Erstellt", $bDate, null, $user);
                $userTaskClient = $this->adicionarEnTaskClientUser($user, $task->getUsers(), $client, $task);

                $this->upload($task, $request->files, $em);
                $task->setUsers($user);

                $em->persist($task);
                $em->persist($history);

                foreach ($userTaskClient as $userTC) {
                    $em->persist($userTC);
                }
                $em->flush();
                return $this->redirect($this->generateUrl("taskList"));
            }
        }
        return $this->render('TareaBundle:Task:new.html.twig', array('form' => $form->createView()));
    }

    /*
     * para cuando no se introduce un nombre a la tarea, darle uno por defecto
     */

    public function name($task) {
        if ($task->getName() === NULL) {
            $task->setName("Neue Aufgabe");
        }
    }

    /*
     * para guardar en la relacion Task-Client-User
     */

    public function adicionarEnTaskClientUser($userOnline, $otrosUsers, $client, $task) {
        $userTaskClients = new \Doctrine\Common\Collections\ArrayCollection();
        $userTask = new UserTask();
        $userTask->setClient($client);
        $userTask->setUser($userOnline);
        $userTask->setTask($task);

        $userTaskClients->add($userTask);

        $userTask2 = new UserTask();
        $userTask2->setClient($client);
        $userTask2->setUser($otrosUsers);
        $userTask2->setTask($task);
        $userTaskClients->add($userTask2);
        return $userTaskClients;
    }

    /*
     * para guardar en el historial
     */

    public function getFechaInicio($bDate) {
        if ($bDate == NULL) {
            $bDate = new \DateTime("now");
        }
        return $bDate;
    }

    /*
     * para subir ficheros
     */

    public function upload($task, $filesSubidos, $em) {
        $docs = new \Doctrine\Common\Collections\ArrayCollection();

        foreach ($filesSubidos as $key) {
            if ($key != null) {
                $document = new Document();
                $document->setTask($task);
                $document->setFile($key);
                $docs->add($document);
                $task->addFile($document);
            }
        }
        foreach ($docs as $key) {
            $em->persist($key);
        }
    }

    /*
     * para subir ficheros cuando se modifica
     */

    public function uploadModificar($task, $filesSubidos, $em) {
        foreach ($filesSubidos as $key) {
            if ($filesSubidos != null) {
                $document = new Document();
                $document->setTask($task);
                $document->setFile($key);
                //$docs->add($document);
                $task->addFile($document);
                $em->persist($document);
            }
        }
    }

    /*
     * para subir ficheros cuando se modifica
     */

    public function subirExtraAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TareaBundle:Task')->find($id);
        $request = $this->getRequest(); 
        $file = $request->files;
        if ($file != null) {
            $document = new Document();
            $document->setTask($entity);
            $document->setFile($file);
            $entity->addFile($document);
            $em->persist($document);
        } else {
            throw $this->createNotFoundException('No se ha seleccionado ningun fichero');
        }
        $em->flush();
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * Finds and displays a Task entity.
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TareaBundle:Task')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
        $historiales = $em->getRepository('TareaBundle:History')->buscarTareaSegunId($id);
        return array(
            'entity' => $entity,
            'historial' => $historiales,
        );
    }

    /*     * *****************************************
     * Edits an existing Task entity, hecho por ily para probar edicion.***********************************************
     * pincha, pincho el 14.07
     * @Route("/{id}", name="task_edit")
     * @Method("PUT")
     * @Template("TareaBundle:Task:edit.html.twig")
     */
    public function taskEditAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TareaBundle:Task')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
        $editForm = $this->createForm(new \Proyecto\TaskBundle\Form\EditTaskType(), $entity);
        $editForm->handleRequest($request);
        $history = new History();
        $bDate = new \DateTime("now");
        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($editForm->isValid()) {
            $userTaskClient = $this->modificarTaskClientUser($entity->getUsers(), $entity->getClient(), $entity, $em);
            if ($userTaskClient != null) {
                $em->persist($userTaskClient);
                $action = "Modifiziert, um " . $userTaskClient->getUser() . " zugeordnet";
            } else {
                $action = "Modifiziert";
            }
            $entity->addHistory($history, $action, $bDate, null, $user);
            $this->uploadModificar($entity, $request->files, $em);

            $em->persist($history);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('taskList'));
        } else {
            $errors = $editForm->getErrors();
        }
        return $this->render('TareaBundle:Task:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'errors' => $errors,
        ));
    }

    /*
     * para guardar en la relacion Task-Client-User cuando se modifica una tarea
     */

    public function modificarTaskClientUser($user, $client, $task, $em) {
        //para buscar si ya existe un registro de esa tarea con el usuario seleccionado,
        //si no existe se agrega un n uevo registro, sino, no se hace nada y devuelve null
        $entity = $em->getRepository('TareaBundle:UserTaskClient')->tareaDadoUserYTarea($user, $task);
        if (!$entity) {
            $userTask = new UserTask();
            $userTask->setClient($client);
            $userTask->setUser($user);
            $userTask->setTask($task);

            $registrosAnteriores = $em->getRepository('TareaBundle:UserTaskClient')->buscarTareaSegunId($task);
            foreach ($registrosAnteriores as $t) { //para q al cambiar el cliente, los registros anteriores q hay de tarea-usuario-cliente, se les cambie tambien el cliente
                $t->setClient($client);
            }
            return $userTask;
        }
        //para el caso que se cambie el cliente
        $entityClient = $em->getRepository('TareaBundle:UserTaskClient')->tareaDadoClientYTarea($client, $task);
        if (!$entityClient) {
            $userTask = new UserTask();
            $userTask->setClient($client);
            $userTask->setUser($user);
            $userTask->setTask($task);

            $registrosAnteriores = $em->getRepository('TareaBundle:UserTaskClient')->buscarTareaSegunId($task);
            foreach ($registrosAnteriores as $t) { //para q al cambiar el cliente, los registros anteriores q hay de tarea-usuario-cliente, se les cambie tambien el cliente
                $t->setClient($client);
            }
            return $userTask;
        }
        return null;
    }

    /**
     * Deletes a Task entity.
     *
     * @Route("/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function borrarAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $posts = $em->getRepository('TareaBundle:Task');
        $post = $posts->find($id);
        
        //buscar las en la tabla UserTaskClient para eliminar primero la relacion
        $tasksUser = $em->getRepository('TareaBundle:UserTaskClient')->buscarTareaSegunId($id);
        if ($tasksUser != null) {
            foreach ($tasksUser as $value) {
                $em->remove($value);
            }
        }
        
        //buscar los documentos asociados a esa tarea para eliminarlos
        $docsTask = $this->get('paraLateral')->servicioDocumentosPorTarea($id);
        if ($docsTask != null) {
            foreach ($docsTask as $value) {
                $em->remove($value);
            }
        }
        
        //elimanr el historial de la tarea
        $historyTasks = $em->getRepository('TareaBundle:History')->buscarTareaSegunId($id);
        if ($historyTasks != null) {
            foreach ($historyTasks as $value) {
                $em->remove($value);
            }
        }
        $em->remove($post);
        $flush = $em->flush();
        if ($flush == null) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        } else {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
    }
    
    //para eiminar todas las tareas que se terminaron hace 3 meses
    public function deleteAllesAction(){
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $alles = $this->get('paraLateral')->servicioTareasTerminadasHaceTresMon();
        if(count($alles) > 0){
            foreach ($alles as $value) {
                //buscar las en la tabla UserTaskClient para eliminar primero la relacion
                $tasksUser = $em->getRepository('TareaBundle:UserTaskClient')->buscarTareaSegunId($value);
                if ($tasksUser != null) {
                    foreach ($tasksUser as $value) {
                        $em->remove($value);
                    }
                }
                //buscar los documentos asociados a esa tarea para eliminarlos
                $docsTask = $this->get('paraLateral')->servicioDocumentosPorTarea($value);
                if ($docsTask != null) {
                    foreach ($docsTask as $value) {
                        $em->remove($value);
                    }
                }
                //elimanr el historial de la tarea
                $historyTasks = $em->getRepository('TareaBundle:History')->buscarTareaSegunId($value);
                if ($historyTasks != null) {
                    foreach ($historyTasks as $value) {
                        $em->remove($value);
                    }
                }
                $em->remove($value);//eliminar la tarea
            }
            $flush = $em->flush();
            if ($flush == null) {
                return $this->redirect($request->server->get('HTTP_REFERER'));
            } else {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }
        }
        else{
            throw $this->createNotFoundException('Kein Aufgabe');
        }
    }

    /*
     * ---------------------------------reportes--------------------------------------------------------
     * tareas que terminan hoy
     */

    public function listTasksHeuteAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $pagename = 'Heute';
        $taskHeute = $this->get('paraLateral')->servicioTareasHeute($user);

        return $this->render('TareaBundle:Task:alle.html.twig', array(
                    'tasks' => $taskHeute,
                    'pagename' => $pagename,
        ));
    }

    //para la pagina q sale aparte desde el menu
    public function listTasksErledigPageAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $tasks = $this->get('paraLateral')->servicioTareasErledigt($user);
        $pagename = 'Erledig';
        return $this->render('TareaBundle:Task:alle.html.twig', array(
                    'tasks' => $tasks,
                    'pagename' => $pagename,
        ));
    }

    //devolver las tareas asociadas a un cliente
    public function listTasksDadoClienteAction($id) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $clientName = $this->getDoctrine()->getManager()->getRepository('TareaBundle:Client')->find($id)->getName();
        $tasks = $this->get('paraLateral')->servicioTareasDadoCliente($id);
        $alle = $this->get('paraLateral')->servicioMisTareas($user);
        $pagename = $clientName;
        return $this->render('TareaBundle:Task:alle.html.twig', array(
                    'tasks' => $tasks, 'pagename' => $pagename,
                    'alle' => $alle
        ));
    }

    //************** mis tareas**********************
    public function misTareasAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $tasks = $this->get('paraLateral')->servicioMisTareas($user);
        $pagename = 'Meine Aufgaben';

        return $this->render('TareaBundle:Task:alle.html.twig', array(
                    'tasks' => $tasks,
                    'pagename' => $pagename,
        ));
    }

    //***************** tareas terminadas hace 3 meses
    public function tareasDreiMonFertigAction() {
            $tasks = $this->get('paraLateral')->servicioTareasTerminadasHaceTresMon();
            $pagename = 'Erledigte Aufgaben vor 3 Monaten';
            return $this->render('TareaBundle:Task:alleDelete.html.twig', array(
                        'tasks' => $tasks,
                        'pagename' => $pagename,
            ));
    }

    //************************** fin de reportes

    /**
     * marca una tarea como finalizada
     *
     * @Route("/{id}", name="fertig")
     * @Method("Modificar")
     */
    public function fertigAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $task = $em->getRepository('TareaBundle:Task')->find($id);
        if ($task->getErledig()) {
            $action = 'Noch in bearbeiten';
            $task->setErledig(false);
        } else {
            $action = 'Fertig';
            $task->setErledig(true);
        }
        $bDate = new \DateTime("now");
        $user = $this->container->get('security.context')->getToken()->getUser();
        $history = new History();
        $task->addHistory($history, $action, $bDate, null, $user);
        $em->persist($task);
        $em->persist($history);
        $flush = $em->flush();
        if ($flush == null) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        } else {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
    }

    /*
     * Exportar a PDF
     */

    public function exportAction() {
//        $dompdf = $this->get('slik_dompdf');
//
//        // Generate the pdf
//        $dompdf->getpdf($html);
//
//        // Either stream the pdf to the browser
//        $dompdf->stream("file");
//
//        // Or get the output to handle it yourself
//        $pdfoutput = $dompdf->output();
//        return $pdfoutput;

        // Set some html and get the service
    //$html = '<h1>Sample html</h1>';
        
        //esto es lo q dice en el bundle q uno debe hacer
        $html = '<html>
                <body>
                <p>
                    PLEASE WORK!!!
                </p>
            </body></html>';
        $dompdf = $this->get('slik_dompdf');

        // Generate the pdf
        $dompdf->getpdf($html);

        // Either stream the pdf to the browser
        //$dompdf->stream("myfile.pdf");

        // Or get the output to handle it yourself
        $pdfoutput = $dompdf->output();
        return $pdfoutput;
    }

    public function buscarTareaAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $dato = $this->get('request')->get('buscar');
        $tasks = $this->getDoctrine()->getManager()->getRepository('TareaBundle:Task')->buscarTarea($dato, $user);
        $pagename = "Suche " . $dato;

        return $this->render('TareaBundle:Task:alle.html.twig', array(
                    'tasks' => $tasks,
                    'pagename' => $pagename,
        ));
    }

}
