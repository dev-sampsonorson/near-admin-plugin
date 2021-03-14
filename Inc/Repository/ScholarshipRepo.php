<?php

    class ScholarshipRepo extends BaseRepository {

        protected $scholarshipBankRepo;
        protected $scholarshipEducationRepo;
        protected $scholarshipFatherRepo;
        protected $scholarshipMotherRepo;
        protected $scholarshipSiblingRepo;
        protected $scholarshipDocumentRepo;
        protected $scholarshipReferenceRepo;

        public function __construct() {
            parent::__construct();
            
            $this->scholarshipBankRepo = new ScholarshipBankRepo();
            $this->scholarshipEducationRepo = new ScholarshipEducationRepo();
            $this->scholarshipFatherRepo = new ScholarshipFatherRepo();
            $this->scholarshipMotherRepo = new ScholarshipMotherRepo();
            $this->scholarshipSiblingRepo = new ScholarshipSiblingRepo();
            $this->scholarshipDocumentRepo = new ScholarshipDocumentRepo();
            $this->scholarshipReferenceRepo = new ScholarshipReferenceRepo();
        }

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new Scholarship([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "nationalIdNumber" => $row->nationalIdNumber,
                        "birthPlace" => $row->birthPlace,
                        "birthDate" => $row->birthDate,
                        "emailAddress" => $row->emailAddress,
                        "mobileNumber" => $row->mobileNumber,
                        "parentNumber" => $row->parentNumber,
                        "gotScholarshipLastYear" => $row->gotScholarshipLastYear,
                        "requiredScholarships" => $row->requiredScholarships,
                        "fileId" => $row->fileId,
                        "address" => $row->address,
                        "howKnowFoundation" => $row->howKnowFoundation,
                        "volunteerInterest" => $row->volunteerInterest,
                        "whyScholarship" => $row->whyScholarship,
                        "iAgree" => $row->iAgree,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarships could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?Scholarship {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new Scholarship([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "nationalIdNumber" => $row->nationalIdNumber,
                        "birthPlace" => $row->birthPlace,
                        "birthDate" => $row->birthDate,
                        "emailAddress" => $row->emailAddress,
                        "mobileNumber" => $row->mobileNumber,
                        "parentNumber" => $row->parentNumber,
                        "gotScholarshipLastYear" => $row->gotScholarshipLastYear,
                        "requiredScholarships" => $row->requiredScholarships,
                        "fileId" => $row->fileId,
                        "address" => $row->address,
                        "howKnowFoundation" => $row->howKnowFoundation,
                        "volunteerInterest" => $row->volunteerInterest,
                        "whyScholarship" => $row->whyScholarship,
                        "iAgree" => $row->iAgree,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByApproveStatus(bool $approve): ?Scholarship {
            try {
                $query = "SELECT a.* FROM {$this->getTableName()} WHERE `approve` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $approve));

                if ($row === null)
                    return null;
                    
                return new Scholarship([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "nationalIdNumber" => $row->nationalIdNumber,
                        "birthPlace" => $row->birthPlace,
                        "birthDate" => $row->birthDate,
                        "emailAddress" => $row->emailAddress,
                        "mobileNumber" => $row->mobileNumber,
                        "parentNumber" => $row->parentNumber,
                        "gotScholarshipLastYear" => $row->gotScholarshipLastYear,
                        "requiredScholarships" => $row->requiredScholarships,
                        "fileId" => $row->fileId,
                        "address" => $row->address,
                        "howKnowFoundation" => $row->howKnowFoundation,
                        "volunteerInterest" => $row->volunteerInterest,
                        "whyScholarship" => $row->whyScholarship,
                        "iAgree" => $row->iAgree,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(Scholarship $data): ?Scholarship {
            try {                
                $data->setInsertDate(Helper::toDateTimeFromString(current_time('mysql', 1)));

                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);

                $result = $this->wpdb->insert(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'firstName' => '%s',
                        'lastName' => '%s',
                        'otherNames' => '%s',
                        'nationalIdNumber' => '%s',
                        'birthPlace' => '%s',
                        'birthDate' => '%s',
                        'emailAddress' => '%s',
                        'mobileNumber' => '%s',
                        'parentNumber' => '%s',
                        'gotScholarshipLastYear' => '%d',
                        'requiredScholarships' => '%s',
                        'fileId' => '%s',
                        'address' => '%s',
                        'howKnowFoundation' => '%s',
                        'volunteerInterest' => '%d',
                        'whyScholarship' => '%s',
                        'iAgree' => '%d',
                        'approved' => '%d',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                $data->scholarshipBank->setScholarshipId($data->getId());
                $data->scholarshipEducation->setScholarshipId($data->getId());
                $data->scholarshipFather->setScholarshipId($data->getId());
                $data->scholarshipMother->setScholarshipId($data->getId());
                $data->scholarshipSibling->setScholarshipId($data->getId());
                $data->scholarshipDocument->setScholarshipId($data->getId());
                $data->scholarshipReference->setScholarshipId($data->getId());

                // Scholarship Bank
                $this->scholarshipBankRepo->insert($data->scholarshipBank);

                // Scholarship Education
                $this->scholarshipEducationRepo->insert($data->scholarshipEducation);

                // Scholarship Father
                $this->scholarshipFatherRepo->insert($data->scholarshipFather);

                // Scholarship Mother
                $this->scholarshipMotherRepo->insert($data->scholarshipMother);

                // Scholarship Sibling
                $this->scholarshipSiblingRepo->insert($data->scholarshipSibling);

                // Scholarship Document
                $this->scholarshipDocumentRepo->insert($data->scholarshipDocument);

                // Scholarship Reference
                $this->scholarshipReferenceRepo->insert($data->scholarshipReference);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(Scholarship $data): ?Scholarship {
            try {                
                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);
                unset($dataAsArray["insertDate"]);

                $result = $this->wpdb->update(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'id' => $data->getId()
                    ),
                    array(
                        'firstName' => '%s',
                        'lastName' => '%s',
                        'otherNames' => '%s',
                        'nationalIdNumber' => '%s',
                        'birthPlace' => '%s',
                        'birthDate' => '%s',
                        'emailAddress' => '%s',
                        'mobileNumber' => '%s',
                        'parentNumber' => '%s',
                        'gotScholarshipLastYear' => '%d',
                        'requiredScholarships' => '%s',
                        'fileId' => '%s',
                        'address' => '%s',
                        'howKnowFoundation' => '%s',
                        'volunteerInterest' => '%d',
                        'whyScholarship' => '%s',
                        'iAgree' => '%d',
                        'approved' => '%d'
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                    echo "update";

                $data->scholarshipBank->setScholarshipId($data->getId());
                $data->scholarshipEducation->setScholarshipId($data->getId());
                $data->scholarshipFather->setScholarshipId($data->getId());
                $data->scholarshipMother->setScholarshipId($data->getId());
                $data->scholarshipSibling->setScholarshipId($data->getId());
                $data->scholarshipDocument->setScholarshipId($data->getId());
                $data->scholarshipReference->setScholarshipId($data->getId());

                echo "<pre>";
                print_r($data->scholarshipBank);
                echo "</pre>";

                // Scholarship Bank
                $this->scholarshipBankRepo->updateByScholarshipId($data->scholarshipBank);

                // Scholarship Education
                $this->scholarshipEducationRepo->updateByScholarshipId($data->scholarshipEducation);

                // Scholarship Father
                $this->scholarshipFatherRepo->updateByScholarshipId($data->scholarshipFather);

                // Scholarship Mother
                $this->scholarshipMotherRepo->updateByScholarshipId($data->scholarshipMother);

                // Scholarship Sibling
                $this->scholarshipSiblingRepo->updateByScholarshipId($data->scholarshipSibling);

                // Scholarship Document
                $this->scholarshipDocumentRepo->updateByScholarshipId($data->scholarshipDocument);

                // Scholarship Reference
                $this->scholarshipReferenceRepo->updateByScholarshipId($data->scholarshipReference);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
