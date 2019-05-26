<?php

class Rooter {
    private $_page;
    private $_content = array();

    public function __construct($page) {
        $this->_page = Lib::Sanitize($page.".php");
        $this->generateContent();
    }

    private function generateContent() {
        $pages = scandir("pages/");
        $arr = array();
        foreach ($pages as $page) {
            $page = Lib::Sanitize("pages/".$page);
            if ($page != "pages/." && $page != "pages/..") {
                if (is_dir($page)) {
                    $page = $page."/";
                    $this->scanDirectory($page);
                } else {
                    $this->_content[substr($this->getFileName($page), 0, -4)] = $page;
                }
            }
        }
    }

    private function scanDirectory($dir) {
        $pages = scandir($dir);
        $arr = array();
        foreach ($pages as $page) {
            $page = Lib::Sanitize($dir.$page);
            if ($page != $dir."." && $page != $dir."..") {
                if (is_dir($page)) {
                    $page = $page."/";
                    $this->scanDirectory($page);
                } else
                    $this->_content[substr($this->getFileName($page), 0, -4)] = $page;
            }
        }
    }

    private function getFileName($file) {
        $nameTmp = explode("/", $file);
        return $nameTmp[count($nameTmp) - 1];
    }

    public function getContent() {
        $contentTmp = $this->_content;
        $fileNameArr = array();
        foreach ($contentTmp as $filePath) {
            $fileName = $this->getFileName($filePath);
            $fileNameArr[substr($fileName, 0, -4)] = $fileName;
        }    
        if (in_array($this->_page, $fileNameArr))
            return $this->_content[substr($this->_page, 0, -4)];
        else
            header("Location:index.php?page=home");
    }
};
