<?php

namespace App\Entity;

use App\Repository\UpFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=UpFileRepository::class)
 */
class UpFile
{
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=255, nullable=true)
     */
    private $uuid;

    /**
     * One Inode can have one UpFile
     * The Data Files stores the actual disk location for the uploaded files
     * @ORM\OneToOne(targetEntity="Inode", mappedBy="upFile")
     */
    private $inode;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    public function isSound()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'mp3') return true;
        if ($ext == 'mpga') return true;
        if ($ext == 'ogg') return true;
        return false;
    }

    public function isMovie()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'mp4') return true;
        if ($ext == 'wpa') return true;
        if ($ext == 'avi') return true;
        if ($ext == 'mkv') return true;
        if ($ext == 'mov') return true;
        return false;
    }

    public function isImage()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'jpg') return true;
        if ($ext == 'jpeg') return true;
        if ($ext == 'png') return true;
        if ($ext == 'tiff') return true;
        if ($ext == 'tif') return true;
        if ($ext == 'bmp') return true;
        if ($ext == 'gif') return true;
        return false;
    }

    public function isPdf()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'pdf') return true;
        return false;
    }

    public function isDoc()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'doc') return true;
        if ($ext == 'dot') return true;
        if ($ext == 'wkb') return true;
        if ($ext == 'docx') return true;
        if ($ext == 'docm') return true;
        if ($ext == 'dotx') return true;
        if ($ext == 'dotm') return true;
        if ($ext == 'docb') return true;
        if ($ext == 'odt') return true;
        if ($ext == 'ott') return true;
        if ($ext == 'pages') return true;
        return false;
    }

    public function isExcel()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'xls') return true;
        if ($ext == 'xlt') return true;
        if ($ext == 'xlm') return true;
        if ($ext == 'xlsx') return true;
        if ($ext == 'xlsm') return true;
        if ($ext == 'xltm') return true;
        if ($ext == 'ods') return true;
        if ($ext == 'odt') return true;
        return false;
    }

    public function isCompressed()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'zip') return true;
        if ($ext == 'iso') return true;
        if ($ext == 'rar') return true;
        if ($ext == 'tar.ze') return true;
        if ($ext == 'tgz') return true;
        if ($ext == 'z') return true;
        return false;
    }

    public function isCodeFile()
    {
        $ext = strtolower($this->extension);
        if ($ext == 'html') return true;
        if ($ext == 'css') return true;
        if ($ext == 'js') return true;
        if ($ext == 'php') return true;
        if ($ext == 'sass') return true;
        if ($ext == 'xml') return true;
        if ($ext == 'sh') return true;
        if ($ext == '.html.twig') return true;
        if ($ext == '.js.twig') return true;
        return false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getName(): string
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
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getInode()
    {
        return $this->inode;
    }

    /**
     * @param mixed $inode
     */
    public function setInode($inode): void
    {
        $this->inode = $inode;
    }


    //----------------------------------------------------------------------------------------------------
    // Upload mechanism : Begin

    private $uploadFile;
    private $tempFilename;
    private $company;
    private $directory;

    public function getUploadFile()
    {
        return $this->uploadFile;
    }

    public function setUploadFile($company, $directory, UploadedFile $file = null)
    {
        $this->company = $company;
        $this->directory = $directory;
        $this->uploadFile = $file;
    }
}
