<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Todo>
 *
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Todo::class);
        $this->manager = $manager;
    }

    public function saveTodo($title) 
    {
        $todo =  new Todo();
        $todo->setTitle($title);
        $this->manager->persist($todo);
        $this->manager->flush();
    }

    public function updateTodo(Todo $todo): Todo
    {
        $this->manager->persist($todo);
        $this->manager->flush();
    
        return $todo;
    }

    public function removeTodo(Todo $todo)
{
    $this->manager->remove($todo);
    $this->manager->flush();
}

}
