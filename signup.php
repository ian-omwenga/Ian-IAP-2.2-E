<?php

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

        $stmt->execute();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'load.php';
    $user= new User();
    $conn=$Objdbconnect->getConnection();
    $user->fullname = $_POST['fullname'];
    $user->email = $_POST['email'];
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->genderId = $_POST['genderId'];
    $user->roleId = $_POST['roleId'];

    if ($user->create($conn)) {
        echo "Unable to register the user.";
    } else {
        echo "Registration Successful";
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
        <h2 class="text-center mt-4">Sign Up</h2>
        <form action="signup.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname">
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
                            <input class="form-check-input" type="checkbox" name="genderId" id="chbx1" value="7" onclick="toggleCheckboxes()" required>
                            <label class="form-check-label" for="gender">Male</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="genderId" id="chbx2" value="8" onclick="toggleCheckboxes()" required>
                            <label class="form-check-label" for="gender">Female</label>
                        </div>
                        <div class="invalid-feedback">
                            Choose one.
                        </div>
                    </div>
                    
                    <div class="col">
                        <label for="role" class="form-label">Role</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="roleId" id="chbx3" value="5" onclick="toggleCheckboxes()" required>
                            <label class="form-check-label" for="role">Admin</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="roleId" id="chbx4" value="6" onclick="toggleCheckboxes()" required>
                            <label class="form-check-label" for="role">User</label>
                        </div>
                        <div class="invalid-feedback">
                            Choose one.
                        </div>
                    </div>
                    </div>
            
            
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
 
    <script>
            function toggleCheckboxes() {
                const chbx1 = document.getElementById('chbx1');
                const chbx2 = document.getElementById('chbx2');
                const chbx3 = document.getElementById('chbx3');
                const chbx4 = document.getElementById('chbx4');
                if (chbx1.checked) {
                    chbx2.disabled = true;
                } else if (chbx2.checked) {
                    chbx1.disabled = true;
                }
                else {
                    chbx1.disabled = false;
                    chbx2.disabled = false;
                    
                }

                if (chbx3.checked) {
                    chbx4.disabled = true;
                } else if (chbx4.checked) {
                    chbx3.disabled = true;
                }
                else {
                    chbx3.disabled = false;
                    chbx4.disabled = false;
                    
                }
            }
        </script>
        <script>
            (() => {
                'use strict'

                const forms = document.querySelectorAll('.needs-validation')

                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

