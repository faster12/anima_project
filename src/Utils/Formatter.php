<?php 

namespace App\Utils;

class Formatter {

	public function ImmutableToTimestamp($immutableDate = NULL) {

		// converte data
		$timestampDate = NULL;
		if($immutableDate){
            $dateTime = new \DateTime();
			$dateTime->setTimestamp($immutableDate->getTimestamp());
        }

        // return
        return $dateTime;
	}

}