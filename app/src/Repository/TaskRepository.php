<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
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
     * @param $id
     * @param User $user
     * @return Task
     */
    public function finByUser($id, User $user): Object
    {
        return $this->findOneBy(['id' => $id, 'user_id' => $user->getId()]);
    }

    /**
     * @param int|null $completed
     * @param User $user
     * @return array
     */
    public function getListByUserByCompleted(User $user, ?int $completed): array
    {
        $criteria = [
            'user_id' => $user->getId(),
        ];

        if (!is_null($completed)) {
            $criteria = array_merge($criteria, ['completed' => $completed]);
        }

        return $this->findBy($criteria, ['created' => 'DESC']);
    }

}
