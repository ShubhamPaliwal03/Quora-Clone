const follow_btns = document.getElementsByClassName('follow-btn');

// getElementsByClassName() returns an HTML Collection, whereas querySelectorAll() returns an array
// to convert the HTML Collection into an array, we can either use the spread operator (...), or use Array.from()

const follow_btns_array = Array.from(follow_btns);

const follow_unfollow = (event) => {

    const follow_btn = event.target;
    const follow_btn_id = event.target.id;
    const following_user_id = follow_btn_id.substring(15, follow_btn_id.length);
    // console.log(following_user_id);

    if(follow_btn.value === "Follow") {

        jQuery.ajax({
            url: './follow.php',
            type: 'post',
            data: 'following_user_id='+following_user_id,
            success: () => {
                new Audio('../sounds/user_followed.mp3').play();
                follow_btn.classList.remove('Follow');
                follow_btn.classList.add('Unfollow');
                follow_btn.value = 'Unfollow';
            },
            error: (xhr, status, error) => {
                console.log("Error in follow request: ", status, error);
            }
        });
    }
    else {

        jQuery.ajax({
            url: './unfollow.php',
            type: 'post',
            data: 'following_user_id='+following_user_id,
            success: () => {
                new Audio('../sounds/user_unfollowed.mp3').play();
                follow_btn.classList.remove('Unfollow');
                follow_btn.classList.add('Follow');
                follow_btn.value = 'Follow';
            },
            error: (xhr, status, error) => {
                console.log("Error in unfollow request: ",status, error);
            }
        });
    }
}

for (const follow_btn of follow_btns_array) {

    follow_btn.addEventListener('click', follow_unfollow);
}