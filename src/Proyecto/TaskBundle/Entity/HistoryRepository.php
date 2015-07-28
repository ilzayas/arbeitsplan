<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * HistoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HistoryRepository extends EntityRepository
{
    public function buscarTareaSegunId($idtask) {
        $dql = $this->getEntityManager()->createQuery("SELECT t FROM TareaBundle:History t WHERE t.task = :idTask");
        $dql->setParameters(array(
            'idTask' => $idtask));
        $tasks = $dql->getResult();
        return $tasks;
    }
    
    public function buscarHistSegunIdUser($idUser) {
        $dql = $this->getEntityManager()->createQuery("SELECT t FROM TareaBundle:History t WHERE t.userProject = :idUser");
        $dql->setParameters(array(
            'idUser' => $idUser));
        $histories = $dql->getResult();
        return $histories;
    }
}