<?php
    if(isset($_COOKIE['username']) && isset($_COOKIE['uid']))
    {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <?php
                    $uid = $_COOKIE['uid'];

                    include('../connect.php');

                    $sql_users_table = "select user_image, user_title from `users` where uid = $uid";
                    $records = mysqli_query($conn, $sql_users_table);
                    $data = mysqli_fetch_assoc($records);

                    $user_image = $data['user_image'];
                    $user_title = $data['user_title'];
                ?>
                <title><?php echo($_COOKIE['username']);?> - Quora</title>
            </head>
            <style>
                #user_image
                {
                    height: 7rem;
                }
                #edit_icon-container
                {
                    position: absolute;
                    display: none;
                }
                .flex-container
                {
                    display: flex;
                }
                #profile-pic-container
                {
                    position: relative;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    clip-path: circle();
                }
                #profile-pic-container:hover #edit_icon-container
                {
                    display: flex;
                }
                #edit_icon-container
                {
                    padding: 0.5rem;
                    justify-content: center;
                    align-items: center;
                    background-color: #1a5aff;
                    clip-path: circle();
                }
                #edit_icon-container > img
                {
                    height: 1.5rem;
                    filter: invert();
                    z-index: 999;
                }
                /* #edit_icon-container > input[type="file"]
                {
                    z-index: 0;
                } */
            </style>
            <body>
                <div class="flex-container">
                    <div id="profile-pic-container">
                        <img id="user_image" src="./user_images/<?php echo($data['user_image']);?>" alt="<?php echo($_COOKIE['username']);?>-user-image">
                        <div id="edit_icon-container">
                            <img src="./images/icon-edit.svg" alt="Edit" id="user_image_icon">
                            <form>
                                <input id="user_image_input" type="file" name="user_image" hidden>
                            </form>
                        </div>
                    </div>
                </div>
                <h1>Welcome! <?php echo $_COOKIE['username'];?></h1>
                <a href="../logout.php?username=<?php echo $_COOKIE['username'];?>">Logout</a>
            </body>
            <script src="https://kit.fontawesome.com/4ca0345904.js" crossorigin="anonymous"></script>
            <script>
                const edit_icon_container = document.getElementById("edit_icon-container");
                const user_image_input = document.getElementById("user_image_input");
                const selected_image = user_image_input.value;

                edit_icon_container.addEventListener('click', () => {

                    user_image_input.click();
                });

                user_image_input.addEventListener('change', () => {

                    const imageFileData = new FormData();
                    const imageFile = user_image_input.files[0];
                    imageFileData.append('user_image', imageFile); // name, value

                    jQuery.ajax({

                        url: './upload_profile_pic.php',
                        type: 'post',
                        data: imageFileData,
                        contentType: false,
                        processData: false,
                        success: (result) => {
                            console.log(result);
                        },
                        error: (xhr, status, error) => {
                            console.log(xhr, status, error);
                        }
                    });
                });

            </script>
            <script type="module" src="../jquery.js"></script>
            </html>
        <?php
    }
    else
    {
        header('location:../login.php');
    }
?>