<?php

declare(strict_types=1);

namespace AppTest\Unit\File;

use App\File\FileNotReadableException;
use App\File\Loader;
use App\File\FileNotExistException;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    private Loader $loader;

    private vfsStreamDirectory $root;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loader = new Loader();
        $this->root = vfsStream::setup();
    }

    /**
     * @throws FileNotExistException
     * @throws FileNotReadableException
     */
    public function testLoadExistingFile(): void
    {
        $expectedContent = 'file content';
        $file = vfsStream::newFile('file.txt')->at($this->root)->setContent($expectedContent);
        $content = $this->loader->load($file->url());

        self::assertSame($expectedContent, $content, 'Expected content from file is not same like actual.');
    }

    /**
     * @throws FileNotReadableException
     */
    public function testLoadNotExistingFile(): void
    {
        $fileName = 'dummy.txt';
        $this->expectException(FileNotExistException::class);
        $this->loader->load($this->root->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @throws FileNotExistException
     */
    public function testLoadNotReadableFile(): void
    {
        $file = vfsStream::newFile('file.txt', 000)->at($this->root)->setContent('');
        $this->expectException(FileNotReadableException::class);
        $this->loader->load($file->url());
    }
}
