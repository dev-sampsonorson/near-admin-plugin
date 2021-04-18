<?php
    class ReportRepo extends BaseRepository {

        public function getTableName() {
            return "";
        }

        public function getVolunteerReport(string $searchTerm, int $pageNumber, int $pageSize): ?PageResult {
            try {
                $rows = array();

                $whereClause = !empty($searchTerm) ? "WHERE emailAddress = '{$searchTerm}' OR mobileNumber = '{$searchTerm}' " : "WHERE 1 ";
                $recordTotal = $this->wpdb->get_var("SELECT COUNT(*) FROM `" . BaseRepository::VOLUNTEER_TABLE_NAME . "` AS a {$whereClause}") ?? 0;
                
                $result = $this->wpdb->get_results("SELECT a.*, CONCAT(lastName, ', ', firstName) AS volunteerName 
                FROM `" . BaseRepository::VOLUNTEER_TABLE_NAME . "` AS a
                {$whereClause}  
                ORDER BY insertDate DESC
                LIMIT ". (($pageNumber - 1) * $pageSize) . ", " . $pageSize);
                
                foreach($result as $row) {
                    $rows[] = new VolunteerReport([
                        "id" => $row->id,
                        "volunteerName" => $row->volunteerName,
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
    
                return new PageResult($rows, $recordTotal, $pageNumber, $pageSize);
            } catch (Exception $e) {
                throw new Exception("Volunteer report could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getScholarshipAppsReport(string $searchTerm, int $pageNumber, int $pageSize): ?PageResult {
            try {
                $rows = array();

                $whereClause = !empty($searchTerm) ? "WHERE emailAddress = '{$searchTerm}' OR mobileNumber = '{$searchTerm}' " : "WHERE 1 ";
                $recordTotal = $this->wpdb->get_var("SELECT COUNT(*) FROM `" . BaseRepository::SCHOLARSHIP_TABLE_NAME . "` AS a {$whereClause}") ?? 0;
                
                $result = $this->wpdb->get_results("SELECT a.*, CONCAT(lastName, ', ', firstName) AS applicantName 
                FROM `" . BaseRepository::SCHOLARSHIP_TABLE_NAME . "` AS a
                {$whereClause}  
                ORDER BY insertDate DESC
                LIMIT ". (($pageNumber - 1) * $pageSize) . ", " . $pageSize);
                
                foreach($result as $row) {
                    $rows[] = new ScholarshipReport([
                        "id" => $row->id,
                        "applicantName" => $row->applicantName,
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
    
                return new PageResult($rows, $recordTotal, $pageNumber, $pageSize);
            } catch (Exception $e) {
                throw new Exception("Scholarship applications report could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }

        public function getDonationReport(string $searchTerm, int $pageNumber, int $pageSize): ?PageResult {
            try {
                $rows = array();

                $whereClause = !empty($searchTerm) ? "WHERE emailAddress = '{$searchTerm}' OR amount = '{$searchTerm}' " : "WHERE 1 ";
                $recordTotal = $this->wpdb->get_var("SELECT COUNT(*) FROM `" . BaseRepository::DONATION_TABLE_NAME . "` AS a {$whereClause}") ?? 0;
                
                $result = $this->wpdb->get_results("SELECT a.* 
                FROM `" . BaseRepository::DONATION_TABLE_NAME . "` AS a
                {$whereClause} 
                ORDER BY insertDate DESC
                LIMIT ". (($pageNumber - 1) * $pageSize) . ", " . $pageSize);
                
                foreach($result as $row) {                    
                    $rows[] = new DonationReport([
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
    
                return new PageResult($rows, $recordTotal, $pageNumber, $pageSize);
            } catch (Exception $e) {
                throw new Exception("Donation report could not be found");
            } finally {
                $this->wpdb->flush();
            }
        }
    }
