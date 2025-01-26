<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/");
}
    
include('../../config/db.php');

// Get the logged-in admin's email from session
$adminId = $_SESSION['user_id'];

// Fetch admin details from the database
$result = $conn->query("SELECT * FROM users WHERE id = '$adminId'");
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "Admin not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: monospace;
    line-height: 1.6; 
}

.box{
    padding: 2rem;
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Voice of Change</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../add_biography.php">Add Biography</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="my_account.php">Manage Account</a>
                    </li>
                    <li class="nav-item ms-5">
                        <a class="btn btn-sm btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-5 d-flex justify-content-center ">

<div class="col-12 col-md-6  p-3 card ">

<div class='d-flex row mb-3'>
    <div class='col-10'>
    <h1 class='text-center'>My Account</h1>
    </div>
    <div  class='col-2'>
        
<a href='logout.php'  class="btn btn-sm btn-danger ">LogOut</a>
    </div>

</div>


    <p><strong>Name:</strong> <?php echo $admin['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
    <br>
  
    <div class="d-flex justify-content-end gap-3 flex-wrap">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDetailsModal">
        Edit Details
    </button>

     <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</button>
    </div>
    

</div>
    
    <!-- Edit Details Modal -->
    <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDetailsModalLabel">Edit Admin Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateDetailsForm">
                        <div class="form-group mb-2">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $admin['name']; ?>" required>
                        </div>
                        
                        <div class="form-group mb-2">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $admin['email']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="current_password">Password:</label>
                            <input type="password" name="current_password" class="form-control" placeholder='enter password here...' required>
                        </div>
                        <button type="submit" name="update_admin" class="btn btn-success mb-3">Update Details</button>
                    </form>
                    <div id="updateResponse"></div>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Change Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="form-group mb-2">
                            <label for="current_password_modal">Current Password:</label>
                            <input type="password" name="current_password_modal" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password_modal">New Password:</label>
                            <div class="input-group">
                            <input type="password" name="new_password_modal" class="form-control" id="new_password_modal" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Show</button>
                            </div>
                            
                        </div>
                        <button type="submit" name="update_password" class="btn btn-success mb-3">Update Password</button>
                    </form>
                    <div id="passwordResponse"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Toggle password visibility
    function togglePassword() {
        var passwordField = document.getElementById('new_password_modal');
        var btn = event.target;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            btn.innerText = "Hide";
        } else {
            passwordField.type = "password";
            btn.innerText = "Show";
        }
    }


    // Handle update admin details form submission
document.getElementById('updateDetailsForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    formData.append('update_admin', true);  // Adding custom field to distinguish the form
    
    fetch('update_admin_details.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const updateResponse = document.getElementById('updateResponse');
        updateResponse.innerHTML = `<div class="alert p-2 alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Handle change password form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    formData.append('update_password', true);  // Adding custom field to distinguish the form
    
    fetch('update_admin_details.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const passwordResponse = document.getElementById('passwordResponse');
        passwordResponse.innerHTML = `<div class="alert p-2 alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


</script>

</body>
</html>

<?php
$conn->close();
?>
