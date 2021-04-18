<?php

    class ScholarshipSiblingRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_SIBLINGS_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipSibling([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "nSiblings" => $row->nSiblings,
                        "nSiblingsInPrimary" => $row->nSiblingsInPrimary,
                        "nSiblingsInSecondary" => $row->nSiblingsInSecondary,
                        "nSiblingsInUniversity" => $row->nSiblingsInUniversity,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship sibling info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipSibling {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipSibling([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "nSiblings" => $row->nSiblings,
                        "nSiblingsInPrimary" => $row->nSiblingsInPrimary,
                        "nSiblingsInSecondary" => $row->nSiblingsInSecondary,
                        "nSiblingsInUniversity" => $row->nSiblingsInUniversity,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship sibling info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipSibling {
            try {
                $query = "SELECT * FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipSibling([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "nSiblings" => $row->nSiblings,
                        "nSiblingsInPrimary" => $row->nSiblingsInPrimary,
                        "nSiblingsInSecondary" => $row->nSiblingsInSecondary,
                        "nSiblingsInUniversity" => $row->nSiblingsInUniversity,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship sibling info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipSibling $data): ?ScholarshipSibling {
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
                        'nSiblings' => '%d',
                        'nSiblingsInPrimary' => '%d',
                        'nSiblingsInSecondary' => '%d',
                        'nSiblingsInUniversity' => '%d',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship sibling info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipSibling $data): ?ScholarshipSibling {
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
                        'nSiblings' => '%d',
                        'nSiblingsInPrimary' => '%d',
                        'nSiblingsInSecondary' => '%d',
                        'nSiblingsInUniversity' => '%d',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship sibling info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipSibling $data): ?ScholarshipSibling {
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
                        'nSiblings' => '%d',
                        'nSiblingsInPrimary' => '%d',
                        'nSiblingsInSecondary' => '%d',
                        'nSiblingsInUniversity' => '%d',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship sibling info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
