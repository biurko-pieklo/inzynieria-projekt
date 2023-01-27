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
     * @param $path - path to file
     */
    public function setPath(string $path): void {
        $this->filepath = $path;
    }

    /**
     * Returns path to the file
     */
    public function getPath(): string {
        return $this->filepath;
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
    public function getFromPost(array $file, string $path = './uploads/') {
        try {
            $name = $this->diffName($file['name'], 1);
            $upload = move_uploaded_file($file['tmp_name'], $path . $name);
            if ($upload) {
                echo "File sent";
                return $name;
            }
        } catch(Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * Sets different name for file if a file with the same name exists
     * @param $name - this is the name function checks
     * @param $filenr - number added to file name 
     */
    private function diffName(string $name, int $filenr) {
        if (!file_exists($this->savepath . $name)) {
            return $name;
        } else {
            return $this->diffName(pathinfo($this->getName(), PATHINFO_FILENAME) . ' (' . $filenr . ').' . pathinfo($this->getName(), PATHINFO_EXTENSION), ++$filenr);
        }
    }
}
