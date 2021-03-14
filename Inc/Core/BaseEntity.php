<?php

    /**
     * @package Near Foundation Admin Plugin
     */

    abstract class BaseEntity {
        protected $id = 0; // int
        protected $insertDate = null; // ?DateTime 
        protected $updateDate = null; // ?DateTime 

        protected function __construct(array $config) {
            // , ?DateTime $insertDate, ?DateTime $updateDate, int $id = 0
            // $this->id = $id;
            // $this->insertDate = $insertDate; //new DateTime('now', new DateTimeZone(WB_CURRENT_TIMEZONE))
            // $this->updateDate = $updateDate;
            
            foreach($config as $key => $value) {
                // check if *key is navigation property
                if (strpos($key, "__") !== false) {
                    // true: trim off first 2 characters
                    $key = substr($key, 2);
    
                    // check if key/property exists
                    if (!property_exists($this, $key))
                        continue;

                    $className = ucfirst($key); // $value['className'];
                    $argument = $value;

                    $refArgs = array();

                    if (method_exists($className, '__construct') === false) {
                        exit("Constructor for the class <strong>$className</strong> does not exist");
                    }

                    $refMethod = new ReflectionMethod($className,  '__construct');
                    $params = $refMethod->getParameters();
                    // print_r($params);

                    foreach($params as $paramKey => $paramValue) {
                        if ($paramValue->name !== 'config')
                            continue;
                        
                        if ($paramValue->isPassedByReference()) {
                            $refArgs[$paramKey] = &$argument;
                        } else {
                            $refArgs[$paramKey] = $argument;
                        }
                    }
   

                    $refClass = new ReflectionClass($className);
                    $classInstance = $refClass->newInstanceArgs((array) $refArgs);
                    
                    if (property_exists($this, $key)) {
                        $this->{$key} = $classInstance;
                    }

                    continue;
                } 
                
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

        public function getId(): int {
            return $this->id;
        }

        public function setId(int $id) {
            $this->id = $id;
        }

        public function isNew() {
            return $this->id <= 0;
        }        

        public function setInsertDate(?DateTime $date) {
            $this->insertDate = $date;
        }

        public function setUpdateDate(?DateTime $date) {
            $this->updateDate = $date;
        }

        public function getInsertDate(): ?DateTime {
            return $this->insertDate;
        }
        
        public function getUpdateDate(): ?DateTime {
            return $this->updateDate;
        }

        public abstract function validate() : bool;
        public abstract function toArray() : array;
    }
