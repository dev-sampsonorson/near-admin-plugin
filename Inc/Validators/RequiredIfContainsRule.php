<?php

    use Rakit\Validation\Rule;

    class RequiredIfContainsRule extends Rule {

        protected $message = ":attribute required if :field contains :data";
        protected $fillableParams = ['field', 'data'];

        protected $entity = array();

        public function __construct($entity) {            
            $this->entity = $entity;
        }

        public function check($value): bool {
            try {
                // make sure required parameters exists
                $this->requireParameters(['field', 'data']);
    
                // getting parameters
                $field = $this->parameter('field');
                $fieldValue = $this->parameter('data');

                // check if object has field
                if (!property_exists($this->entity, $field))
                    return true;

                // check if field contains value
                if (strpos($this->entity->{$field}, $fieldValue) === false)
                    return true;
                
                if (empty(trim($value)))
                    return false;
    
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

    }
