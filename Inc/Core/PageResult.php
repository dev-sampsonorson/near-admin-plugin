<?php

    class PageResult {

        public $result; // array
        public $recordTotal; // int
        public $pages; // array
        public $pageSize; // int
        public $pageNumber; // int
        public $startIndex; // int

        public $startRecord; // int
        public $endRecord; // int

        public function __construct(array $result, int $recordTotal, int $pageNumber, int $pageSize) {
            $this->result = $result;
            $this->recordTotal = $recordTotal;
            $this->pageSize = $pageSize;
            $this->pageNumber = $pageNumber;
            $this->startIndex = ($pageNumber - 1) * $pageSize;
            $this->endIndex = ($this->startIndex + $pageSize) - 1;
            $this->totalPage = ceil($this->recordTotal / $pageSize);

            $this->startRecord = $this->startIndex + 1;
            $this->endRecord = min($this->endIndex + 1, $recordTotal);

            for ($i = 1; $i <= $this->totalPage; $i++) {
                $this->pages[] = $i;
            }
        }
    }
