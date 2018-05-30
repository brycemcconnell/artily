<?php


class UserDB
{
    private $conn;

    public function __construct(PDO $pdo)
    {
        $this->conn = $pdo;
    }

    /**
     * @param array $user
     * @return string
     */
    public function addUser(array $user): string
    {
        $oldUser = $this->getUserbyUsername($user['username']);
        if ($oldUser)
            return "Duplicate entry, {$user['username']} already in database";

        $sql = <<< SQL
        
        INSERT INTO users 
           ( users.userName,  users.email,  users.password) 
        VALUES 
           (:uname,  :email, :password);
SQL;
        $stmnt = $this->conn->prepare($sql);
        $stmnt->bindValue(':uname', $user['username'], PDO::PARAM_STR);
        $stmnt->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $stmnt->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $success = $stmnt->execute();

        if ($success) {
            return "Record addition success";
        } else {
            return "Record addition failure. Unknown error";
        }
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function getUserbyUsername(string $username)
    {
        $sql = <<< SQL
        SELECT
          users.id,
          users.userName as username,
          users.email
        FROM
          users
        WHERE
          users.userName = :username
SQL;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        return $user;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getUser(int $id)
    {
        $sql = <<< SQL
        SELECT
          users.id,
          users.userName as username,
          users.email
        FROM
          users
        WHERE
          users.id = :id
SQL;
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $user = $stmt->fetch();

        return $user;
    }

    /**
     * @param string $username
     * @param string $currentPassword
     * @param string $newPassword
     * @return mixed
     */
    public function changePassword(string $username, string $currentPassword, string $newPassword)
    {

        $user = $this->authenticateUser($username, $currentPassword);
        if (!$user) {
            return "Authentication failure";
        }

        $sql = <<< SQL
        UPDATE users 
                SET password=:password
        WHERE 
               (users.id = :id )  
SQL;

        $stmnt = $this->conn->prepare($sql);
        $stmnt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmnt->bindValue(':id', $user['id'], PDO::PARAM_INT);

        return $stmnt->execute();
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool|mixed
     */
    public function authenticateUser(string $username, string $password)
    {
        $sql = <<< SQL
        SELECT
          users.id,
          users.userName as username,
          users.email,
          users.password
        FROM
          users
        WHERE
          users.userName = :username
SQL;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); //no need to pass password
            return $user; //valid
        }
        return false; //no match
    }
}