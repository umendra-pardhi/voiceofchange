<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/"); 
    exit();
}

include("../config/db.php");

// Add biography
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_bio'])) {
    $personality_name = $_POST['personality_name'];
    $birth = $_POST['birth'];
    $death = $_POST['death'];
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Base64 encoded image

    // Insert biography into the database
    $sql = "INSERT INTO biographies (personality_name, birth, death, short_desc, description, image) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $personality_name, $birth, $death, $short_desc, $description, $image);

    if ($stmt->execute()) {
        echo "<script>alert('Biography added successfully!');window.location.href = 'index.php';</script>";
   
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}



$sql = "SELECT * FROM biographies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Biography - Voice of Change</title>
     <!-- Include Summernote CSS and JS -->
     <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" integrity="sha512-rDHV59PgRefDUbMm2lSjvf0ZhXZy3wgROFyao0JxZPGho3oOuWejq/ELx0FOZJpgaE5QovVtRN65Y3rrb7JhdQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js" integrity="sha512-qTQLA91yGDLA06GBOdbT7nsrQY8tN6pJqjT16iTuk08RWbfYmUz/pQD3Gly1syoINyCFNsJh7A91LtrLIwODnw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .note-fullscreen-body .modal-backdrop {
            z-index:100;
        }
    </style>
</head>
<body>

<?php
include("navbar.php");
?>


<div class="container mt-4 mb-4">
    <h1 class="text-center">Add Biography</h1>

   
    <form action="" method="POST" id="addBioForm" class="form-group">
        <div class="mb-3">
            <label for="personality_name" class="form-label">Personality Name</label>
            <input type="text" name="personality_name" id="personality_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="birth" class="form-label">Birth Year</label>
            <input type="number" name="birth" id="birth" min="1000" max="2100" placeholder="YYYY" class="form-control">
        </div>
        <div class="mb-3">
            <label for="death" class="form-label">Death Year</label>
            <input type="number" name="death" id="death" min="1000" max="2100" placeholder="YYYY" class="form-control">
        </div>
        <div class="mb-3">
            <label for="short_desc" class="form-label">Short Description</label>
            <input type="text" name="short_desc" id="short_desc" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="summernote form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (Upload)</label>
            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <input type="hidden" name="image" id="image" required> <!-- Hidden input to store Base64 string -->
        </div>
        <button type="submit" name="add_bio" class="btn btn-primary">Add Biography</button>
    </form>

</div>

<script>
    $(document).ready(function() {
        // Initialize Summernote editor for description field
        $('.summernote').summernote({
            height: 200,   // Set editor height
            placeholder: 'Write biography description here...'
        });

        // Convert image file to Base64
        $('#imageInput').change(function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                $('#image').val(reader.result); // Set Base64 string to hidden input
            }

            if (file) {
                reader.readAsDataURL(file); // Read the file as a data URL (Base64)
            }
        });
    });
</script>

</body>
</html>
