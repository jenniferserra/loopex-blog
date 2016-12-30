<header>
  <!-- THE NAVBAR COLOR - DEFAULT IS FOR GREY / INVERSE- BLACK FIXED -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <?php
        require_once "dbconnect.php";
        if(!isset($_SESSION)){
            session_start();
        }
        // Variables to be inserted in link-URL in menu-buttons
        // Standard value is empty so that no extra characters appear in URL when nothing is selected
        global $selectedYearAndMonth;
        $selectedYearAndMonth = "";
        global $selectedYearAndMonthURL;
        $selectedYearAndMonthURL = "";

        if(isset($_GET["yrmnth"])) {
            $selectedYearAndMonth = $_GET["yrmnth"];
            $selectedYearAndMonthURL = '&yrmnth=' . $selectedYearAndMonth;
        }

        global $categoryURL;
        $categoryURL = "";

        if(isset($_GET["category"])) {
            $categoryURL = '&category=' . $_GET["category"];
        }

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
            // ------------------------------------------------------------------------
            // IF LOGGED IN
            // ------------------------------------------------------------------------
            $userid = $_SESSION['user_id'];
            // $stmt = $conn->stmt_init();
            $stmt->prepare("SELECT * FROM users WHERE user_id = '{$userid}'");
            $stmt->execute();
            $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
            $stmt->fetch();
        ?>
        <!-- LOGO HERE -->
        <div class="navbar-header">
          <!-- TO DO: Fuskstylat loggan här ta bort när det funkar i scss -->
          <img src="images/layout/orange.png" alt="Image on orange" style="float:left;margin:7px 0px 0px 7px;height:40px;width:40px;">

        <!-- THE TOGGLE BAR MENU TO MOBIL -->
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        <!-- <div class="navbar-brand"/></div> -->
            <a href="index.php" class="navbar-brand">ORANGE MUSIC.</a>
        </div>

        <!-- MENU ITEMS -->
        <div class="collapse navbar-collapse" id="mainNavbar">

        <div class="nav navbar-nav"></div>
        <!-- ACTIVE OCH LOGOUT TO RIGHT KROCKAR HÄR Logouts right align försvinner om jag slår på ul class ovan och active? -->
        <li class="active menu-btn-lvl-1"><a href="index.php">Bloggen</a></li>
        <li class="menu-btn-lvl-1"><a href="dashboard.php">Skriv ett inlägg</a></li>
        <li class="menu-btn-lvl-1"><a href="comments.php">Blogginlägg</a>
      <!-- IF logged in user is admin -->
      <?php
      if(isset($_SESSION['loggedin']) && $_SESSION['role'] == "admin") {?>

        <li class="menu-btn-lvl-1"><a href="superuser.php">Kontrollpanelen</a>

      <?php } ?>

            <ul>
                <li class="menu-btn-lvl-2"><a class="nav-link" href="comments.php">Kommentarer</a></li>
                <li class="menu-btn-lvl-2"><a class="nav-link" href="archive.php">Arkiv</a></li>
                <li class="menu-btn-lvl-2"><a class="nav-link" href="drafts.php">Utkast</a></li>
            </ul>
        </li>
        <li class="menu-btn-lvl-1"><a href="statistics.php">Statistik</a></li>
        <li class="nav navbar-nav navbar-right menu-btn-lvl-1"><a href="logout.php">Logga ut</a></li>
        <?php
        $stmt->close();
        // --------------------------------------------------------------------
        //         IF NOT LOGGED IN
        // --------------------------------------------------------------------
        } else {
        ?>
            <li class="menu-btn-lvl-1"><a class="menu-button" href="index.php">Kategori</a>
                <ul>
                    <?php
                    // Looping out category drop-down
                    $sql_category = "SELECT * FROM categories";
                    $query_category = mysqli_query($conn, $sql_category);
                    while ($category = mysqli_fetch_array($query_category)) {
                    $categoryName = $category["cat_name"];
                    $categoryId = $category["cat_id"];
                    echo '<li class="menu-btn-lvl-2"><a class="menu-button" href="?category='. $categoryId . $selectedYearAndMonthURL . '">' . $categoryName . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li class="menu-btn-lvl-1">
                <a class="menu-button" href="index.php">Arkiv</a>
                <ul>
                    <?php
                    // Looping out Month-selection drop-down
                    $sql_month = "SELECT create_time FROM posts
                                GROUP BY substr(create_time, 1, 8)
                                HAVING COUNT(*) > 1
                                ORDER BY create_time DESC";
                    $query_month = mysqli_query($conn, $sql_month);
                    while ($yearAndMonth = mysqli_fetch_array($query_month)) {
                        $yearAndMonth = substr($yearAndMonth["create_time"], 0, 7);
                        $yearAndMonthURL = '&yrmnth=' . $yearAndMonth;

                        // Printing out menu buttons with date and month
                        $readableDate = date("F Y", strtotime($yearAndMonth));
                        echo '<li class="menu-btn-lvl-2"><a class="menu-button" href="?' . $yearAndMonthURL . $categoryURL . '">' . $readableDate . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
          <div class="right-btn">
              <li class="menu-btn-lvl-1"><a class="menu-button" href="login.php">Logga in</a></li>
          </div>
        </div>
      </div>
        <?php
            }
        ?>
    </nav>
</header>
