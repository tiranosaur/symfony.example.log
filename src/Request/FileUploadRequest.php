<?php declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class FileUploadRequest
{
    private ?string $description = null;

    #[Assert\File(
        maxSize: '500k',
        mimeTypes: ['application/pdf', 'application/json', 'text/plain'],
        maxSizeMessage: "XXX - the max file size is exceeded",
        mimeTypesMessage: 'XXX - Wrong file type',
    )]
    private File $file;

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(File $file): void
    {
        $this->file = $file;
    }
}
