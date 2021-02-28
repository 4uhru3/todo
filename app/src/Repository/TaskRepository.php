<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskRepository
 * @package App\Repository
 */
class TaskRepository extends ServiceEntityRepository
{
	/**
	 * TaskRepository constructor.
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Task::class);
	}

	/**
	 * @param int|null $completed
	 * @return array
	 */
	public function getListByCompleted(?int $completed): array
	{
		$criteria = [];

		if (!is_null($completed)) {
			$criteria['completed'] = $completed;
		}

		return $this->findBy($criteria, ['created' => 'DESC']);
	}

}
