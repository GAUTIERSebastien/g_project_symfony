<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'projects', targetEntity: Tasks::class)]
    private Collection $Tasks;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'projects_id')]
    private Collection $users;

    public function __construct()
    {
        $this->Tasks = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->Tasks;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->Tasks->contains($task)) {
            $this->Tasks->add($task);
            $task->setProjects($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        if ($this->Tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProjects() === $this) {
                $task->setProjects(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProjectsId($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProjectsId($this);
        }

        return $this;
    }
}
