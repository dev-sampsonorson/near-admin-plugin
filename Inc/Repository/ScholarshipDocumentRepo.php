<?php

    class ScholarshipDocumentRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_DOCUMENTS_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipDocument([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "requestLetter" => $row->requestLetter,
                        "admissionLetter" => $row->admissionLetter,
                        "jambResult" => $row->jambResult,
                        "waecResult" => $row->waecResult,
                        "matriculationNumber" => $row->matriculationNumber,
                        "indigeneCertificate" => $row->indigeneCertificate,
                        "birthCertificate" => $row->birthCertificate,
                        "validIdCard" => $row->validIdCard,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship document info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipDocument {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipDocument([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "requestLetter" => $row->requestLetter,
                        "admissionLetter" => $row->admissionLetter,
                        "jambResult" => $row->jambResult,
                        "waecResult" => $row->waecResult,
                        "matriculationNumber" => $row->matriculationNumber,
                        "indigeneCertificate" => $row->indigeneCertificate,
                        "birthCertificate" => $row->birthCertificate,
                        "validIdCard" => $row->validIdCard,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship document info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipDocument {
            try {
                $query = "SELECT a.* FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipDocument([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "requestLetter" => $row->requestLetter,
                        "admissionLetter" => $row->admissionLetter,
                        "jambResult" => $row->jambResult,
                        "waecResult" => $row->waecResult,
                        "matriculationNumber" => $row->matriculationNumber,
                        "indigeneCertificate" => $row->indigeneCertificate,
                        "birthCertificate" => $row->birthCertificate,
                        "validIdCard" => $row->validIdCard,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship document info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipDocument $data): ?ScholarshipDocument {
            try {                
                $data->setInsertDate(Helper::toDateTimeFromString(current_time('mysql', 1)));

                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);

                $result = $this->wpdb->insert(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'scholarshipId' => '%d',
                        'requestLetter' => '%s',
                        'admissionLetter' => '%s',
                        'jambResult' => '%s',
                        'waecResult' => '%s',
                        'matriculationNumber' => '%s',
                        'indigeneCertificate' => '%s',
                        'birthCertificate' => '%s',
                        'validIdCard' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship document info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipDocument $data): ?ScholarshipDocument {
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
                        'scholarshipId' => '%d',
                        'requestLetter' => '%s',
                        'admissionLetter' => '%s',
                        'jambResult' => '%s',
                        'waecResult' => '%s',
                        'matriculationNumber' => '%s',
                        'indigeneCertificate' => '%s',
                        'birthCertificate' => '%s',
                        'validIdCard' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship document info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipDocument $data): ?ScholarshipDocument {
            try {                
                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);
                unset($dataAsArray["scholarshipId"]);
                unset($dataAsArray["insertDate"]);

                $result = $this->wpdb->update(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'scholarshipId' => $data->getScholarshipId()
                    ),
                    array(
                        // 'scholarshipId' => '%d',
                        'requestLetter' => '%s',
                        'admissionLetter' => '%s',
                        'jambResult' => '%s',
                        'waecResult' => '%s',
                        'matriculationNumber' => '%s',
                        'indigeneCertificate' => '%s',
                        'birthCertificate' => '%s',
                        'validIdCard' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship document info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
