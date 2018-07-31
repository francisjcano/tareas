<?php
// src/AppBundle/Repository/TareaRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TareaRepository extends EntityRepository
{
	public function findAllOrderedByDescripcion()
	{
		$entityManager = $this->getEntityManager();

		$query = $entityManager->createQuery(
			'SELECT t FROM AppBundle:Tarea t ORDER BY t.descripcion ASC'
		);
		return $query->getResult();
	}
}