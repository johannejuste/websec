<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/router.php');
/* preloader
get('/', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php');
}); */

// #########################################################
// ################### USER INDEX ###############################
// #########################################################

get('/', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_index.php');
});


get('/index', function () {

  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_index.php');
});

// #########################################################
// ################### ADMIN INDEX ###############################
// ########################################################

get('/admin-index', function () {

  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_admin_index.php');
});

get('/admin/show_user_products/:user_id', function ($user_id) {

  $user_id = $user_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_admin_user_product.php');
});

post('/admin/change-user-status', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_admin_change_user_status.php');
});
post('/admin/change-product-status', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_admin_change_product_status.php');
});



// #########################################################
// ################### ADMIN LOGIN ###############################
// #########################################################

get('/admin-login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_admin_login.php');
});

get('/admin-login/error/:message', 'render_admin_login_error');
function render_admin_login_error($message)
{
  $error_message = $message;
  require_once(__DIR__ . '/views_login/view_admin_login.php');
  exit();
}
get('/admin-login/success/:message', 'render_admin_login_success');
function render_admin_login_success($success_message)
{
  $success_message = $success_message;
  require_once(__DIR__ . '/views_login/view_admin_login.php');
  exit();
}
post('/admin-login', function () {

  // check if token is valid

  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_admin_login.php');
});




// #########################################################
// ################### LOGIN ###############################
// #########################################################

get('/login', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_login.php');
});

get('/login/error/:message', 'render_login_error');
function render_login_error($message)
{
  $error_message = $message;
  require_once(__DIR__ . '/views_login/view_login.php');
  exit();
}
get('/login/success/:message', 'render_login_success');
function render_login_success($success_message)
{
  $success_message = $success_message;
  require_once(__DIR__ . '/views_login/view_login.php');
  exit();
}
post('/login', function () {

  // check if token is valid

  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_login.php');
});



// #########################################################
// ################### SIGNUP ##############################
// #########################################################

get('/signup', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_signup.php');
});

get('/signup/error/:message', 'render_signup_error');
function render_signup_error($message)
{
  $error_message = $message;
  require_once(__DIR__ . '/views_login/view_signup.php');
  exit();
}
post('/signup', function () {

  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_signup.php');
});

get('/signup_welcome_email/:user_confirmation_key/:email_recipient', 'serve_signup_confirmation_email');
function serve_signup_confirmation_email($user_confirmation_key, $recipient)
{
  $user_confirmation_key = $user_confirmation_key;
  $recipient = $recipient;
  require_once(__DIR__ . '/apis/api_signup_email.php');
  exit();
}


// from email 
get('/confirm/:user_confirmation_key', function ($user_confirmation_key) {
  $user_confirmation_key = $user_confirmation_key;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_confirm_user.php');
});


// #########################################################
// ################### Comments ###############################
// #########################################################

post('/create-comment/:product_id', function ($product_id) {
  $product_id = $product_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_create_comment.php');
});

// #########################################################
// ################### REPLIES ###############################
// #########################################################

post('/create-reply/:comment_id/:product_id', function ($comment_id, $product_id) {
  $comment_id = $comment_id;
  $product_id = $product_id;


  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_create_reply.php');
});




// #########################################################
// ################### Products ###############################
// #########################################################

get('/single-product/:product_id', function ($product_id) {

  $product_id = $product_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_single_product.php');
});

get('/single-product/:comment_id', function ($comment_id) {

  $comment_id = $comment_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_single_product.php');
});


get('/edit-product/:product_id', function ($product_id) {

  $product_id = $product_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_edit_product.php');
});



get('/create-product', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_create_product.php');
});
get('/create-product/error/:message', function ($error_message) {
  $error_message = $error_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_create_product.php');
});

post('/create-new-product/:user_uuid', function ($id) {

  $id = $id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_create_product.php');
});


// #########################################################
// ################### PASSWORD ######################
// #########################################################


get('/lost-password/success/:message', 'render_success_message');
function render_success_message($success_message)
{
  $success_message = $success_message;
  require_once(__DIR__ . '/views/view_new_password.php');
  exit();
};

get('/create-new-password/:user_email', function ($user_email) {
  $user_email = $user_email;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_create_new_password.php');
});
get('/create-new-password/error/:message', function ($error_message) {
  $error_message = $error_message;

  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_create_new_password.php');
});

post('/create-new-password', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_create_new_password.php');
});




// #########################################################
// #################### SEARCH #############################
// #########################################################


post('/search', function () {

  require_once($_SERVER['DOCUMENT_ROOT'] . '/apis/api_search.php');
});

get('/search', function () {
  /*   echo 'her';
  exit; */
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_login/view_login.php');
});




// #########################################################
// ################# EDIT USER ACCOUNT #####################
// #########################################################

post('/upload-profile-image', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_upload_profile_image.php');
});

get('/account', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account.php');
});

get('/account/success/:successmessage', function ($success_message) {
  $success_message = $success_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account.php');
});

post('/delete-account', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_delete_my_account.php');
});

post('/delete-product', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_delete_my_product.php');
});


// ##### my-user-information
get('/account-edit/my-user-information', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_edit_information.php');
});

get('/account-edit/my-user-information/error/:errormessage', function ($error_message) {
  $error_message = $error_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_edit_information.php');
});

get('/account-edit/my-user-information/success/:successmessage', function ($success_message) {
  $success_message = $success_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_edit_information.php');
});



// ##### change-password
get('/account-edit/change-password', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_change_password.php');
});

get('/account-edit/change-password/error/:errormessage', function ($error_message) {
  $error_message = $error_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_change_password.php');
});

get('/account-edit/change-password/success/:successmessage', function ($success_message) {
  $success_message = $success_message;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_account_change_password.php');
});

post('/update-product/:product_id', function ($product_id) {

  $product_id = $product_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_update_product_check.php');
});

get('/update-product/error/:errormessage/:product_id', function ($error_message, $product_id) {
  $error_message = $error_message;
  $product_id = $product_id;
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_edit_product.php');
});

post('/update-account-information', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_update_account_information.php');
});

post('/update-user-account-password', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_update_account_password.php');
});


post('/upload-profile-image', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_upload_profile_image.php');
});
post('/lost-password-mail', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_send_lost_password_mail.php');
});

// #########################################################
// ################### LOGOUT ##############################
// #########################################################
get('/logout', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/bridges/bridge_logout.php');
});

// For GET or POST
any('/404', function () {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views_app/view_404.php');
});
