<?php

class model_base
{
	public function __construct()
	{

	}

	public function field_data($TableName = '')
	{
		$ReturnValue = array();

		$ResultSet = Database::$Interface->ExecuteQuery("SELECT * FROM ".$TableName." LIMIT 0,1");

		while ($Field = mysql_fetch_field($ResultSet))
		{
			$F				= new stdClass();
			$F->name 		= $Field->name;
			$F->type 		= $Field->type;
			$F->default		= $Field->def;
			$F->max_length	= $Field->max_length;
			$F->primary_key = $Field->primary_key;

			$ReturnValue[] = $F;
		}

		return $ReturnValue;
	}

	public function insert_id()
	{
		return @mysql_insert_id();

	}

	public function escape_str($String)
	{
		return mysql_real_escape_string($String);
	}

	public function escape($String)
	{
		if (is_string($String))
		{
			$String = "'" . $this->escape_str($String) . "'";
		}
		elseif (is_bool($String))
		{
			$String = ($String === false) ? 0 : 1;
		}
		elseif (is_null($String))
		{
			$String = 'NULL';
		}

		return $String;
	}

	public function add_parameters($SQLQuery, $Parameters = array())
	{
		if (strpos($SQLQuery, '?') === false)
		{
			return $SQLQuery;
		}

		if (!is_array($Parameters))
		{
			$Parameters = array($Parameters);
		}

		$Segments = explode('?', $SQLQuery);

		if (count($Parameters) >= count($Segments))
		{
			$Parameters = array_slice($Parameters, 0, count($Segments) - 1);
		}

		$Result = $Segments[0];
		$Counter = 0;
		foreach ($Parameters as $Parameter)
		{
			$Result .= $this->escape($Parameter);
			$Result .= $Segments[++$Counter];
		}
		return $Result;
	}

	public function query_result($SQLQuery)
	{
		$ResultSet	= Database::$Interface->ExecuteQuery($SQLQuery);

		$Result = array();

		if (mysql_num_rows($ResultSet) > 0)
		{
			while ($EachRow = mysql_fetch_object($ResultSet))
			{
				$Result[] = $EachRow;
			}
		}
		else
		{
			return false;
		}

		return $Result;
	}
}