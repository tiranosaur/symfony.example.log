<?php declare(strict_types=1);

namespace App\Service;

use App\Request\FileUploadRequest;
use Exception;
use http\Exception\RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class FileService
{
    private Filesystem $filesystem;
    private string $uploadDir;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        $this->uploadDir = $_ENV["UPLOAD_DIR"];

        if (!$this->filesystem->exists($this->uploadDir)) {
            $this->filesystem->mkdir($this->uploadDir);
        }
    }

    public function upload(FileUploadRequest $fileUploadRequest): void
    {
        try {
            $description = $fileUploadRequest->getDescription();
            $file = $fileUploadRequest->getFile();
            $file->move($this->uploadDir, $file->getClientOriginalName());
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function getFileList(): array
    {
        try {
            $finder = new Finder();
            $finder->files()->in($this->uploadDir);

            $fileList = [];
            foreach ($finder as $file) {
                $fileList[] = $file->getRelativePathname();
            }

            return $fileList;
        } catch (Exception $e) {
            throw new RuntimeException("Failed to list files: " . $e->getMessage());
        }
    }

    public function delete($filename): void
    {
        $this->filesystem->remove($this->uploadDir . '/' . $filename);
    }
}