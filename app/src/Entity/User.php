<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @var UuidInterface
	 */
	private $id;

	/**
	 * @ORM\Column(name="login", type="string", unique=true)
	 * @var string
	 * @Assert\NotBlank()
	 */
	private $login;

	/**
	 * @var string|null
	 * @Assert\NotBlank()
	 * @Assert\Length(max=4096)
	 */
	private $plainPassword;

	/**
	 * @ORM\Column(name="password", type="string")
	 * @var string|null
	 */
	private $password;

	/**
	 * @ORM\Column(name="roles", type="simple_array")
	 * @var string[]
	 */
	private $roles;

	/**
	 * @ORM\Column(name="created", type="datetime")
	 * @var DateTime
	 */
	private $created;

	/**
	 * @ORM\Column(name="updated", type="datetime", nullable=true)
	 * @var DateTime
	 */
	private $updated;

	/**
	 * User constructor.
	 */
	public function __construct()
	{
		$this->roles = [];
		$this->id = Uuid::uuid4();
		$this->created = new DateTime('NOW');
		$this->updated = new DateTime('NOW');
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function onPreUpdate(): void
	{
		$this->updated = new DateTime('NOW');
	}

	/**
	 * @return UuidInterface
	 */
	public function getId(): UuidInterface
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * @param string $login
	 */
	public function setLogin(string $login): void
	{
		$this->login = $login;
	}

	/**
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->login;
	}

	/**
	 * @return string|null
	 */
	public function getPlainPassword(): ?string
	{
		return $this->plainPassword;
	}

	/**
	 * @param string $password
	 */
	public function setPlainPassword(string $password): void
	{
		$this->plainPassword = $password;

		// forces the object to look "dirty" to Doctrine. Avoids
		// Doctrine *not* saving this entity, if only plainPassword changes
		$this->password = null;
	}

	/**
	 * @return string|null
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return null
	 */
	public function getSalt()
	{
		// The bcrypt algorithm doesn't require a separate salt.
		return null;
	}

	/**
	 * @return string[]
	 */
	public function getRoles(): array
	{
		return $this->roles;
	}

	/**
	 * @param string[] $roles
	 */
	public function setRoles(array $roles): void
	{
		$this->roles = $roles;
	}

	/**
	 *
	 */
	public function eraseCredentials(): void
	{
		$this->plainPassword = null;
	}

	/**
	 * @return DateTime
	 */
	public function getCreated(): DateTime
	{
		return $this->created;
	}

	/**
	 * @return DateTime|null
	 */
	public function getUpdated(): ?DateTime
	{
		return $this->updated;
	}
}
