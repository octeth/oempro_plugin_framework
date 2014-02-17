<?php

class model_db_setup extends model_base
{
	public function __construct()
	{

	}

	public function SetupDatabaseSchema()
	{
		$SQLQueries = array();

		$SQLQueries[] = $this->add_parameters("DROP TABLE IF EXISTS `oempro_plugin_framework_table1`;");
		$SQLQueries[] = $this->add_parameters("DROP TABLE IF EXISTS `oempro_plugin_framework_table2`;");
		$SQLQueries[] = $this->add_parameters("DROP TABLE IF EXISTS `oempro_plugin_framework_table3`;");

		foreach ($SQLQueries as $EachSQLQuery)
		{
			$Query = $this->query_result($EachSQLQuery);
		}

	}

}