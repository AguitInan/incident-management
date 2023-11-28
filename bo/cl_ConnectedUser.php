<?php

class ConnectedUser
{
	private $user;
	private $domain;
	private $workstation;
	
	public function Getuser()
	{
		return $this->user;
	}
	public function Setuser($nvo_user)
	{
		$this->user = $nvo_user;
	}
	public function Getdomain()
	{
		return $this->domain;
	}
	public function Setdomain($nvo_domain)
	{
		$this->domain = $nvo_domain;
	}
	public function Getworkstation()
	{
		return $this->workstation;
	}
	public function Setworkstation($nvo_workstation)
	{
		$this->workstation = $nvo_workstation;
	}
}
?>