<?php
    class DonationFormatter extends BaseFormatter {

        public function __construct() {
            parent::__construct();
        }

        public function format($data) : array {
            return array(
                "id" => $data->getId(),
                "emailAddress" => $data->emailAddress,
                "amount" => Helper::toNaira($data->amount),
                "reason" => $data->reason,
                "narration" => $data->narration,
                "insertDate" => !is_null($data->getInsertDate()) ? $data->getInsertDate()->format(TEBO_DATE_FORMAT) : ''
            );
        }

    }
