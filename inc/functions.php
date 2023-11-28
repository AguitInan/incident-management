<?php

	function date2En($dateStr)
	{
		$date = DateTime::createFromFormat("d/m/Y",$dateStr);
		return $date->format("Y-m-d");
	}

	function date2fr($dateStr)
	{
		$date = DateTime::createFromFormat("Y-m-d",$dateStr);
		return $date->format("d/m/Y");
	}

?>