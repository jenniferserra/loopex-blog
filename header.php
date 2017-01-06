<header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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

                        $sqlAllFromUsers = "SELECT * FROM users WHERE user_id = '{$userid}'";
                        $queryAllFromUsers = mysqli_query($conn, $sqlAllFromUsers);
                        while($getUser = mysqli_fetch_array($queryAllFromUsers, MYSQLI_ASSOC)) {
                            $userId = $getUser["user_id"];
                            $firstName = $getUser["firstname"];
                            $lastName = $getUser["lastname"];
                            $email = $getUser["email"];
                            $role = $getUser["role"];
                        }
                        ?>

                        <li><a href="dashboard.php" tabindex="1">Skriv inlägg</a></li>
                        <li class="dropdown">
                            <a href="archive.php" class="dropdown-toggle" data-toggle="dropdown" tabindex="2">Blogginlägg</a>
                            <ul class="dropdown-menu">
                                <li><a href="comments.php" tabindex="3">Kommentarer</a></li>
                                <li><a href="archive.php" tabindex="4">Redigera Arkiv</a></li>
                                <li><a href="drafts.php" tabindex="5">Utkast</a></li>
                                <li><a href="statistics.php" tabindex="6">Statistik</a></li>
                            </ul>
                        </li>
                    <?php

                        if($_SESSION['role'] == "admin") {
                            ?>
                                <li class="menu-btn-lvl-1"><a href="superuser.php" tabindex="7">Kontrollpanelen</a></li>
                            <?php
                            }
                            ?>
                        <li class="nav navbar-nav navbar-right menu-btn-lvl-1"><a href="logout.php" tabindex="6">Logga ut</a></li>
                    <?php
                    }

                    /* ----------------------------------------------------------------------------
                            IF LOGGED IN OR NOT
                    ---------------------------------------------------------------------------- */

                    if(basename($_SERVER['PHP_SELF'], '.php') == 'index') {
                    ?>

                        <li class="dropdown">
                            <a href="index.php" class="dropdown-toggle" data-toggle="dropdown" tabindex="4">Kategori</a>
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
                            <a href="index.php" class="dropdown-toggle" data-toggle="dropdown" tabindex="5">Arkiv</a>
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