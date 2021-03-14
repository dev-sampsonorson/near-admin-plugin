<?php

    class VolunteerRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::VOLUNTEER_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new Volunteer([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "mobileNumber" => $row->mobileNumber,
                        "emailAddress" => $row->emailAddress,
                        "birthDate" => $row->birthDate,
                        "gender" => $row->gender,
                        "address" => $row->address,
                        "availability" => $row->availability,
                        "volunteerInterest" => $row->volunteerInterest,
                        "volunteerInterestTutoring" => $row->volunteerInterestTutoring,
                        "volunteerInterestOther" => $row->volunteerInterestOther,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Volunteers could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?Volunteer {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new Volunteer([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "mobileNumber" => $row->mobileNumber,
                        "emailAddress" => $row->emailAddress,
                        "birthDate" => $row->birthDate,
                        "gender" => $row->gender,
                        "address" => $row->address,
                        "availability" => $row->availability,
                        "volunteerInterest" => $row->volunteerInterest,
                        "volunteerInterestTutoring" => $row->volunteerInterestTutoring,
                        "volunteerInterestOther" => $row->volunteerInterestOther,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Volunteer could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getByApproveStatus(bool $approve): ?Volunteer {
            try {
                $query = "SELECT a.* FROM {$this->getTableName()} WHERE `approve` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $approve));

                if ($row === null)
                    return null;
                    
                return new Volunteer([
                        "id" => $row->id,
                        "firstName" => $row->firstName,
                        "lastName" => $row->lastName,
                        "otherNames" => $row->otherNames,
                        "mobileNumber" => $row->mobileNumber,
                        "emailAddress" => $row->emailAddress,
                        "birthDate" => $row->birthDate,
                        "gender" => $row->gender,
                        "address" => $row->address,
                        "availability" => $row->availability,
                        "volunteerInterest" => $row->volunteerInterest,
                        "volunteerInterestTutoring" => $row->volunteerInterestTutoring,
                        "volunteerInterestOther" => $row->volunteerInterestOther,
                        "approved" => $row->approved,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
    
                return $row;
            } catch (Exception $e) {
                throw new Exception("Volunteer could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(Volunteer $data): ?Volunteer {
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
                        'mobileNumber' => '%s',
                        'emailAddress' => '%s',
                        'birthDate' => '%s',
                        'gender' => '%s',
                        'address' => '%s',
                        'availability' => '%s',
                        'volunteerInterest' => '%s',
                        'volunteerInterestTutoring' => '%s',
                        'volunteerInterestOther' => '%s',
                        'approved' => '%d',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create scholarship");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(Volunteer $data): ?Volunteer {
            try {
                $video = $audio = null;
                
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
                        'mobileNumber' => '%s',
                        'emailAddress' => '%s',
                        'birthDate' => '%s',
                        'gender' => '%s',
                        'address' => '%s',
                        'availability' => '%s',
                        'volunteerInterest' => '%s',
                        'volunteerInterestTutoring' => '%s',
                        'volunteerInterestOther' => '%s',
                        'approved' => '%d'
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update scholarship");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
