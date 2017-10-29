<?php
abstract class Mail {
	private $blacklistedDomains = [
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
		"eelmail.com",
		"boximail.com",
		"vomoto.com",
		"tafmail.com",
		"clrmail.com",
		// mohmal.com
		"mailna.biz",
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

	public function isBlackListed($mail) {
		// On decoupe par le @, recupere la seconde partie, et verifie si celle ci n'est pas blacklist
		return ( array_search(split("@", $mail)[1], $this->blacklistedDomains) !== false);
	}
}
?>