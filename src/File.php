<?php

declare(strict_types=1);

class File {
    private string $filepath;
    private string $savepath = './uploads/';

    function __construct(string $path) {
        $this->setPath($path);
    }

    /**
     * Set filepath
     */
    public function setPath(string $path): void {
        $this->filepath = $path;
    }

    /**
     * Returns path to the file
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * Returns name of the file
     */
    public function getName(): string {
        return basename($this->getPath());
    }

    /**
     * Saves file sent by POST
     * @param $file - file value ($_FILES['inputname'] variable)
     */
    public function getFromPost(array $file) {
        $name = $file['name'];
        $tmp_name = $file['tmp_name'];

        try {
            $upload = move_uploaded_file($tmp_name, $this->savepath . $name);
            echo "Wysłano plik";
            return $upload;
        } catch(Exception $e) {
            throw new Exception($e);
        }
    }
}
