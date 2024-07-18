<?php
    if(isset($_COOKIE['username']) && isset($_COOKIE['uid']))
    {
        include('../connect.php');

        $username = $_COOKIE['username'];
        $uid = $_COOKIE['uid'];

        if(isset($_POST['create_post']))
        {
            ?><script>
                const post_success_sound = new Audio('../sounds/post_success.mp3');
                post_success_sound.volume = 1.0;
                post_success_sound.play();
            </script><?php

            $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
            $username = $_COOKIE['username'];
            $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);

            if(isset($_POST['post_image']))
            {
                $post_image = $_POST['post_image'];
            }
            else
            {
                $post_image = "none";
            }

            $sql = "insert into `posts` (uid, post_title, post_content, date_and_time, post_image) values ('$uid', '$post_title', '$post_content', NOW(), '$post_image')";

            mysqli_query($conn, $sql);
        }
        else if(isset($_POST['delete_post']))
        {
            $pid = $_POST['pid'];

            $sql = "delete from `posts` where pid = $pid";

            mysqli_query($conn, $sql);
        }
        else if(isset($_POST['update_post']))
        {
            $post_title_input = $_POST['post_title'];
            $post_content_input = $_POST['post_content'];
            $pid = $_POST['pid'];

            $sql = "update `posts` set post_title = '$post_title_input', post_content = '$post_content_input', date_and_time = NOW() where pid = $pid";

            mysqli_query($conn, $sql);
        }

        $sql_users = "select user_title, user_image from `users` where uid = $uid";
        
        $user_record = mysqli_query($conn, $sql_users);

        $data = mysqli_fetch_assoc($user_record);

        $user_title = $data['user_title'];
        $user_image = "./user_images/$data[user_image]";

        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <!-- <link rel="stylesheet" href="style.css"> -->
                 <link rel="stylesheet" href="./responsive_style.css">
                <link rel="icon" type="image/x-icon" href="./images/quora_favicon.png">
                <title>Quora</title>
            </head>
            <body>
                <!-- <script type="module" src="../jquery.js"></script> -->
                <div class="post-pop-up-outer-container">
                    <div class="post-pop-up-inner-container">
                        <form action="index.php" method="post">
                            <div class="cancel-btn">
                                <i class="fa-solid fa-xmark" class="cancel-icon"></i>
                            </div>
                            <div class="inner-flex-container">
                                <div>Create Post</div>
                            </div>
                            <hr>
                            <div class="inner-flex-container">
                                <input type="text" name="post_title" class="post-title-input" placeholder="Place your post title...">
                            </div>
                            <div class="inner-flex-container">
                                <textarea name="post_content" class="post-content-textarea" placeholder="Say something..."></textarea>
                            </div>
                            <hr>
                            <div class="inner-flex-container">
                                <input type="submit" value="Post" class="post-pop-up-modify-post-btn" name="create_post" disabled>
                            </div>
                        </form>
                    </div>
                    <div class="post-pop-up-inner-container">
                        <form action="index.php" method="post">
                            <div class="cancel-btn">
                                <i class="fa-solid fa-xmark" class="cancel-icon"></i>
                            </div>
                            <div class="inner-flex-container">
                                <div>Edit Post</div>
                            </div>
                            <hr>
                            <div class="inner-flex-container">
                                <input type="text" name="post_title" class="post-title-input">
                            </div>
                            <div class="inner-flex-container">
                                <textarea name="post_content" class="post-content-textarea"></textarea>
                            </div>
                            <hr>
                            <div class="inner-flex-container">
                                <input type="submit" value="Update" class="post-pop-up-modify-post-btn" name="update_post" disabled>
                                <input type="text" name="pid" id="pid" hidden>
                            </div>
                        </form>
                    </div>
                </div>
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
                        </div>
                        <div id="search-section">
                            <form action="search_results.php" method="post">
                                <div>
                                    <input id="user-post-search-box" name="search_query" type="search" placeholder="Search Quora" class="searchbar">
                                </div>
                                <div id="searchbar-results">
                                    <button type="submit" id="submit-search-button" name="submit-search">
                                        <div id="search-string-showcase">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span class="profile-text">Search: </span>
                                            <span class="search-string"></span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
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
                                <div><button>+ Create Space</button></div>
                                <div><button>Physics</button></div>
                                <div><button>Scientific Research</button></div>
                                <div><button>Innovation</button></div>
                                <div><button>Business</button></div>
                                <div><button>Visiting and Travel</button></div>
                                <div><button>Books</button></div>
                                <div><button>Science</button></div>
                                <div><button>Technology</button></div>
                                <div><button>Education</button></div>
                                <div><button>Environmental Science</button></div>
                                <div><button>Computer Science</button></div>
                                <div><button>Engineering</button></div>
                                <div><button>Coding</button></div>
                                <div><button>Software Development</button></div>
                                <div><button>UI/UX</button></div>
                                <div><button>Management</button></div>
                                <div><button>Consulting</button></div>
                                <div><button>English</button></div>
                                <div><button>Politics</button></div>
                                <div><button>Inventions</button></div>
                            </div>
                        </div>
                        <div class="posts">
                            <div id="post-box">
                                <div id="post-profile-pic-container">
                                    <img src="<?php echo($user_image);?>" alt="user_profile_picture">
                                </div>
                                <div id="outer">
                                    <div>
                                        <input type="search" placeholder="What do you want to ask or share?" class="searchbar">
                                    </div>
                                    <div id="options">
                                        <div id="ask-btn">
                                            <a href="">Ask</a>
                                        </div>
                                        <span>|</span>
                                        <div id="answer-btn">
                                            <a href="">Answer</a>
                                        </div>
                                        <span>|</span>
                                        <div id="create-post-btn">
                                            Post
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                            $count_posts_sql = "select COUNT(*) as count from `posts` where uid = $uid";

                            $res = mysqli_query($conn, $count_posts_sql);
                            $data = mysqli_fetch_assoc($res);
                            $number_of_posts_by_user = $data['count'];

                            if($number_of_posts_by_user === "0")
                            {
                                ?>
                                    <div id="empty-post-feed-msg-container">
                                        <i class="fa-solid fa-newspaper" id="post-icon"></i>
                                        <p class="msg">You haven't posted anything yet!</p>
                                    </div>
                                <?php
                            }

                            $sql_posts = "select pid, post_title, post_content, date_and_time, post_image from `posts` where uid = $uid";

                            $post_records = mysqli_query($conn, $sql_posts);

                            while($data = mysqli_fetch_assoc($post_records))
                            {
                                $pid = $data['pid'];
                                $post_title = $data['post_title'];
                                $post_content = $data['post_content'];
                                $date_and_time = $data['date_and_time'];
                                $post_image = $data['post_image'];

                                ?>
                                <div class="post">
                                    <div id="profile_outermost">
                                        <img class="user_image" src="<?php echo($user_image);?>" alt="user_profile_picture">
                                        <div id="profile_outer">
                                            <div id="profile_inner">
                                                <div id="profile_innermost">
                                                    <div><p><a id="user_id_link" href="#"><?php echo($username);?></a></p></div>
                                                    <div>.</div>
                                                    <div><a class="follow-link" href="#">Follow</a></div>
                                                </div>
                                            </div>
                                            <div class="user_title"><?php if($user_title !== "none") echo($user_title)." .";?> Updated <?php echo($date_and_time);?></div>
                                        </div>
                                    </div>
                                    <h3><a class="post_link" href="#"><?php echo($post_title);?></a></h3>
                                    <div class="post_content">
                                    <?php 
                                        echo($post_content);

                                        if($post_image !== "none") 
                                        {
                                            ?>
                                            <div>
                                                <img class="post_img" src="./images/post_images/<?php echo($post_image);?>" alt="post_image">
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    </div>
                                    <form action="index.php" method ="post">
                                        <div class="post-info-bar">
                                            <div class="post-more-options">
                                                <div class="post-more-options-container">
                                                    <input type="text" id="pid" name="pid" value="<?php echo($pid);?>" hidden>
                                                    <input type="button" class="update-post-btn" id="post<?php echo ($pid)?>" name="update_post" value="Update Post">
                                                    <input type="submit" name="delete_post" value="Delete Post">
                                                </div>
                                                <i class="fa-solid fa-ellipsis" id="post-more-options-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="ads">
                            <div class="ad">
                                <img class="ad_images" src="./images/apple_advertisement.jpg" alt="ad">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/samsung_advertisement2.jpg" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/vw_advertisment.png" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/bose_advertisment.png" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/dell_advertisement.jpg" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/google_advertisement.jpg" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/apple_advertisement2.jpg" alt="advertisment">
                            </div>
                            <div class="ad">
                                <img class="ad_images" src="./images/samsung_advertisement.jpg" alt="advertisment">
                            </div>
                        </div>
                    </div>
                </div>
                <script type="module" src="../jquery.js"></script>
                <script src="script.js"></script>
                <script src="https://kit.fontawesome.com/4ca0345904.js" crossorigin="anonymous"></script>
            </body>
            </html>
        <?php
    }
    else
    {
        header('location:../login.php');
    }
?>