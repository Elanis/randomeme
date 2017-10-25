<?php
/* ============== MODELS ============== */
class User
{
	private $id;
	private $username = "Mr. Smith";
	private $level = 1;
	private $levels = [BANNED, VISITOR, MEMBER, MODERATOR, ADMINISTRATOR, OWNER];
	private $avatar;
	private $langue;

	public function __construct($data)
	{
		$this->setData($data);
	}

	/* Get User variables */
	public function getLevel() {
		return $this->lvl;
	}
	public function getUsername() {
		return $this->username;
	}
	public function getId() {
		return $this->id;
	}

	/* Level Based Functions */
	public function isConnected() {
		return ($this->id >= 2);
	}
	public function isAdmin() {
		return ($this->id == 4);
	}
	public function isModerator() {
		return ($this->id >= 3);
	}
	public function isBanned() {
		return ($this->id == 0);
	}
	public function getLevelName() {
		return $this->levels[$this->lvl];
	}

	public function avatar() {
		return $this->avatar;
	}

	public function langue() {
		return $this->langue;
	}

	public function setData($data) {
		$this->id = (isset($data['id']))?$data['id']:0;
		$this->username = (isset($data['username']))?$data['username']:'';
		$this->level = (isset($data['level']))?$data['level']:1;
		$this->langue = (isset($data['lang']))?$data['lang']:'';
		$this->avatar = (isset($data['avatar']))?$data['avatar']:'';
	}
}