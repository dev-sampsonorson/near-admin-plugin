<?php

    class ScholarshipMotherRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_MOTHER_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipMother([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "name" => $row->name,
                        "aliveOrDeceased" => $row->aliveOrDeceased,
                        "occupation" => $row->occupation,
                        "monthlyIncome" => $row->monthlyIncome,
                        "city" => $row->city,
                        "state" => $row->state,
                        "mobileNumber" => $row->mobileNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship mother info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipMother {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipMother([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "name" => $row->name,
                        "aliveOrDeceased" => $row->aliveOrDeceased,
                        "occupation" => $row->occupation,
                        "monthlyIncome" => $row->monthlyIncome,
                        "city" => $row->city,
                        "state" => $row->state,
                        "mobileNumber" => $row->mobileNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship mother info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipMother {
            try {
                $query = "SELECT * FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipMother([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "name" => $row->name,
                        "aliveOrDeceased" => $row->aliveOrDeceased,
                        "occupation" => $row->occupation,
                        "monthlyIncome" => $row->monthlyIncome,
                        "city" => $row->city,
                        "state" => $row->state,
                        "mobileNumber" => $row->mobileNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship mother info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipMother $data): ?ScholarshipMother {
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
                        'name' => '%s',
                        'aliveOrDeceased' => '%s',
                        'occupation' => '%s',
                        'monthlyIncome' => '%f',
                        'city' => '%s',
                        'state' => '%s',
                        'mobileNumber' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship mother info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipMother $data): ?ScholarshipMother {
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
                        'name' => '%s',
                        'aliveOrDeceased' => '%s',
                        'occupation' => '%s',
                        'monthlyIncome' => '%f',
                        'city' => '%s',
                        'state' => '%s',
                        'mobileNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship mother info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipMother $data): ?ScholarshipMother {
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
                        'name' => '%s',
                        'aliveOrDeceased' => '%s',
                        'occupation' => '%s',
                        'monthlyIncome' => '%f',
                        'city' => '%s',
                        'state' => '%s',
                        'mobileNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship mother info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
