<?php

    class StateRepo extends BaseRepository {

        public function getTableName() {
            return BaseRepository::STATES_TABLE_NAME;
        }

        public function getAll(): ?array {
            try {
                $rows = array();
                $result = $this->wpdb->get_results("SELECT * FROM {$this->getTableName()}");
                
                foreach($result as $row) {           
                    $rows[] = new State([
                        "id" => $row->id,
                        "stateName" => $row->stateName,
                        "zoneId" => $row->zoneId,
                    ]);
                }

                if ($result === null)
                    return null;
    
                return $rows;
            } catch (Exception $e) {
                throw new Exception("States could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getById(int $id): ?State {
            try {

                if ($id <= 0)
                    return null;

                $query = "SELECT * FROM {$this->getTableName()} WHERE `id` = %d";
                $row = $this->wpdb->get_row($this->wpdb->prepare($query, $id));

                if ($row === null)
                    return null;
                    
                return new State([
                        "id" => $row->id,
                        "stateName" => $row->stateName,
                        "zoneId" => $row->zoneId,
                    ]);
            } catch (Exception $e) {
                throw new Exception("State could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

    }
