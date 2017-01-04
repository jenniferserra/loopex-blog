<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-inverse">
            <a href="index.php">
                <img src="images/layout/orange.png" class="orange_logo" alt="till bloggen">
            </a>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- MENU ITEMS -->
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-left">
      
                    <?php
                    require_once "dbconnect.php";
                
                    if(!isset($_SESSION)){
                        session_start();
                    }
                
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
                        /* ----------------------------------------------------------------------------
                                IF LOGGED IN
                        ---------------------------------------------------------------------------- */
                        $userid = $_SESSION['user_id'];
                        $stmt->prepare("SELECT * FROM users WHERE user_id = '{$userid}'");
                        $stmt->execute();
                        $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password, $profilepic, $role);
                        $stmt->fetch();
                        ?>

                        <li><a href="dashboard.php">Skriv inlägg</a></li>
                        <li class="dropdown">
                            <a href="archive.php" class="dropdown-toggle" data-toggle="dropdown">Blogginlägg</a>
                            <ul class="dropdown-menu">
                                <li><a href="comments.php">Kommentarer</a></li>
                                <li><a href="archive.php">Redigera Arkiv</a></li>
                                <li><a href="drafts.php">Utkast</a></li>
                                <li><a href="statistics.php">Statistik</a></li>
                            </ul>
                        </li>
                    <?php
                    $stmt->close();

                        if($_SESSION['role'] == "admin") {
                            ?>
                                <li class="menu-btn-lvl-1"><a href="superuser.php">Kontrollpanelen</a></li>
                            <?php
                            }
                            ?>
                        <li class="nav navbar-nav navbar-right menu-btn-lvl-1"><a href="logout.php">Logga ut</a></li>
                    <?php
                    }

                    /* ----------------------------------------------------------------------------
                            IF LOGGED IN OR NOT
                    ---------------------------------------------------------------------------- */

                    if(basename($_SERVER['PHP_SELF'], '.php') == 'index') {
                    ?>

                        <li class="dropdown">
                            <a href="index.php" class="dropdown-toggle" data-toggle="dropdown">Kategori</a>
                            <ul class="dropdown-menu">
                                <?php
                                // Looping out category drop-down
                                $sqlCategory = "SELECT * FROM categories";
                                $queryCategory = mysqli_query($conn, $sqlCategory);

                                while ($getCategory = mysqli_fetch_array($queryCategory)) {
                                    $categoryName = $getCategory["cat_name"];
                                    $categoryId = $getCategory["cat_id"];
                                    echo '<li><a href="'. createUrl('category' . $categoryId) . '">' . $categoryName . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="index.php" class="dropdown-toggle" data-toggle="dropdown">Arkiv</a>
                            <ul class="dropdown-menu">
                                <?php
                                // Looping out Month-selection drop-down
                                $sql_month =    "SELECT create_time FROM posts
                                                GROUP BY substr(create_time, 1, 8)
                                                ORDER BY create_time DESC";
                                
                                $query_month = mysqli_query($conn, $sql_month);

                                while ($getYearAndMonth = mysqli_fetch_array($query_month)) {

                                    $yearAndMonth = substr($getYearAndMonth["create_time"], 0, 7);

                                    // Printing out menu buttons with date and month
                                    setlocale(LC_TIME, 'sv_SE');
                                    $readableDate = strftime('%B %Y', strtotime($yearAndMonth));
                                    echo '<li><a href="' . createUrl('yrmnth' . $yearAndMonth) . '">' . $readableDate . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div> <!-- .collapse navbar-collapse navHeaderCollapse -->
        </div> <!-- .container-inverse -->
    </nav> <!-- .navbar navbar-inverse navbar-fixed-top -->
</header>