<?php

    abstract class BaseFormatter {

        public function __construct() {

        }
        
        public abstract function format($data) : array;
    }
