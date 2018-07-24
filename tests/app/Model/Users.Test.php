<?php

declare(strict_types=1);
require '/var/www/artily/vendor/autoload.php';



use PHPUnit\Framework\TestCase;
// use PHPUnit\DbUnit\TestCaseTrait;

abstract class MyDatabaseTestCase extends TestCase
{
	// use TestCaseTrait;

	static private $pdo = null;

	private $conn = null;

	public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

  
}

class UsersTest extends TestCase
{

	public function getDataSet()
	{
		return $this->createXMLDataSet('Users.xml');
	}

	/**
	 // * @test
	*/
	// public function getUserById()
	// {
		// $this->getConnection();
		// $user = new App\Model\Users(self::$pdo);

		// $user->getUserById(1);
		// $this->assertEquals($user->getUserById(1), [
			// "id" => 1,
			// "username" => "admin",
			// "email" => "admin@artily.test"
		// ]);

	// }
}