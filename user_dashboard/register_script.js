const password_field = document.getElementById('password');
const confirm_password_field = document.getElementById('confirm_password');
const confirm_password_fieldset = document.getElementById('confirm_password_fieldset');
const username_field = document.getElementById('username');
const answer_field = document.getElementById('answer');
const create_account_btn = document.getElementById('create_account');
const error_msg = document.getElementById('error_msg');

const checkEmptyFields = () => {

    const username = username_field.value;
    const password = password_field.value;
    const confirm_password = confirm_password_field.value;
    const answer = answer_field.value;

    if(username === "") {

        username_field.placeholder = "* This is a required field";
    }
    if(password === "") {

        password_field.placeholder = "* This is a required field";
    }
    if(confirm_password === "") {

        confirm_password_field.placeholder = "* This is a required field";
    }
    if(answer === "") {

        answer_field.placeholder = "* This is a required field";
    }

    if(username === "" || password === "" || confirm_password === "" || answer === "") {

        create_account_btn.disabled = true;
    }
    else {

        create_account_btn.disabled = false;
    }
}

const checkPassword = () => {

    const password = password_field.value;
    const confirm_password = confirm_password_field.value;

    if(password !== confirm_password) {
    
        confirm_password_fieldset.style.height = "4em";

        setTimeout(() => {

            error_msg.style.display = "block";

        }, 500);

        create_account_btn.disabled = true;
    }
    else {

        confirm_password_fieldset.style.height = "2.6em";

        error_msg.style.display = "none";

        create_account_btn.disabled = false;
    }

    checkEmptyFields();
};

username_field.addEventListener('focus', checkEmptyFields);
username_field.addEventListener('blur', checkEmptyFields);

answer_field.addEventListener('focus', checkEmptyFields);
answer_field.addEventListener('blur', checkEmptyFields);

password_field.addEventListener('focus', checkPassword);
password_field.addEventListener('blur', checkPassword);

confirm_password_field.addEventListener('focus', checkPassword);
confirm_password_field.addEventListener('blur', checkPassword);