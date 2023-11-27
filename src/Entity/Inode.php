<?php

namespace App\Entity;

use App\Repository\InodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InodeRepository::class)
 */
class Inode
{

    const TYPE_ROOT = 0;
    const TYPE_FOLDER = 1;
    const TYPE_FILE = 2;

    const CLIENT_FOLDER = 'Clients';
    const TEAM_FOLDER = 'Teams';


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * One Inode (parent) can have Many Inodes (children)
     * @ORM\OneToMany(targetEntity="Inode", mappedBy="parent", cascade={"persist", "remove"})
     */
    private $children;

    /**
     * One Inode (parent) can have Many Inodes (children)
     * @ORM\ManyToOne(targetEntity="Inode", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * One Inode can have one DataFile
     * The Data Files stores the actual disk location for the uploaded files
     * @ORM\OneToOne(targetEntity="UpFile", inversedBy="inode", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="up_file_id", referencedColumnName="id", nullable=true)
     */
    private $upFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="inodes")
     */
    private $access;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->access = new ArrayCollection();
    }

    public function setFolder()
    {
        $this->type = self::TYPE_FOLDER;
    }

    public function setFile()
    {
        $this->type = self::TYPE_FILE;
    }

    public function isRoot(): bool
    {
        if ($this->type == self::TYPE_ROOT)
            return true;
        return false;
    }

    public function isNotRoot(): bool
    {
        if ($this->type == self::TYPE_ROOT)
            return false;
        return true;
    }

    public function isFolder(): bool
    {
        if ($this->type == self::TYPE_FOLDER)
            return true;
        return false;
    }

    public function isFile(): bool
    {
        if ($this->type == self::TYPE_FILE)
            return true;
        return false;
    }

    public function isOwnedBy($access): bool
    {
        if ($this->isRoot())
            return false;
        if ($access->getId() == $this->getAuthor()->getId())
            return true;
        return false;
    }

    public function getFolderChildren(): array
    {
        $folderChildren = array();
        foreach ($this->getChildren() as $key => $child)
            if ($child->isFolder())
                $folderChildren[] = $child;
        return $folderChildren;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->children;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $children
     */
    public function setChildren(\Doctrine\Common\Collections\ArrayCollection $children): void
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getUpFile()
    {
        return $this->upFile;
    }

    /**
     * @param mixed $upFile
     */
    public function setUpFile($upFile): void
    {
        $this->upFile = $upFile;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function pickIcon()
    {
        if ($this->isFolder())
        {
            return "'images/cloud/icons/folder.svg'";
        }

        if ($this->isFile() && $this->getUpFile() !== null)
        {
            $file = $this->getUpFile();

            if ($file->isImage())
                return "<i class='fa fa-file-image-o dms_fa'></i>";
            if ($file->isPdf())
                return "<i class='fa fa-file-pdf-o dms_fa'></i>";
            if ($file->isSound())
                return "<i class='fa fa-file-audio-o dms_fa'></i>";
            if ($file->isMovie())
                return "<i class='fa fa-file-video-o dms_fa'></i>";
            if ($file->isDoc())
                return "<i class='fa fa-file-word-o dms_fa'></i>";
            if ($file->isExcel())
                return "<i class='fa fa-file-excel-o dms_fa'></i>";
            if ($file->isCompressed())
                return "<i class='fa fa-file-archive-o dms_fa'></i>";
            if ($file->isCodeFile())
                return "<i class='fa fa-file-code-o dms_fa'></i>";

            return "<i class='fa fa-file-o dms_fa'></i>";
        }
    }

    /**
     * @return Collection|User[]
     */
    public function getAccess(): Collection
    {
        return $this->access;
    }

    public function addAccess(User $access): self
    {
        if (!$this->access->contains($access)) {
            $this->access[] = $access;
        }

        return $this;
    }

    public function removeAccess(User $access): self
    {
        $this->access->removeElement($access);

        return $this;
    }
}
