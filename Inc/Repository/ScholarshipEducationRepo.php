<?php

    class ScholarshipEducationRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::SCHOLARSHIP_EDUCATION_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new ScholarshipEducation([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "level" => $row->level,
                        "schoolName" => $row->schoolName,
                        "department" => $row->department,
                        "class" => $row->class,
                        "city" => $row->city,
                        "state" => $row->state,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Scholarship education info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?ScholarshipEducation {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new ScholarshipEducation([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "level" => $row->level,
                        "schoolName" => $row->schoolName,
                        "department" => $row->department,
                        "class" => $row->class,
                        "city" => $row->city,
                        "state" => $row->state,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Scholarship education info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByScholarshipId(int $scholarshipId): ?ScholarshipEducation {
            try {
                $query = "SELECT * FROM {$this->getTableName()} WHERE `scholarshipId` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $scholarshipId));

                if ($row === null)
                    return null;
                    
                return new ScholarshipEducation([
                        "id" => $row->id,
                        "scholarshipId" => $row->scholarshipId,
                        "level" => $row->level,
                        "schoolName" => $row->schoolName,
                        "department" => $row->department,
                        "class" => $row->class,
                        "city" => $row->city,
                        "state" => $row->state,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Scholarship education info could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(ScholarshipEducation $data): ?ScholarshipEducation {
            try {                
                $data->setInsertDate(Helper::toDateTimeFromString(current_time('mysql', 1)));

                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);

                $result = $this->wpdb->insert(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'scholarshipId' => '%d',
                        'level' => '%s',
                        'schoolName' => '%s',
                        'department' => '%s',
                        'class' => '%s',
                        'city' => '%s',
                        'state' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship education info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(ScholarshipEducation $data): ?ScholarshipEducation {
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
                        'level' => '%s',
                        'schoolName' => '%s',
                        'department' => '%s',
                        'class' => '%s',
                        'city' => '%s',
                        'state' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship education info");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function updateByScholarshipId(ScholarshipEducation $data): ?ScholarshipEducation {
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
                        'level' => '%s',
                        'schoolName' => '%s',
                        'department' => '%s',
                        'class' => '%s',
                        'city' => '%s',
                        'state' => '%s',
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship education info");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
