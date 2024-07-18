let prev_active_page_btn_id = "home_btn";

function changeFontColor(current_active_page_btn_id) {

    if(current_active_page_btn_id !== prev_active_page_btn_id) {
        
            // fetch the current active page btn
            const current_active_page_btn = document.getElementById(current_active_page_btn_id);
        
            // change the color of the current active page button to shade of red (#b92b27)
            current_active_page_btn.style.color = "#b92b27";
        
            // fetch the prev active page btn
            const prev_active_page_btn = document.getElementById(prev_active_page_btn_id);
            
            // change the color of the previous active button back to shade of black again
            prev_active_page_btn.style.color = "rgba(0, 0, 0, 0.705)";
        
            // the current active page btn id will be the previous active page btn id for the next current active page btn
            prev_active_page_btn_id = current_active_page_btn_id;
    }
}

const post_btn = document.getElementById('create-post-btn');
const app_container = document.getElementById('app-container');

const post_pop_up_outer_container = document.getElementsByClassName('post-pop-up-outer-container')[0];

const post_pop_up_inner_containers = document.getElementsByClassName('post-pop-up-inner-container');
const create_post_pop_up_inner_container = post_pop_up_inner_containers[0];
const update_post_pop_up_inner_container = post_pop_up_inner_containers[1];

const post_pop_up_modify_post_btns = document.getElementsByClassName('post-pop-up-modify-post-btn');
const create_post_card_btn = post_pop_up_modify_post_btns[0];
const update_post_card_btn = post_pop_up_modify_post_btns[1];

const cancel_btns = document.getElementsByClassName('cancel-btn');
const create_post_cancel_btn = cancel_btns[0];
const update_post_cancel_btn = cancel_btns[1];

const post_content_textareas = document.getElementsByClassName('post-content-textarea');
const create_post_content_textarea = post_content_textareas[0];
const update_post_content_textarea = post_content_textareas[1];

const post_title_inputs = document.getElementsByClassName('post-title-input');
const create_post_title_input = post_title_inputs[0];
const update_post_title_input = post_title_inputs[1];

const update_post_hidden_pid_field = document.getElementById('pid');

const getEditPostContent = (event) => {

    const post_id = event.target.id;
    const table_pid = post_id.substring(4, post_id.length);

    // set the value of the pid field, to enable editing of post, this will be used in SQL query via PHP
    update_post_hidden_pid_field.value = table_pid;

    jQuery.ajax({

        url: "./get_post_data.php",
        type: "post",
        dataType: "json", // to use the JSON format for the request and response
        data: {pid : table_pid},
        success: (result) => {

            // here, we don't need to parse the JSON object into JavaScript object explicitly
            // as the data is implicitly converted from String format to JSON format on the server side (for us, PHP), 
            // and from JSON format to String format on the client-side (here),
            // because we have set the dataType as json here in the object.

            // destructuring the JavaScript object to extract the information
            const {post_title, post_content} = result;

            // set the post title and content to the one of the current post
            update_post_title_input.value = post_title;
            update_post_content_textarea.value = post_content;
        },
        error: (xhr, status, error) => {
            console.log(error);
        }
    });
};

const update_post_btns = document.getElementsByClassName('update-post-btn');

// getElementsByClassName() returns an HTML Collection, whereas querySelectorAll() returns an array
// to convert the HTML Collection into an array, we can either use the spread operator (...), or use Array.from()

const update_post_btns_array = [...update_post_btns];
// const update_post_btns_array = Array.from(update_post_btns);

update_post_btns_array.forEach((update_post_btn) => {

    update_post_btn.addEventListener('click', (event) => {
    
        getEditPostContent(event);

        app_container.style.position = "fixed";
        post_pop_up_outer_container.style.display = "flex";
        update_post_pop_up_inner_container.style.display = "block";
    });
});

let isClickedFromSearchSection = false;

post_btn.addEventListener('click', () => {

    app_container.style.position = "fixed";
    post_pop_up_outer_container.style.display = "flex";
    create_post_pop_up_inner_container.style.display = "block";
});

const checkIfTextAreaEmpty = () => {

    if(create_post_content_textarea.value === "") {

        create_post_card_btn.disabled = true;
    }
    else {

        create_post_card_btn.disabled = false;
    }

    if(update_post_content_textarea.value === "") {

        update_post_card_btn.disabled = true;
    }
    else {

        update_post_card_btn.disabled = false;
    }
};

create_post_content_textarea.addEventListener('focus', checkIfTextAreaEmpty);
create_post_content_textarea.addEventListener('blur', checkIfTextAreaEmpty);

update_post_content_textarea.addEventListener('focus', checkIfTextAreaEmpty);
update_post_content_textarea.addEventListener('blur', checkIfTextAreaEmpty);

const checkIfTextInputEmpty = () => {

    if(create_post_title_input.value === "") {

        create_post_card_btn.disabled = true;
    }
    else {

        create_post_card_btn.disabled = false;
    }
};

create_post_title_input.addEventListener('focus', checkIfTextInputEmpty);
create_post_title_input.addEventListener('blur', checkIfTextInputEmpty);

update_post_title_input.addEventListener('focus', checkIfTextInputEmpty);
update_post_title_input.addEventListener('blur', checkIfTextInputEmpty);

create_post_cancel_btn.addEventListener('click', () => {

    app_container.style.position = "static";
    post_pop_up_outer_container.style.display = "none";
    create_post_pop_up_inner_container.style.display = "none";
});

update_post_cancel_btn.addEventListener('click', () => {

    app_container.style.position = "static";
    post_pop_up_outer_container.style.display = "none";
    update_post_pop_up_inner_container.style.display = "none";
});

create_post_card_btn.addEventListener('mouseover', () => {

    if(create_post_content_textarea.value === "" || create_post_title_input.value === "") {

        create_post_card_btn.disabled = true;
    }
    else {

        create_post_card_btn.disabled = false;
    }
});

update_post_card_btn.addEventListener('mouseover', () => {

    if(update_post_content_textarea.value === "" || update_post_title_input.value === "") {

        update_post_card_btn.disabled = true;
    }
    else {

        update_post_card_btn.disabled = false;
    }
});

const user_post_search_box = document.getElementById('user-post-search-box');
const searchbar_results = document.getElementById('searchbar-results');
const search_string = document.querySelector("#search-string-showcase > .search-string");

const hideResultDropDown = () => {

    searchbar_results.style.display = "none";
    post_pop_up_outer_container.style.display = "none";
    create_post_pop_up_inner_container.style.display = "block";
    update_post_pop_up_inner_container.style.display = "block";
    app_container.style.display = "static";
};

const showResultDropDown = () => {

    searchbar_results.style.display = "block";
    post_pop_up_outer_container.style.display = "flex";
    create_post_pop_up_inner_container.style.display = "none";
    update_post_pop_up_inner_container.style.display = "none";
    app_container.style.display = "fixed";
    search_string.innerText = user_post_search_box.value;
};

const toggleResultDropDown = () => {
    
    if(user_post_search_box.value === "") {

        hideResultDropDown();
    }
    else {

        showResultDropDown();
    }
};

const update_search_results = (search_query, results) => {

    const search_query_details = search_query.split(" ");
    const searched_first_name = search_query_details[0];
    const searched_last_name = search_query_details[1];

    const searchbar_results = document.getElementById('searchbar-results');

    const old_search_profiles_container = document.getElementById('search-profiles-result-container');

    if(old_search_profiles_container !== null) {
        
        old_search_profiles_container.remove();
    }

    const new_search_profiles_container = document.createElement("div");
    new_search_profiles_container.id = "search-profiles-result-container";

    const users = results.split(",");

    users.pop(); // to remove the unnecessary empty string at the end of the array

    for(let user_data of users) {

        const user_details = user_data.split(":");

        const username = user_details[0].split(" ");
        const user_image_name = user_details[1];

        const firstname = username[0];
        const lastname = username[1];

        const user_profile_container = document.createElement("div");
        user_profile_container.className = "search-profile";
        user_profile_container.style.display = "flex";
        user_profile_container.style.justifyContent = "flex-start";
        user_profile_container.style.alignItems = "center";

        const username_container = document.createElement("div");
        username_container.className = "search-result-user-name";

        const profile_text = document.createElement("span");
        profile_text.innerText = "Profile: ";
        profile_text.className = "profile-text";
        username_container.appendChild(profile_text);

        const firstname_container = document.createElement("span");
        firstname_container.innerText = firstname;

        if(firstname.toLowerCase() === searched_first_name.toLowerCase()) {

            firstname_container.className = "user-firstname-container search-results-match";
        }
        else {
            
            firstname_container.className = "user-firstname-container";
        }

        username_container.appendChild(firstname_container);

        if(lastname !== undefined) {

            const lastname_container = document.createElement("span");
            lastname_container.innerText = " "+lastname;

            if(searched_last_name !== undefined && lastname.toLowerCase() === searched_last_name.toLowerCase()) {

                lastname_container.className = "user-lastname-container search-results-match";
            }
            else {
                
                lastname_container. className= "user-lastname-container";
            }
            
            // lastname_container.style.marginLeft = "0.3em";
            username_container.appendChild(lastname_container);
        }

        const user_image = document.createElement("img");
        user_image.src = "./user_images/"+user_image_name;
        user_image.alt = "user_image";
        user_image.className = "search-result-user-image";

        user_profile_container.appendChild(user_image);
        user_profile_container.appendChild(username_container);

        new_search_profiles_container.appendChild(user_profile_container);
    }

    searchbar_results.appendChild(new_search_profiles_container);
};

const getSearchResults = () => {

    const search_query = user_post_search_box.value;

    jQuery.ajax({
        url: './get_search_results.php',
        type: 'post',
        data: 'search_query='+search_query,
        success: (results) => {
            update_search_results(search_query, results);
        }
    });
};

user_post_search_box.addEventListener('input', () => {

    if(user_post_search_box.value !== "") {

        getSearchResults();
    }

    toggleResultDropDown();
});

user_post_search_box.addEventListener('focus', () => {

    showResultDropDown();
});

user_post_search_box.addEventListener('blur', () => {

    if(!isClickedFromSearchSection) {
        
        hideResultDropDown();
    }
});

searchbar_results.addEventListener('mouseover', () => {

    isClickedFromSearchSection = true;
});

searchbar_results.addEventListener('mouseleave', () => {

    isClickedFromSearchSection = false;
});