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
     */
    public function getFromPost(array $post) {
        $name = $post['name'];
        $tmp_name = $post['tmp_name'];

        if (is_uploaded_file($tmp_name)) {
            if (move_uploaded_file($tmp_name, $this->savepath . $name)) {
                echo "Wysłano plik";
            } else {
                echo "Coś się nie udało";
            }
        } else {
            echo "Coś się nie udało";
        }
    }
}
