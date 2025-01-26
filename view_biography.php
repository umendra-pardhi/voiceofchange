<?php
include("config/db.php");

$personality_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM biographies WHERE id = $personality_id";
$result = $conn->query($sql);
$personality = $result->fetch_assoc();

if (!$personality) {
   
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voice of Change</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kumar+One&display=swap"
      rel="stylesheet"
    />
<link rel="stylesheet" href="css/viewbio.css">
</head>
<body>
<header>
      <h1>VOiCE of CHANGE</h1>
    </header>
    <nav>
        <a href="index.php#intro"> Home </a>
        <a href="index.php#about"> About </a>
        <a href="index.php#personalities"> Personalities </a>
        <a href="index.php#timeline"> Timeline </a>
        <a href="index.php#quotes"> Quotes </a>
    </nav>


    <div class="container">
    

    <div class="title">
        <div >
               <a href="index.php" class="back-link">
    <i class="fas fa-long-arrow-alt-left"></i>
            </a>
        </div>
     <div  >
     <h2><?php echo $personality['personality_name']; ?></h2>
     </div>
    

    </div>
    

    <div style='text-align:center;'>
    <img class="personality-image" src="<?php echo $personality['image']; ?>" alt="Portrait of <?php echo $personality['personality_name']; ?>" />
    </div>
       
        <p><?php echo $personality['description']; ?></p>

    </div>

    <footer>
      <p>&copy; 2025 Voice of Change. All rights reserved.</p>
    </footer>
</body>
</html>