<?php
    class Bank {
        
        public $bankId;
        public $bankName;
        public $bankCode;
        public $bankSortCode;
        
        public function __construct(array $bank) {
            $this->bankId = $bank["bankId"];
            $this->bankName = $bank["bankName"];
            $this->bankCode = $bank["bankCode"];
            $this->bankSortCode = $bank["bankSortCode"];
        }

        public function toArray() : array {
            return array(
                "bankId" => $this->bankId,
                "bankName" => $this->bankName,
                "bankCode" => $this->bankCode,
                "bankSortCode" => $this->bankSortCode
            );
        }
    }
