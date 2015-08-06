<?php
namespace Proyecto\TaskBundle\Servicios;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

/**
 * Description of LateralService
 *
 * @author Iliana
 */
class LateralService {
    
    private $doctrine;
    
    public function __construct(Doctrine $doctrine) {
        $this->doctrine = $doctrine->getManager();
    }
    
    public function servicioMisTareas($idUser){
        $tareas = $this->doctrine->getRepository('TareaBundle:Task')->misTareas($idUser);
        return $tareas;
    }
    
    public function servicioClientesDadoUser($idUser){
        $clients = $this->doctrine->getRepository('TareaBundle:UserTaskClient')->listaClientesDadoUserM($idUser);
        return $clients;
    }
    
    public function servicioTareasErledigt($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->taskErledig($idUser);
        return $tasks;
    }
    
    public function servicioTareasHeute($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->taskHeute($idUser);
        return $tasks;
    }
    
    public function servicioTareasDadoCliente($idClient){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->tareasDadoCliente($idClient);
        return $tasks;
    }
    
    public function servicioDocumentosPorTarea($idTask){
        $docs = $this->doctrine->getRepository('TareaBundle:Document')->buscarDocPorTaskId($idTask);
        return $docs;
    }
    
    public function servicioTareasPasadas($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->tasksFechaPasada($idUser);
        return $tasks;
    }
    
    public function servicioTareas30Tagen($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->taskEnden30Tagen($idUser);
        return $tasks;
    }
    
    public function servicioTareasSinFecha($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->keinFalligDatum($idUser);
        return $tasks;
    }
    
    public function servicioTareasFuturas($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->tasksFuturas($idUser);
        return $tasks;
    }
    
    public function servicioTareasMorgen($idUser){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->taskEndenMorgen($idUser);
        return $tasks;
    }
    
    public function servicioClientesActivos(){
        $clients = $this->doctrine->getRepository('TareaBundle:Client')->listaTodosClientesActivos();
        return $clients;
    }
    
    public function servicioTareasTerminadasHaceTresMon(){
        $tasks = $this->doctrine->getRepository('TareaBundle:Task')->tasksPasadasTresMeses();
        return $tasks;
    }
}
