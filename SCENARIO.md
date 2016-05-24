Let's say we have an "users" table with these two columns: 

- id (PK)
- email (UNIQUE)
- name 

Our application requires following operations:

1. user name by id: 
	query: SELECT name FROM users WHERE id = ?
	execution method: prepared statement
	results: one string
2. listing of all users:
	query: SELECT * FROM users
	execution method: statement
	results: multiple rows of data
	
How do we do that through a single "select" method? Remember we must be hiding database complexity from outside world (remaining true to our purpose), which means:

- putting queries (or abstractions of) as arguments is a non-option
- forcing all select statements to be prepared would be illogical (statement #2 needs no "prepare") and hurt performance.
- returning DatabaseStatementResults object exposes Data Access layer (which should be completely hidden by DAO objects).

Conclusion: users must write their own implementations of CRUD operations, as long as they don't break the good design. 

Correct solution:

class UsersTable extends GenericMySQLTable {

	...
	
	public function getName($id) {
		// querying api
		$table = new SQLTableSelect("users");
		$table->setColumns()->addColumn("name");
		$table->setWhere()->set("id",":id");
		
		// data access api
		$preparedStatement = $this->databaseConnection->createPreparedStatement();
		$preparedStatement->prepare($table->toString());
		$preparedStatement->bind(":id", $id);
		return $preparedStatement->execute()->toValue();
	}
	
	public function getAll() {
		// querying api
		$table = new SQLTableSelect("users");
		
		// data access api
		$statement = $this->databaseConnection->createStatement();
		return $statement->execute($table->toString())->toList();
	}
}