<?php namespace App\Validation;

use Config\Database;

class LoginRules {

	//DB Property.
	private $db;

	public function __construct()
	{
		$this->db = Database::connect();
	}

	/*
	*   Check if Username is exists or not from the database.
	*   Syntax: username_exist[dbtable.username_field]
	*/
	public function username_exist($str, string $fields, array $data): bool
	{
		//Username Value.
		$username = $str;

		//The fields. [<fb_db_table_name>, <field_username>].
		$fields = explode('.', $fields);

		//DB Table Name.
		$dbtable = $fields[0];

		//Field Username.
		$field_username = $fields[1];

		/*
		*   Validate Username if exist or not from the database.
		*/
		$builder = $this->db->table($dbtable);
		$builder->select('*');
		$builder->where($field_username, $username);
		$query = $builder->get();

		$count = 0;

		foreach ($query->getResult() as $f)
		{
			$count++;
		}

		if ($count > 0)
		{
			return true;
		}

		return false;
	}

	/*
	*   Validating Password and DB Password if matches or not.
	*   Syntax: username_exist[dbtable.username_field.]
	*/
	public function match_dbpass(string $str = null, string $fields, array $data): bool
	{
		//Username Value.
		$password = $str;

		//The fields. [<fb_db_table_name>, <field_username>].
		$fields = explode('.', $fields);

		//DB Table Name.
		$dbtable = $fields[0];

		//Field Username.
		$field_username = $fields[1];

		//DB Password.
		$dbpassword = '';

		/*
		*   Get Password from db table.
		*/
		$builder = $this->db->table($dbtable);
		$builder->select('password');
		$builder->where($field_username, $data[$field_username]);
		$query = $builder->get();

		foreach ($query->getResult() as $f)
		{
			$dbpassword = $f->password;
		}

		/*
		*   Validate Password.
		*/
		if (password_verify($password, $dbpassword))
		{
			return true;
		}

		return false;
	}
}
