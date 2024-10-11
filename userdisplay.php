<?php
class userdisplay {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT users.fullname, users.email, gender.gender, roles.role 
                  FROM users 
                  JOIN gender ON users.genderId = gender.genderId 
                  JOIN roles ON users.roleId = roles.roleId";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all users as an associative array
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Registered Users</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'load.php'; 
                $db = $Objdbconnect->getConnection();
                $userDisplay = new userdisplay($db);
                $users = $userDisplay->readAll();

                foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['gender']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

