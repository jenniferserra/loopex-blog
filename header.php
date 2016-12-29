<header>
  <!-- DEFAULT= is the gray colour and INVERSE= is black -->
    <nav class="navbar navbar-inverse">
  <!--       <div class="imgAnimation"></div>
    <img class="logga" src="../../images/layout/logga.png"/>
      <img src="../../images/layout/logga.png" alt="Helmet" width="45" height="45" style="float:left"> -->
        <ul>
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
            <!-- LOGO WITH ORANGE IMAGE -->
            <div class="navbar-header">

            <!-- THE TOGGLE BAR = HAMBURGER BAR -->
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

              </button>

              <a href="#" class="navbar-brand">ORANGE MUSIC.</a>
            </div>

            <!-- MENU ITEMS -->
            <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- <ul class="nav navbar-nav"> -->
            <!-- ACTIVE OCH LOGOUT TO RIGHT KROCKAR HÄR Logouts right align försvinner om jag slår på ul class ovan och active? -->
            <li class="active menu-btn-lvl-1"><a href="index.php">Bloggen</a></li>
            <li class="menu-btn-lvl-1"><a href="dashboard.php">Profil</a></li>
            <li class="menu-btn-lvl-1"><a href="comments.php">Blogginlägg</a>
                <ul>

                    <li class="menu-btn-lvl-2"><a class="nav-link" href="comments.php">Kommentarer</a></li>
                    <li class="menu-btn-lvl-2"><a class="nav-link" href="archive.php">Inläggsarkiv</a></li>
                    <li class="menu-btn-lvl-2"><a class="nav-link" href="drafts.php">Utkast</a></li>
                </ul>
            </li>
            <li class="menu-btn-lvl-1"><a href="statistics.php">Statistik</a></li>
            <!-- RIGHT ALIGN LOGOUT -->
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
            <?php
                }
            ?>
        </ul>
    </nav>
</header>