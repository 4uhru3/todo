<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="tasks")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @var UuidInterface
	 */
	private $id;

	/**
	 * @ManyToOne(targetEntity="User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;


    /**
     * @ORM\Column(name="user_id", type="uuid", unique=false)
     * @var UuidInterface
     */
    private $user_id;

	/**
	 * @ORM\Column(name="title", type="string", nullable=true)
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(name="created", type="datetime")
	 * @var DateTime
	 */
	private $created;

	/**
	 * @ORM\Column(name="updated", type="datetime", nullable=true)
	 * @var DateTime|null
	 */
	private $updated;

	/**
	 * @ORM\Column(name="completed", type="boolean")
	 * @var bool
	 */
	private $completed = false;

	/**
	 * Task constructor.
	 */
	public function __construct()
	{
		$this->id = Uuid::uuid4();
		$this->created = new DateTime('NOW');
	}

	/** @ORM\PreUpdate */
	public function onPreUpdate(): void
	{
		$this->updated = new DateTime('NOW');
	}

	/** @return UuidInterface */
	public function getId(): UuidInterface
	{
		return $this->id;
	}

	/** @return User */
	public function getUser(): ?User
	{
		return $this->user;
	}

	/** @param User $user */
	public function setUser(User $user): void
	{
		$this->user = $user;
	}

	/** @return string|null */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/** @param string|null $title */
	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}

	/** @return DateTime */
	public function getCreated(): DateTime
	{
		return $this->created;
	}

	/** @return DateTime|null */
	public function getUpdated(): ?DateTime
	{
		return $this->updated;
	}

	/** @return bool */
	public function isCompleted(): bool
	{
		return $this->completed;
	}

	/** @param bool $completed */
	public function setCompleted(bool $completed): void
	{
		$this->completed = $completed;
	}

    /**
     * @return UuidInterface|null
     */
    public function getUserId(): ?UuidInterface
    {
        return $this->user_id;
    }

    /**
     * @param UuidInterface $user_id
     */
    public function setUserId(UuidInterface $user_id): void
    {
        $this->user_id = $user_id;
    }

}
