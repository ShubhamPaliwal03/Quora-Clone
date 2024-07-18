<?php
    if(isset($_COOKIE['username']) && isset($_COOKIE['uid']))
    {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="search_results_style.css">
                <title>Quora - Search</title>
            </head>
            <body>
                <div id="app-container">
                    <div class="flex-navbar">
                        <div id="quora_logo_text">Quora</div>
                        <div id="btn_flex_container">
                            <div>
                                <a href="#" title="Home">
                                    <button id="home_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                        <i class="fa-solid fa-house"></i>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <a href="#" title="Following">
                                <button id="list_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-list"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="#" title="Answer">
                                <button id="write_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="#" title="Spaces">
                                <button id="people_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-user-group"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="#" title="Notifications">
                                <button id="notifications_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-bell"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="#" title="Menu">
                                <button id="menu_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="#" title="Languages">
                                <button id="net_btn" class="nav_btns" onclick="changeFontColor(this.id)">
                                    <i class="fa-solid fa-globe"></i>
                                </button>
                            </a>
                        </div>
                        <div><input id="user-post-search-box" type="search" placeholder="Search Quora" class="searchbar"></div>
                        <div><button id="try_quora_btn">Try Quora+</button></div>
                        <div>
                            <a href="./dashboard.php" title="User">
                                <img id="user-profile-photo" src="images/unlogged_profile_image.webp" alt="user_profile_photo">
                            </a>
                        </div>
                        <div class="flex-add_ques">
                            <div><button id="add_ques_btn">Add Question</button></div>
                            <div><button id="dropdown">^</button></div>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div id="intrests_section">
                            <div class="intrests">
                                
                            </div>
                        </div>
                        <div class="posts">
                            <div>Results for <b><?php echo($_POST['search_query']);?></b></div>
                            <hr>
                            <?php

                                include('../connect.php');

                                $sql_users_table = "select uid, username, user_image, user_title from `users` where username like '$_POST[search_query]%'";
                                $records_users_table = mysqli_query($conn, $sql_users_table);
                            
                                while($data = mysqli_fetch_assoc($records_users_table))
                                {
                                    $uid = $data['uid'];
                                    $username = $data['username'];

                                    if($data['user_image'] === "none")
                                    {
                                        $user_image = "default_user_image.webp";
                                    }
                                    else
                                    {
                                        $user_image = $data['user_image'];
                                    }
                                    ?>
                                        <div class="matching-user-info-container">
                                            <div class="image-container">
                                                <img class="user_image" src="./user_images/<?php echo($user_image);?>" alt="matching-user-<?php echo($username);?>image">
                                            </div>
                                            <div class="username-container">
                                                <b><?php echo($username);?></b>
                                                <?php
                                                    if($data['user_title'] !== "none")
                                                    {
                                                        echo(", $data[user_title]");
                                                    }
                                                ?>
                                            </div>
                                            <div class="follow-btn-container">
                                            <?php
                                                $user_id = $data['uid'];
                                                $sql_follow_records_table = "select count(*) as count from `follow_records` where following_user_id = $user_id && user_id = $_COOKIE[uid]";
                                                $records = mysqli_query($conn, $sql_follow_records_table);
                                                $data = mysqli_fetch_assoc($records);
                                                $follow_btn_value;

                                                if($data['count'] === "1")
                                                {
                                                    $follow_btn_value = "Unfollow";
                                                }
                                                else
                                                {
                                                    $follow_btn_value = "Follow";
                                                }
                                            ?>
                                            <input type="button" value="<?php echo($follow_btn_value);?>" class="follow-btn <?php echo($follow_btn_value);?>" id="follow_btn_user<?php echo($uid);?>">
                                            </div>
                                        </div>
                                        <hr>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="ads">
                            
                        </div>
                    </div>
                </div>     
                <script src="https://kit.fontawesome.com/4ca0345904.js" crossorigin="anonymous"></script>
                <script src="../jquery.js"></script>
                <script src="./search_results_script.js"></script>
            </body>
            </html>
        <?php
    }
    else
    {
        header('location:../login.php');
    }
?>