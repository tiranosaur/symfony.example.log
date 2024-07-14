<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileControllerTest extends WebTestCase
{
    private string $filename = 'my_file_handling_test_file.json';
    private string $filePath = './tests/doc/';

    public function testUpload()
    {
        $client = static::createClient();

        $filesystem = $client->getContainer()->get(Filesystem::class);
        $filesystem->dumpFile("{$this->filePath}{$this->filename}", "{}");

        $uploadedFile = new UploadedFile(
            "{$this->filePath}{$this->filename}",
            "$this->filename",
            'application/json',
            null,
            true
        );


        $client->request(
            'POST',
            '/file',
            ['form' => ['description' => 'XXX2 test']],
            ['form' => ['file' => $uploadedFile]],
            ['HTTP_CONTENT_TYPE' => 'multipart/form-data']
        );


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains($this->filename, $this->getFiles());
    }

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/file');

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();

        $this->assertSelectorTextContains('title', 'File');
        $this->assertStringContainsString('<table>', $content);
        $this->assertStringContainsString("$this->filename", $content);
    }

    public function testDelete()
    {
        $client = static::createClient();
        $client->request('DELETE', '/file', [], [], [], json_encode(['filename' => $this->filename]));

        $this->assertResponseIsSuccessful();
        $this->assertNotContains($this->filename, $this->getFiles());
    }

    private function getFiles()
    {
        $finder = new Finder();
        $files = [];
        foreach ($finder->in($_ENV['UPLOAD_DIR'])->files() as $file) {
            $files[] = $file->getFilename();
        }
        return $files;
    }
}
