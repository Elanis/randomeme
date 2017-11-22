<?php
abstract class Mail {
	/**
	 * Determines if a mail is black listed.
	 *
	 * @param      <type>   $mail   The mail adress
	 *
	 * @return     boolean  True if black listed, False otherwise.
	 */
	static public function isBlackListed($mail) {
		$blacklistedDomains = [
			// yopmail
			"yopmail.com",
			"yopmail.fr",
			"yopmail.net",
			"cool.fr.nf",
			"jetable.fr.nf",
			"nospam.ze.tc",
			"nomail.xl.cx",
			"mega.zik.dj",
			"speed.1s.fr",
			"courriel.fr.nf",
			"moncourrier.fr.nf",
			"monemail.fr.nf",
			"monmail.fr.nf",
			// crazymailing.com
			"vmani.com",
			"wimsg.com",
			// getairmail.com
			"getairmail.com",
			"eelmail.com",
			"boximail.com",
			"vomoto.com",
			"tafmail.com",
			"clrmail.com",
			"imgof.com",
			// mohmal.com
			"mailna.biz",
			"emailo.pro",
			// 10minutemail.com
			"mvrht.net",
			// jetable.org
			"jetable.org",
			// mailHazard.com
			"mailHazard.com",
			//mail-temporaire.fr
			"mail-temporaire.fr",
			//spamfree24.org
			"spamfree24.org"
		];

		// On decoupe par le @, recupere la seconde partie, et verifie si celle ci n'est pas blacklist
		return ( array_search(explode("@", $mail)[1], $blacklistedDomains) !== false);
	}
}
?>