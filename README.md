# PHPDataObjectsAPI

The purpose of this API is to interface client application from database server through data objects that delegate internally to Data Access (see PHPDataAccessAPI) and Database Abstraction (see PHPQueryingAPI) layers. Data objects must completely interface latter two layers, which means that all calls to those layers are to be performed internally within data objects.

Data objects acknowledged by SQL standards are: server, schemas, tables, views. For every data object, a class has been created. This class interfaces all logical operations on respective data object via public methods. These methods delegate internally to PHPQueryingAPI and PHPDataAccessAPI for:

- statement generation (delegated to PHPQueryingAPI)
- statement execution & results retrieval (delegated to PHPDataAccessAPI)

The major problem with this approach is that not all operations are abstractable. CRUD operations (select, insert, update, delete, replace) allow for more than one statement generated (via clauses), more than one execution method (statement, prepared statement) or more than one kind of results retrieved (null, scalars, arrays, affected rows, last insert id). To make design solid, the goal of this library has been divided into:

1. non-CRUD layer, a skeleton library implementing all abstractable operations. Each of these operations (for example drop @ table) can only have one implementation and outcome. DataObjectsAPI’s job is to implement the skeleton!
2. CRUD layer, an user extension of skeleton library allowing multiple implementations for same operation, fitting seemlessly with his application demands and DAO prerequisites: one statement generated, one execution method, one type of results retrieved.

To better why point #2 is needed, let's think about a scenario:

Say we have an user table with these two columns: 

- id (PK)
- email (UNIQUE)
- name 

and our application requires following operations:

- user info by id: 
	query: SELECT * FROM users WHERE id = ?
	execution method: prepared statement
	results: one row of data
- listing of all users:
	query: SELECT * FROM users
	execution method: statement
	results: multiple rows of data
	
How do we do that while hiding database complexity from outside world (remaining true to our purpose)? 


This API, as stated above, is dependent on PHPDataAccessAPI & PHPQueryingAPI and as such completes SQL Suites, an integrated solution designed to cover all aspects of communication with SQL servers. To see the full documentation, please visit to SQL suites docs :

https://docs.google.com/document/d/1U5PtPyub4t273gB9gXoZTX7TQasjP6lj93kMcClovS4/edit# 