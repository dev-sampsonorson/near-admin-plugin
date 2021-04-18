<?php

    class DonationRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::DONATION_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new Donation([
                        "id" => $row->id,
                        "emailAddress" => $row->emailAddress,
                        "amount" => $row->amount,
                        "reason" => $row->reason,
                        "narration" => $row->narration,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("Donations could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?Donation {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new Donation([
                        "id" => $row->id,
                        "emailAddress" => $row->emailAddress,
                        "amount" => $row->amount,
                        "reason" => $row->reason,
                        "narration" => $row->narration,
                        "insertDate" => Helper::toDateTimeFromString($row->insertDate)
                    ]);
            } catch (Exception $e) {
                throw new Exception("Donation could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function insert(Donation $data): ?Donation {
            try {                
                // $data->setInsertDate(Helper::toDateTimeFromString(current_time('mysql', 1)));
                $data->setInsertDate(Helper::toDateTimeFromString((new DateTime())->format(TEBO_DATETIME_FORMAT)));

                $dataAsArray = $data->toArray();
                unset($dataAsArray["id"]);

                $result = $this->wpdb->insert(
                    $this->getTableName(), 
                    $dataAsArray,
                    array(
                        'emailAddress' => '%s',
                        'amount' => '%s',
                        'reason' => '%s',
                        'narration' => '%s',
                        'insertDate' => '%s'
                    )
                );

                if ($result === false)
                    return null;

                $data->setId($this->wpdb->insert_id);

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to create donation");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function update(Donation $data): ?Donation {
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
                        'emailAddress' => '%s',
                        'amount' => '%s',
                        'reason' => '%s',
                        'narration' => '%s'
                    ),
                    array('%d')
                );

                if ($result === false)
                    return null;

                return $data;
            } catch (Exception $e) {
                throw new Exception("Unable to update donation");
            } finally {
                $this->wpdb->flush();
            }
        }
    }
