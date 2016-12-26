<header>
    <nav class="navbar navbar-default">
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
            <li class="menu-btn-lvl-1"><a href="index.php">Bloggen</a></li>
            <li class="menu-btn-lvl-1"><a href="dashboard.php">Profil</a></li>
            <li class="menu-btn-lvl-1"><a href="comments.php">Blogginlägg</a>
                <ul>
                    <li class="menu-btn-lvl-2"><a class="nav-link" href="comments.php">Kommentarer</a></li>
                    <li class="menu-btn-lvl-2"><a class="nav-link" href="archive.php">Inläggsarkiv</a></li>
                    <li class="menu-btn-lvl-2"><a class="nav-link" href="drafts.php">Utkast</a></li>
                </ul>
            </li>
            <li class="menu-btn-lvl-1"><a href="statistics.php">Statistik</a></li>
            <li class="menu-btn-lvl-1"><a href="logout.php">Logga ut</a></li>
        </div>  <!-- .page-content -->
        <?php
        $stmt->close();
        // --------------------------------------------------------------------
        //         IF NOT LOGGED IN
        // --------------------------------------------------------------------
        } else {
        ?>
            <li class="menu-btn-lvl-1"><a href="index.php">Kategori</a>
                <ul>
                    <?php
                    // Looping out category drop-down
                    $sql_category = "SELECT * FROM categories";
                    $query_category = mysqli_query($conn, $sql_category);
                    while ($category = mysqli_fetch_array($query_category)) {
                    $categoryName = $category["cat_name"];
                    $categoryId = $category["cat_id"];
                    echo '<li class="menu-btn-lvl-2"><a class="nav-link" href="?category='. $categoryId . $selectedYearAndMonthURL . '">' . $categoryName . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li class="menu-btn-lvl-1"><a href="index.php">Arkiv</a>
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
                        global $readableDate;
                        $readableDate = date("F Y", strtotime($yearAndMonth));
                        echo '<li class="menu-btn-lvl-2"><a href="?' . $yearAndMonthURL . $categoryURL . '">' . $readableDate . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <div class="navbar-header navbar-right">
                <li class="menu-btn-lvl-1">
                    <a class="navbar-brand" href="login.php">Logga in</a>
                </li>
            </div>
            <?php
                }
            ?>
        </ul>
    </nav>
</header>