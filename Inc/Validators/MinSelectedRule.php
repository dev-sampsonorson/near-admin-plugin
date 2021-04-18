<?php

    use Rakit\Validation\Rule;

    class MinSelectedRule extends Rule {

        protected $message = ":attribute must have atleast :min selected";
        protected $fillableParams = ['min'];

        public function __construct() {

        }

        public function check($value): bool {
            try {
                // make sure required parameters exists
                $this->requireParameters(['min']);
    
                // getting parameters
                $min = intval($this->parameter('min'));

                $selectedOptions = explode(",", $value);

                if (count($selectedOptions) < $min)
                    return false;                
    
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

    }
