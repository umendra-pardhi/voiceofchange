<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login/"); 
    exit();
}

include("../config/db.php");

// Edit biography
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM biographies WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bio = $result->fetch_assoc();
    $stmt->close();
}

// Update biography
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_bio'])) {
    $id = $_POST['id'];
    $personality_name = $_POST['personality_name'];
    $birth = $_POST['birth'];
    $death = $_POST['death'];
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Base64 encoded image

    // If image was not changed, use the existing one
    if (empty($image)) {
        $image = $_POST['existing_image']; // Retain existing image
    }

    $sql = "UPDATE biographies SET personality_name = ?, birth = ?, death = ?, short_desc = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $personality_name, $birth, $death, $short_desc, $description, $image, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Biography updated successfully!');window.location.href = 'index.php';</script>";
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
    <title>Manage Biographies - Voice of Change</title>
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
    
    <?php if (isset($bio)): ?>
        <h1 class="text-center">Edit Biography</h1>
        <form action="" method="POST" id="editBioForm" class="form-group ">
            <input type="hidden" name="id" value="<?php echo $bio['id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $bio['image']; ?>"> <!-- Store existing image in hidden input -->
            <div class="mb-3">
                <label for="personality_name" class="form-label">Personality Name</label>
                <input type="text" name="personality_name" id="personality_name" class="form-control" value="<?php echo $bio['personality_name']; ?>" required>
            </div>

            <div class="mb-3">
            <label for="birth" class="form-label">Birth Year</label>
            <input type="number" name="birth" id="birth" min="1000" max="2100" placeholder="YYYY" class="form-control" value="<?php echo $bio['birth']; ?>">
        </div>
        <div class="mb-3">
            <label for="death" class="form-label">Death Year</label>
            <input type="number" name="death" id="death" min="1000" max="2100" placeholder="YYYY" class="form-control"  value="<?php echo $bio['death']; ?>">
        </div>

            <div class="mb-3">
                <label for="short_desc" class="form-label">Short Description</label>
                <input type="text" name="short_desc" id="short_desc" class="form-control" value="<?php echo $bio['short_desc']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="summernote form-control" required><?php echo $bio['description']; ?></textarea>
            </div>
            <?php if ($bio['image']): ?>
                <div class="mb-3">
                    <img src="<?php echo $bio['image']; ?>" alt="Current Image" class="img-fluid" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="imageInput" class="form-label">New Image</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
            <input type="hidden" name="image" id="image" required> <!-- Hidden input to store Base64 string -->
        </div>
            <button type="submit" name="edit_bio" class="btn btn-success">Update Biography</button>
        </form>
        <?php endif; ?>
   
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
