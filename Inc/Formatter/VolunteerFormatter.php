<?php
    class VolunteerFormatter extends BaseFormatter {
        
        private $stateRepo;
        private $availabilityOptions;
        private $volunteerInterestOptions;

        public function __construct() {
            parent::__construct();

            $this->stateRepo = new StateRepo();

            $this->availabilityOptions = array (
                "chkMorningsMondayToFriday" => "Mornings (Monday - Friday)",
                "chkEveningsMondayToFriday" => "Evenings (Monday - Friday)",
                "chkOnceAWeek" => "Once a week",
                "chkOneTimeOnly" => "One time only",
                "chkAfternoonsMondayToFriday" => "Afternons (Monday - Friday)",
                "chkWeekends" => "Weekends",
                "chkMoreThanOnceAWeek" => "More than once a week",
                "chkAsNeeded" => "As needed",
            );

            $this->volunteerInterestOptions = array (
                "chkSportsCoachOrAssistant" => "Sports coach/assistant",
                "chkHelpChildrenRead" => "Helping children read or reading to them",
                "chkMentoringTeens" => "Mentoring Teens",
                "chkOrphanageVisiting" => "Orphanage visiting",
                "chkCommunityWork" => "Community work",
                "chkInterestTutoring" => "Tutoring", //?
                "chkNotListedActivityOfInterest" => "Activities not listed that I'm interested in", //?
                "chkArtCraftActivityInstructor" => "Arts & Craft activity instructor/assistant",
                "chkAssistingWithFundraising" => "Assisting with fundraising",
                "chkHelpingChildrenUseComputers" => "Helping children use computers",
                "chkCharityShop" => "Charity shop",
            );
        }

        public function format($data) : array {
            // $availabilityArray = explode(",", $data->availability);
            $availabilitySelected = [];
            $volunteerInterestSelected = [];

            foreach (explode(",", $data->availability) as $value) {
                $availabilitySelected[] = $this->availabilityOptions[$value];
            }

            foreach (explode(",", $data->volunteerInterest) as $value) {
                $volunteerInterestSelected[] = $this->volunteerInterestOptions[$value];
            }

            $state = $this->stateRepo->getById($data->stateOfOrigin);


            return array(
                "id" => $data->getId(),
                "firstName" => $data->firstName,
                "lastName" => $data->lastName,
                "otherNames" => $data->otherNames,
                "mobileNumber" => $data->mobileNumber,
                "emailAddress" => $data->emailAddress,
                "birthDate" => !is_null($data->birthDate) ? $data->birthDate->format(TEBO_DATE_FORMAT) : '',
                "gender" => $data->gender,
                "stateOfOrigin" => $state->stateName,
                "address" => $data->address,
                "availability" => $availabilitySelected,
                "volunteerInterest" => $volunteerInterestSelected,
                "volunteerInterestTutoring" => $data->volunteerInterestTutoring ?? "",
                "volunteerInterestOther" => $data->volunteerInterestOther ?? "",
                "approved" => ($data->approved ?? false) ? 'Approved' : 'Not Approved',
                "insertDate" => !is_null($data->getInsertDate()) ? $data->getInsertDate()->format(TEBO_DATE_FORMAT) : ''
            );
        }

    }
