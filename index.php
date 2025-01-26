<?php

include("config/db.php");

$sql = "SELECT * FROM biographies";
$result = $conn->query($sql);


?>

<html>
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

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <h1>VOiCE of CHANGE</h1>
    </header>
    <nav>
      <a href="#intro"> Home </a>
      <a href="#about"> About </a>
      <a href="#personalities"> Personalities </a>
      <a href="#timeline"> Timeline </a>
      <a href="#quotes"> Quotes </a>
    </nav>
    <section class="intro" id="intro">
      <h2>Welcome to Voice of Change</h2>
      <p>Discover the inspiring stories of India's greatest personalities.</p>
      <a href="#about"> Learn More </a>
    </section>
    <section class="about" id="about">
      <h2>About Voice of Change</h2>
      <p>
        Voice of Change is dedicated to sharing the biographies of India's most
        influential figures. Learn about their lives, achievements, and the
        impact they had on society.
      </p>
    </section>
    <section class="personalities" id="personalities">
      <h2>Legendary Personalities</h2>
      <div class="card-container">
        <?php

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        ?>
            <div class="card">
            <img
                alt="Portrait of <?php echo $row["personality_name"] ?>"
                src="<?php echo $row["image"] ?>"
            />
            <div class="desc">
                <h3><?php echo $row["personality_name"] ?></h3>
                <p><?php echo  $row["short_desc"] ?></p>
                <a href="view_biography.php?id=<?php echo  $row["id"] ?>&p=<?php echo $row["personality_name"] ?>"> Read More </a>
            </div>
            </div>

            <?php
} }else {
    echo "No records found.";
}

            ?>
       
      </div>
    </section>
    <section  id="timeline">
     
    <div class="timeline-container">
    <h1 class="timeline-title">Historical Timeline</h1>
    <p class="timeline-subtitle">Journey through centuries of wisdom and change</p>

    <div class="timeline">

    <?php

$sql = "SELECT * FROM biographies ORDER BY birth ASC";
$result = $conn->query($sql);


    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            ?>
            <div class="timeline-event">
                <div class="event-content">
                    <h2><?php echo $row["birth"]; ?></h2>
                    <h3>Birth of <?php echo $row["personality_name"]; ?></h3>
                    <p><?php echo $row["short_desc"]; ?></p>
                </div>
                <div class="timeline-circle"></div>
            </div>
            <?php
        }

    } else {
        echo "No records found.";
    }

    $conn->close();
    ?>

    </div>
</div>

    </section>
    <section class="quotes" id="quotes">
      <div class="container">
        <div class="text-center mb-16 fade-in">
          <h2 class="title">Timeless Wisdom</h2>
          <p class="subtitle">Inspirational quotes that continue to guide us</p>
          <div class="divider"></div>
        </div>

        <div class="quotes-slider">
          <!-- Quote slides container -->
          <div class="quotes-track">
            <!-- Dr. Ambedkar Quote -->
            <div class="quote-slide">
              <div class="quote-box">
                <div class="quote-content">
                  <div class="quote-mark">"</div>
                  <p class="quote-text">
                    I measure the progress of a community by the degree of
                    progress which women have achieved.
                  </p>
                  <div class="author">Dr. B.R. Ambedkar</div>
                  <p class="author-title">
                    Social Reformer & Constitution Architect
                  </p>
                </div>
              </div>
            </div>

            <!-- Shivaji Maharaj Quote -->
            <div class="quote-slide">
              <div class="quote-box">
                <div class="quote-content">
                  <div class="quote-mark">"</div>
                  <p class="quote-text">
                    Freedom is a boon, which everyone has the right to receive.
                  </p>
                  <div class="author">Chhatrapati Shivaji Maharaj</div>
                  <p class="author-title">Founder of Maratha Empire</p>
                </div>
              </div>
            </div>

            <!-- Birsa Munda Quote -->
            <div class="quote-slide">
              <div class="quote-box">
                <div class="quote-content">
                  <div class="quote-mark">"</div>
                  <p class="quote-text">
                    Our land is our heritage, and we shall protect it with our
                    lives.
                  </p>
                  <div class="author">Birsa Munda</div>
                  <p class="author-title">Tribal Freedom Fighter</p>
                </div>
              </div>
            </div>

            <!-- Sant Kabir Quote -->
            <div class="quote-slide">
              <div class="quote-box">
                <div class="quote-content">
                  <div class="quote-mark">"</div>
                  <p class="quote-text">
                    Keep your words pure as you keep your mind pure.
                  </p>
                  <div class="author">Sant Kabir</div>
                  <p class="author-title">Mystic Poet & Social Reformer</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <button class="prev-btn" onclick="moveSlide(-1)">
          <svg
            class="arrow-icon"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 19l-7-7 7-7"
            />
          </svg>
        </button>
        <button class="next-btn" onclick="moveSlide(1)">
          <svg
            class="arrow-icon"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </button>

        <!-- Dots Navigation -->
        <div class="dots-nav">
          <button class="dot" onclick="goToSlide(0)"></button>
          <button class="dot" onclick="goToSlide(1)"></button>
          <button class="dot" onclick="goToSlide(2)"></button>
          <button class="dot" onclick="goToSlide(3)"></button>
        </div>
      </div>
    </section>
    <footer>
      <p>&copy; 2025 Voice of Change. All rights reserved.</p>
    </footer>

    <script src="js/script.js"></script>
  </body>
</html>
