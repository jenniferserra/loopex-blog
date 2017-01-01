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
                <a href="index.php">
                    <img src="images/layout/orange.png" class="orange_logo" alt="till bloggen">
                </a>

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
                <ul>
                    <!-- <li class="active menu-btn-lvl-1"><a href="index.php">Bloggen</a></li> -->
                    <li class="menu-btn-lvl-1"><a href="dashboard.php">Skriv inlägg</a></li>
                    
                    <li class="menu-btn-lvl-1">
                        <a href="comments.php">Blogginlägg</a>
                        <ul>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="comments.php">Kommentarer</a></li>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="archive.php">Arkiv</a></li>
                            <li class="menu-btn-lvl-2"><a class="nav-link" href="drafts.php">Utkast</a></li>
                            <li class="menu-btn-lvl-2"><a href="statistics.php">Statistik</a></li>
                        </ul>
                    </li>
                <?php
            $stmt->close();
            }
            // --------------------------------------------------------------------
            //         IF LOGGED IN OR NOT
            // --------------------------------------------------------------------

                if(basename($_SERVER['PHP_SELF'], '.php') == 'index') {
                ?>
                <ul>
                    <li class="menu-btn-lvl-1">
                        <a class="menu-button" href="index.php">Kategori</a>
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
                                        ORDER BY create_time DESC";
                            
                            $query_month = mysqli_query($conn, $sql_month);
                            while ($yearAndMonth = mysqli_fetch_array($query_month)) {
                                $yearAndMonth = substr($yearAndMonth["create_time"], 0, 7);
                                $yearAndMonthURL = '&yrmnth=' . $yearAndMonth;

                                // Printing out menu buttons with date and month
                                setlocale(LC_TIME, 'sv_SE');
                                $readableDate = strftime('%B %Y', strtotime($yearAndMonth));
                                echo '<li class="menu-btn-lvl-2"><a class="menu-button" href="?' . $yearAndMonthURL . $categoryURL . '">' . $readableDate . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
                <?php
                }

            // --------------------------------------------------------------------
            //         IF LOGGED IN
            // --------------------------------------------------------------------
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
                if($_SESSION['role'] == "admin") {
                ?>
                    <li class="menu-btn-lvl-1"><a href="superuser.php">Kontrollpanelen</a></li>
                <?php
                }
                ?>
                    
                    <li class="nav navbar-nav navbar-right menu-btn-lvl-1"><a href="logout.php">Logga ut</a></li>
                </ul>

            <?php
            }
            ?>

            </div> <!-- .collapse navbar-collapse --> 
        </div> <!-- .container-fluid -->
    </nav>
</header>
