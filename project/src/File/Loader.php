<?php

namespace App\File;

final class Loader
{
    /**
     * @param string $fileName
     * @return string
     * @throws FileNotReadableException
     * @throws FileNotExistException
     */
    public function load(string $fileName): string
    {
        if (file_exists($fileName) === false) {
            throw new FileNotExistException(sprintf('The file `%s` does not exist.', $fileName));
        }

        if (is_readable($fileName) === false) {
            throw new FileNotReadableException(sprintf('Can not read the file `%s`', $fileName));
        }

        $content = file_get_contents($fileName);

        if ($content === false) {
            throw new FileNotReadableException(sprintf('Failed to read the file `%s`', $fileName));
        }

        return trim($content);
    }
}
