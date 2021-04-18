<?php

    class ScholarshipBankRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_BANK_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipBank([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "bankName" => $row->bankName,
                        "branchName" => $row->branchName,
                        "accountNumber" => $row->accountNumber,
                        "ibanNumber" => $row->ibanNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship bank info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipBank {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipBank([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "bankName" => $row->bankName,
                        "branchName" => $row->branchName,
                        "accountNumber" => $row->accountNumber,
                        "ibanNumber" => $row->ibanNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship bank info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipBank {
            try {
                $query = "SELECT * FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipBank([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "bankName" => $row->bankName,
                        "branchName" => $row->branchName,
                        "accountNumber" => $row->accountNumber,
                        "ibanNumber" => $row->ibanNumber,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship bank info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipBank $data): ?ScholarshipBank {
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
                        'bankName' => '%s',
                        'branchName' => '%s',
                        'accountNumber' => '%s',
                        'ibanNumber' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship bank info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipBank $data): ?ScholarshipBank {
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
                        'bankName' => '%s',
                        'branchName' => '%s',
                        'accountNumber' => '%s',
                        'ibanNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship bank info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipBank $data): ?ScholarshipBank {
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
                        'bankName' => '%s',
                        'branchName' => '%s',
                        'accountNumber' => '%s',
                        'ibanNumber' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship bank info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
