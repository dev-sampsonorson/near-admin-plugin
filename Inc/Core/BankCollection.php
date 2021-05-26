<?php

    class BankCollection {
        
        private static array $banks;
        
        public static function __constructStatic() {
            static::$banks ??= json_decode(file_get_contents(__DIR__ . '/banks.json'), true);
        }

        public static function getBanks() {
            return static::$banks;
        }

        public static function findBank($bankCode) {
            foreach(static::$banks as $index => $bank) {
                if ($bank["bankCode"] == $bankCode)
                    return new Bank($bank);
            }

            return null;
        }
    }

    BankCollection::__constructStatic();
