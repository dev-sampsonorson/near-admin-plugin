<?php

    class ScholarshipReferenceRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_REFERENCE_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipReference([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "lastName" => $row->lastName,
                        "firstName" => $row->firstName,
                        "otherNames" => $row->otherNames,
                        "occupation" => $row->occupation,
                        "position" => $row->position,
                        "address" => $row->address,
                        "phoneNumber" => $row->phoneNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship reference info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipReference {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipReference([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "lastName" => $row->lastName,
                        "firstName" => $row->firstName,
                        "otherNames" => $row->otherNames,
                        "occupation" => $row->occupation,
                        "position" => $row->position,
                        "address" => $row->address,
                        "phoneNumber" => $row->phoneNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship reference info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipReference {
            try {
                $query = "SELECT * FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipReference([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "lastName" => $row->lastName,
                        "firstName" => $row->firstName,
                        "otherNames" => $row->otherNames,
                        "occupation" => $row->occupation,
                        "position" => $row->position,
                        "address" => $row->address,
                        "phoneNumber" => $row->phoneNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship reference info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipReference $data): ?ScholarshipReference {
            try {                
                // $data->setInsertDate(Helper::toDateTimeFromString(current_time('mysql', 1)));
                $data->setInsertDate(Helper::toDateTimeFromString((new DateTime())->format(TEBO_DATETIME_FORMAT)));

                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);

                $result = $this->wpdb->insert(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'scholarshipId' => '%d',
                        'lastName' => '%s',
                        'firstName' => '%s',
                        'otherNames' => '%s',
                        'occupation' => '%s',
                        'position' => '%s',
                        'address' => '%s',
                        'phoneNumber' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship reference info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipReference $data): ?ScholarshipReference {
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
                        'lastName' => '%s',
                        'firstName' => '%s',
                        'otherNames' => '%s',
                        'occupation' => '%s',
                        'position' => '%s',
                        'address' => '%s',
                        'phoneNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship reference info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipReference $data): ?ScholarshipReference {
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
                        'lastName' => '%s',
                        'firstName' => '%s',
                        'otherNames' => '%s',
                        'occupation' => '%s',
                        'position' => '%s',
                        'address' => '%s',
                        'phoneNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship reference info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
