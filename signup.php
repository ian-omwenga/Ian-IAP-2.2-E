<?php
session_start();

class User {
    private $conn;
    private $table_name = "users";

    public $fullname;
    public $email;
    public $username;
    public $password;
    public $genderId;
    public $roleId;

    public function create($conn) {
        $query = "INSERT INTO " . $this->table_name . " (fullname, email, username, password, genderId, roleId)
                  VALUES (:fullname, :email, :username, :password, :genderId, :roleId)";
        $stmt = $conn->prepare($query);

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":genderId", $this->genderId);
        $stmt->bindParam(":roleId", $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'load.php';
    $conn = $Objdbconnect->getConnection();

    if (isset($_POST['fullname'])) { 
        // Sign-Up Form Submission
        $user = new User();
        $user->fullname = $_POST['fullname'];
        $user->email = $_POST['email'];
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->genderId = $_POST['genderId'];
        $user->roleId = $_POST['roleId'];

        if ($user->create($conn)) {
            // Generate and email verification code
            $verificationCode = rand(10000, 99999); // random code
            $_SESSION['verification_code'] = $verificationCode; 
            $_SESSION['email'] = $user->email; 
            
            // Send verification code via email
            mail($user->email, "Your Verification Code", "Your code is: $verificationCode");

            echo "Registration Successful. Please check your email for the verification code.";
        } else {
            echo "Unable to register user.";
        }
    } elseif (isset($_POST['ver_code'])) {
        // Verification Code Submission
        $inputCode = $_POST['ver_code'];
        if (isset($_SESSION['verification_code']) && $inputCode == $_SESSION['verification_code']) {
            echo "Verification Successful!";
            unset($_SESSION['verification_code']); 
            echo "Invalid Verification Code. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">User Sign Up</h2>
        <form action="signup.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="row">
                <div class="col">
                    <label for="gender" class="form-label">Gender</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genderId" id="male" value="7" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genderId" id="female" value="8" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <div class="col">
                    <label for="role" class="form-label">Role</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="roleId" id="admin" value="5" required>
                        <label class="form-check-label" for="admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="roleId" id="user" value="6" required>
                        <label class="form-check-label" for="user">User</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Sign Up</button>
        </form>

        <div class="mt-4">
            <h2 class="text-center">Verify Code</h2>
            <form action="signup.php" method="POST">
                <div class="mb-3">
                    <label for="ver_code" class="form-label">Verification Code:</label>
                    <input type="number" name="ver_code" class="form-control" id="ver_code" required>
                </div>
                <button type="submit" class="btn btn-success">Verify Code</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
