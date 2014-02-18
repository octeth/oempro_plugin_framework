<?php

class model_example extends model_base
{
	public function __construct()
	{

	}

	public function ExampleGetRecords()
	{
		$SQLQuery = $this->add_parameters("SELECT * FROM oempro_users WHERE UserID>=? AND UserID<=?", array(1, 100));

		$Query = $this->query_result($SQLQuery);
		if (is_bool($Query) == true && $Query == false) return false;

		return $Query;
	}

}