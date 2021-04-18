<?php

    /**
     * @package Near Foundation Admin Plugin
     */

    class FileInfo {
        
        private $fileArray;
        private $newFilename;
        
        public function __construct($fileArray, $newFilename) {
            $this->fileArray = $fileArray;
            $this->newFilename = $newFilename;
        }

        public function getFileArray() {
            return $this->fileArray;
        }

        public function getNewFilename() {
            return $this->newFilename;
        }

        public function toArray() : array {
            return array(
                "fileArray" => $this->fileArray,
                "newFilename" => $this->newFilename,
            );
        }
    }
