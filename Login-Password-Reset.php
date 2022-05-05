<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: reset-password.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $email = $IsAdmin = $firstname = $lastname = "";
$username_err = $email_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($email_err)){
        // Prepare a select statement
        $sql = "SELECT p.id, u.User_Name_First, u.User_Name_Last,a.email, p.user_id, p.user_password FROM User_Password p left join User u on u.id = p.id 
left join Password_Reset a on p.id = a.id

WHERE p.user_id = ?";
		
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname, $memail, $musername, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        //if(password_verify($password, $hashed_password)){
                          if($email == $memail and $username == $musername){
						  
						  // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["firstname"] = $firstname;
                            $_SESSION["lastname"] = $lastname;                            
                            $_SESSION["IsAdmin"] = $IsAdmin; 
                            // Redirect user to welcome page
                            header("location: reset-password.php");
                        } else{
                            
							print_r(array_keys($stmt));
							// email is not valid, display a generic error message
                            $login_err = "Invalid username or email.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<head>
<meta charset="UTF-8">

    <title>APA - Password Reset</title>
<html lang="en" dir="ltr" prefix="content: http://purl.org/rss/1.0/modules/content/  dc: http://purl.org/dc/terms/  foaf: http://xmlns.com/foaf/0.1/  og: http://ogp.me/ns#  rdfs: http://www.w3.org/2000/01/rdf-schema#  schema: http://schema.org/  sioc: http://rdfs.org/sioc/ns#  sioct: http://rdfs.org/sioc/types#  skos: http://www.w3.org/2004/02/skos/core#  xsd: http://www.w3.org/2001/XMLSchema# " class=" js" style="height: 100%; font-size: 16px;"><head>
	<link rel="stylesheet" href="MembershipRoster.css"/>
    <meta charset="utf-8">
<noscript><style>form.antibot * :not(.antibot-message) { display: none !important; }</style>
</noscript><meta name="Generator" content="Drupal 9 (https://www.drupal.org)">
<meta name="MobileOptimized" content="width">
<meta name="HandheldFriendly" content="true">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style data-tippy-stylesheet="">.tippy-box[data-animation=fade][data-state=hidden]{opacity:0}[data-tippy-root]{max-width:calc(100vw - 10px)}.tippy-box{position:relative;background-color:#333;color:#fff;border-radius:4px;font-size:14px;line-height:1.4;outline:0;transition-property:transform,visibility,opacity}.tippy-box[data-placement^=top]>.tippy-arrow{bottom:0}.tippy-box[data-placement^=top]>.tippy-arrow:before{bottom:-7px;left:0;border-width:8px 8px 0;border-top-color:initial;transform-origin:center top}.tippy-box[data-placement^=bottom]>.tippy-arrow{top:0}.tippy-box[data-placement^=bottom]>.tippy-arrow:before{top:-7px;left:0;border-width:0 8px 8px;border-bottom-color:initial;transform-origin:center bottom}.tippy-box[data-placement^=left]>.tippy-arrow{right:0}.tippy-box[data-placement^=left]>.tippy-arrow:before{border-width:8px 0 8px 8px;border-left-color:initial;right:-7px;transform-origin:center left}.tippy-box[data-placement^=right]>.tippy-arrow{left:0}.tippy-box[data-placement^=right]>.tippy-arrow:before{left:-7px;border-width:8px 8px 8px 0;border-right-color:initial;transform-origin:center right}.tippy-box[data-inertia][data-state=visible]{transition-timing-function:cubic-bezier(.54,1.5,.38,1.11)}.tippy-arrow{width:16px;height:16px;color:#333}.tippy-arrow:before{content:"";position:absolute;border-color:transparent;border-style:solid}.tippy-content{position:relative;padding:5px 9px;z-index:1}</style><style media="">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=0-K2ft4J') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=0-K2ft4J', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=0-K2ft4J', sizingMethod='scale');}</style>
<style media=" and (-webkit-min-device-pixel-ratio: 2),  and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=3Dgtps4G') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=3Dgtps4G', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=3Dgtps4G', sizingMethod='scale');}</style>
<style media="screen and (min-width: 480px)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=HVLqtBZF') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=HVLqtBZF', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=HVLqtBZF', sizingMethod='scale');}</style>
<style media="screen and (min-width: 480px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 480px) and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=UCS7GvFb') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=UCS7GvFb', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=UCS7GvFb', sizingMethod='scale');}</style>
<style media="screen and (min-width: 768px)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=2uQJ2S6l') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=2uQJ2S6l', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Copy%20of%20background.png?itok=2uQJ2S6l', sizingMethod='scale');}</style>
<style media="screen and (min-width: 768px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 768px) and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=B6rQFFMV') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=B6rQFFMV', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Copy%20of%20background.png?itok=B6rQFFMV', sizingMethod='scale');}</style>
<style media="screen and (min-width: 992px)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=nuQPnCeF') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=nuQPnCeF', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Copy%20of%20background.png?itok=nuQPnCeF', sizingMethod='scale');}</style>
<style media="screen and (min-width: 992px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 992px) and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=9neKEwSx') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=9neKEwSx', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Copy%20of%20background.png?itok=9neKEwSx', sizingMethod='scale');}</style>
<style media="all and (min-width: 1600px)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/2021-02/Copy%20of%20background.png') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Copy%20of%20background.png', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Copy%20of%20background.png', sizingMethod='scale');}</style>
<style media="all and (min-width: 1600px) and (-webkit-min-device-pixel-ratio: 2), all and (min-width: 1600px) and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/2021-02/Copy%20of%20background.png') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Copy%20of%20background.png', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Copy%20of%20background.png', sizingMethod='scale');}</style>
<style media="screen and (min-width: 1200x)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/laptop_1x/public/2021-02/Copy%20of%20background.png?itok=UVxo_lZd') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_1x/public/2021-02/Copy%20of%20background.png?itok=UVxo_lZd', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_1x/public/2021-02/Copy%20of%20background.png?itok=UVxo_lZd', sizingMethod='scale');}</style>
<style media="screen and (min-width: 1200x) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 1200x) and (min-resolution: 192dpi)">.block-block-content90c19b42-56ba-42de-b745-8de178042c97 {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/laptop_2x/public/2021-02/Copy%20of%20background.png?itok=Qy_2DU48') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_2x/public/2021-02/Copy%20of%20background.png?itok=Qy_2DU48', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_2x/public/2021-02/Copy%20of%20background.png?itok=Qy_2DU48', sizingMethod='scale');}</style>
<style media="">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=wUQWPXNZ') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=wUQWPXNZ', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=wUQWPXNZ', sizingMethod='scale');}</style>
<style media=" and (-webkit-min-device-pixel-ratio: 2),  and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ZickgwaB') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ZickgwaB', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ZickgwaB', sizingMethod='scale');}</style>
<style media="screen and (min-width: 480px)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=8c0qSY68') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=8c0qSY68', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=8c0qSY68', sizingMethod='scale');}</style>
<style media="screen and (min-width: 480px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 480px) and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=NdxBp2AW') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=NdxBp2AW', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/mobile_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=NdxBp2AW', sizingMethod='scale');}</style>
<style media="screen and (min-width: 768px)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ssmg7OjW') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ssmg7OjW', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=ssmg7OjW', sizingMethod='scale');}</style>
<style media="screen and (min-width: 768px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 768px) and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=4eY9uyvh') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=4eY9uyvh', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_portrait_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=4eY9uyvh', sizingMethod='scale');}</style>
<style media="screen and (min-width: 992px)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=W8UeWRpk') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=W8UeWRpk', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=W8UeWRpk', sizingMethod='scale');}</style>
<style media="screen and (min-width: 992px) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 992px) and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=rAwFa5ix') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=rAwFa5ix', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/tablet_landscape_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=rAwFa5ix', sizingMethod='scale');}</style>
<style media="all and (min-width: 1600px)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg', sizingMethod='scale');}</style>
<style media="all and (min-width: 1600px) and (-webkit-min-device-pixel-ratio: 2), all and (min-width: 1600px) and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/2021-02/Digital%20Inclusion%20Matters.jpeg', sizingMethod='scale');}</style>
<style media="screen and (min-width: 1200x)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/laptop_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=Ys8cR-Zp') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=Ys8cR-Zp', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_1x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=Ys8cR-Zp', sizingMethod='scale');}</style>
<style media="screen and (min-width: 1200x) and (-webkit-min-device-pixel-ratio: 2), screen and (min-width: 1200x) and (min-resolution: 192dpi)">.block-block-content78882128-87fc-4412-846a-0e0462fae92e {background-color: #333333 !important;background-image:  url('/sites/default/files/styles/laptop_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=-TsOAw_G') !important;background-repeat: no-repeat !important;background-position: center 40% !important;z-index: auto;background-size: cover !important;-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=-TsOAw_G', sizingMethod='scale');-ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/sites/default/files/styles/laptop_2x/public/2021-02/Digital%20Inclusion%20Matters.jpeg?itok=-TsOAw_G', sizingMethod='scale');}</style>
<link rel="shortcut icon" href="/themes/custom/rtf/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_d-1tZHzkr7xOZPiR4KtU_mnkuiKCGYEV9ab8FK2md9k.css">
<link rel="stylesheet" media="all" href="/webform/css/newsletter_webform?r3gnm2">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_1WUJ2M294DQx5H2eH7RlQLSlzPdKefrhLvm74Ac_IHo.css">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_uMLXRqj8oiKfaVlMJHgY0GlWN6CE1J9Bl8aaz2eEMqw.css">
<link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;display=swap">
<link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Merriweather:400,700,900&amp;display=swap">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_5dMDjxM_GhJLXJmCzYesb9Fdh4E9nPO-kgXUOcbjUic.css">

    
  <script data-dapp-detection="">!function(){let e=!1;function n(){if(!e){const n=document.createElement("meta");n.name="dapp-detected",document.head.appendChild(n),e=!0}}if(window.hasOwnProperty("ethereum")){if(window.__disableDappDetectionInsertion=!0,void 0===window.ethereum)return;n()}else{var t=window.ethereum;Object.defineProperty(window,"ethereum",{configurable:!0,enumerable:!1,set:function(e){window.__disableDappDetectionInsertion||n(),t=e},get:function(){if(!window.__disableDappDetectionInsertion){const e=arguments.callee;e&&e.caller&&e.caller.toString&&-1!==e.caller.toString().indexOf("getOwnPropertyNames")||n()}return t}})}}();</script><link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css"><script type="text/javascript" charset="UTF-8" src="https://translate.googleapis.com/_/translate_http/_/js/k=translate_http.tr.en_US.5ry4TwO4tFM.O/am=AQ/d=1/exm=el_conf/ed=1/rs=AN8SPfoLubijnObGZYRJqTH9fQ8LHAJBiA/m=el_main"></script><style type="text/css">.fl-progEnhance-basic, .fl-ProgEnhance-basic { display: none; } .fl-progEnhance-enhanced, .fl-ProgEnhance-enhanced { display: block; }</style></head>




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head> 
<link rel="stylesheet" href="MembershipRoster.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;

        }
    </style>
 
<!--<div class="left"> <img src="APA_logo.png" ></img></div>-->

	    <script data-dapp-detection="">!function(){let e=!1;function n(){if(!e){const n=document.createElement("meta");n.name="dapp-detected",document.head.appendChild(n),e=!0}}if(window.hasOwnProperty("ethereum")){if(window.__disableDappDetectionInsertion=!0,void 0===window.ethereum)return;n()}else{var t=window.ethereum;Object.defineProperty(window,"ethereum",{configurable:!0,enumerable:!1,set:function(e){window.__disableDappDetectionInsertion||n(),t=e},get:function(){if(!window.__disableDappDetectionInsertion){const e=arguments.callee;e&&e.caller&&e.caller.toString&&-1!==e.caller.toString().indexOf("getOwnPropertyNames")||n()}return t}})}}();</script><link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css"><script type="text/javascript" charset="UTF-8" src="https://translate.googleapis.com/_/translate_http/_/js/k=translate_http.tr.en_US.5ry4TwO4tFM.O/am=AQ/d=1/exm=el_conf/ed=1/rs=AN8SPfoLubijnObGZYRJqTH9fQ8LHAJBiA/m=el_main"></script><style type="text/css">.fl-progEnhance-basic, .fl-ProgEnhance-basic { display: none; } .fl-progEnhance-enhanced, .fl-ProgEnhance-enhanced { display: block; }</style></head>
  <body class="path-frontpage fl-theme-prefsEditor-default" style="position: relative; min-height: 100%; top: 0px; line-height: 1.75;">
       <!-- <a href="#main-content" class="visually-hidden focusable skip-link">-->
  
    </a>
    <div class="flc-prefsEditor-separatedPanel fl-prefsEditor-separatedPanel" id="fluid-id-cqlsazof-331">
  <!-- This is the div that will contain the Preference Editor component. -->
  <div class="flc-slidingPanel-panel flc-prefsEditor-iframe" id="fluid-id-cqlsazof-429" aria-label="User Preferences" role="group" style="height: 0px;" aria-expanded="false"><iframe class="flc-iframe fl-prefsEditor-separatedPanel-iframe" src="/modules/contrib/fluidui/infusion/src/framework/preferences/html/SeparatedPanelPrefsEditorFrame.html" style="display: none; height: 0px;"></iframe></div>
  <!-- This div is for the sliding panel that shows and hides the Preference Editor controls. -->
  <div class="fl-panelBar">
    <span class="fl-prefsEditor-buttons">
      <button id="reset" class="flc-prefsEditor-reset fl-prefsEditor-reset" style="display: none;" aria-controls="fluid-id-cqlsazof-429" role="button"><span class="fl-icon-undo"></span> Reset</button>
 
    </span>
  </div>
</div>
<nav class="flc-toc-tocContainer"></nav>

      <div class="dialog-off-canvas-main-canvas" data-off-canvas-main-canvas="">
    


  <div class="gtranslate-container" id="gtranslateContainer">
  <div class="region region-gtranslate">
    <div id="block-gtranslate" class="block block-gtranslate block-gtranslate-block">
  
 
    
      
<div class="gtranslate">
<script>eval(unescape("eval%28function%28p%2Ca%2Cc%2Ck%2Ce%2Cr%29%7Be%3Dfunction%28c%29%7Breturn%28c%3Ca%3F%27%27%3Ae%28parseInt%28c/a%29%29%29+%28%28c%3Dc%25a%29%3E35%3FString.fromCharCode%28c+29%29%3Ac.toString%2836%29%29%7D%3Bif%28%21%27%27.replace%28/%5E/%2CString%29%29%7Bwhile%28c--%29r%5Be%28c%29%5D%3Dk%5Bc%5D%7C%7Ce%28c%29%3Bk%3D%5Bfunction%28e%29%7Breturn%20r%5Be%5D%7D%5D%3Be%3Dfunction%28%29%7Breturn%27%5C%5Cw+%27%7D%3Bc%3D1%7D%3Bwhile%28c--%29if%28k%5Bc%5D%29p%3Dp.replace%28new%20RegExp%28%27%5C%5Cb%27+e%28c%29+%27%5C%5Cb%27%2C%27g%27%29%2Ck%5Bc%5D%29%3Breturn%20p%7D%28%276%207%28a%2Cb%29%7Bn%7B4%282.9%29%7B3%20c%3D2.9%28%22o%22%29%3Bc.p%28b%2Cf%2Cf%29%3Ba.q%28c%29%7Dg%7B3%20c%3D2.r%28%29%3Ba.s%28%5C%27t%5C%27+b%2Cc%29%7D%7Du%28e%29%7B%7D%7D6%20h%28a%29%7B4%28a.8%29a%3Da.8%3B4%28a%3D%3D%5C%27%5C%27%29v%3B3%20b%3Da.w%28%5C%27%7C%5C%27%29%5B1%5D%3B3%20c%3B3%20d%3D2.x%28%5C%27y%5C%27%29%3Bz%283%20i%3D0%3Bi%3Cd.5%3Bi++%294%28d%5Bi%5D.A%3D%3D%5C%27B-C-D%5C%27%29c%3Dd%5Bi%5D%3B4%282.j%28%5C%27k%5C%27%29%3D%3DE%7C%7C2.j%28%5C%27k%5C%27%29.l.5%3D%3D0%7C%7Cc.5%3D%3D0%7C%7Cc.l.5%3D%3D0%29%7BF%286%28%29%7Bh%28a%29%7D%2CG%29%7Dg%7Bc.8%3Db%3B7%28c%2C%5C%27m%5C%27%29%3B7%28c%2C%5C%27m%5C%27%29%7D%7D%27%2C43%2C43%2C%27%7C%7Cdocument%7Cvar%7Cif%7Clength%7Cfunction%7CGTranslateFireEvent%7Cvalue%7CcreateEvent%7C%7C%7C%7C%7C%7Ctrue%7Celse%7CdoGTranslate%7C%7CgetElementById%7Cgoogle_translate_element2%7CinnerHTML%7Cchange%7Ctry%7CHTMLEvents%7CinitEvent%7CdispatchEvent%7CcreateEventObject%7CfireEvent%7Con%7Ccatch%7Creturn%7Csplit%7CgetElementsByTagName%7Cselect%7Cfor%7CclassName%7Cgoog%7Cte%7Ccombo%7Cnull%7CsetTimeout%7C500%27.split%28%27%7C%27%29%2C0%2C%7B%7D%29%29"))</script><style>
#goog-gt-tt {display:none !important;}

.goog-te-banner-frame {display:none !important;}

.goog-te-menu-value:hover {text-decoration:none !important;}

body {top:0 !important;}

#google_translate_element2 {display:none!important;}
</style><div id="google_translate_element2"><div class="skiptranslate goog-te-gadget" dir="ltr" style=""><div id=":0.targetLanguage"><select class="goog-te-combo" aria-label="Language Translate Widget">
<option value="">Select Language</option>
<option value="af">Afrikaans</option>
<option value="sq">Albanian</option>
<option value="am">Amharic</option>
<option value="ar">Arabic</option>
<option value="hy">Armenian</option>
<option value="az">Azerbaijani</option>
<option value="eu">Basque</option>
<option value="be">Belarusian</option>
<option value="bn">Bengali</option>
<option value="bs">Bosnian</option>
<option value="bg">Bulgarian</option>
<option value="ca">Catalan</option>
<option value="ceb">Cebuano</option>
<option value="ny">Chichewa</option>
<option value="zh-CN">Chinese (Simplified)</option>
<option value="zh-TW">Chinese (Traditional)</option>
<option value="co">Corsican</option>
<option value="hr">Croatian</option>
<option value="cs">Czech</option>
<option value="da">Danish</option>
<option value="nl">Dutch</option>
<option value="eo">Esperanto</option>
<option value="et">Estonian</option>
<option value="tl">Filipino</option>
<option value="fi">Finnish</option>
<option value="fr">French</option>
<option value="fy">Frisian</option>
<option value="gl">Galician</option>
<option value="ka">Georgian</option>
<option value="de">German</option>
<option value="el">Greek</option>
<option value="gu">Gujarati</option>
<option value="ht">Haitian Creole</option>
<option value="ha">Hausa</option>
<option value="haw">Hawaiian</option>
<option value="iw">Hebrew</option>
<option value="hi">Hindi</option>
<option value="hmn">Hmong</option>
<option value="hu">Hungarian</option>
<option value="is">Icelandic</option>
<option value="ig">Igbo</option>
<option value="id">Indonesian</option>
<option value="ga">Irish</option>
<option value="it">Italian</option>
<option value="ja">Japanese</option>
<option value="jw">Javanese</option>
<option value="kn">Kannada</option>
<option value="kk">Kazakh</option>
<option value="km">Khmer</option>
<option value="rw">Kinyarwanda</option>
<option value="ko">Korean</option>
<option value="ku">Kurdish (Kurmanji)</option>
<option value="ky">Kyrgyz</option>
<option value="lo">Lao</option>
<option value="la">Latin</option>
<option value="lv">Latvian</option>
<option value="lt">Lithuanian</option>
<option value="lb">Luxembourgish</option>
<option value="mk">Macedonian</option>
<option value="mg">Malagasy</option>
<option value="ms">Malay</option>
<option value="ml">Malayalam</option>
<option value="mt">Maltese</option>
<option value="mi">Maori</option>
<option value="mr">Marathi</option>
<option value="mn">Mongolian</option>
<option value="my">Myanmar (Burmese)</option>
<option value="ne">Nepali</option>
<option value="no">Norwegian</option>
<option value="or">Odia (Oriya)</option>
<option value="ps">Pashto</option>
<option value="fa">Persian</option>
<option value="pl">Polish</option>
<option value="pt">Portuguese</option>
<option value="pa">Punjabi</option>
<option value="ro">Romanian</option>
<option value="ru">Russian</option>
<option value="sm">Samoan</option>
<option value="gd">Scots Gaelic</option>
<option value="sr">Serbian</option>
<option value="st">Sesotho</option>
<option value="sn">Shona</option>
<option value="sd">Sindhi</option>
<option value="si">Sinhala</option>
<option value="sk">Slovak</option>
<option value="sl">Slovenian</option>
<option value="so">Somali</option>
<option value="es">Spanish</option>
<option value="su">Sundanese</option>
<option value="sw">Swahili</option>
<option value="sv">Swedish</option>
<option value="tg">Tajik</option>
<option value="ta">Tamil</option>
<option value="tt">Tatar</option>
<option value="te">Telugu</option>
<option value="th">Thai</option>
<option value="tr">Turkish</option>
<option value="tk">Turkmen</option>
<option value="uk">Ukrainian</option>
<option value="ur">Urdu</option>
<option value="ug">Uyghur</option>
<option value="uz">Uzbek</option>
<option value="vi">Vietnamese</option>
<option value="cy">Welsh</option>
<option value="xh">Xhosa</option>
<option value="yi">Yiddish</option>
<option value="yo">Yoruba</option>
<option value="zu">Zulu</option></select>	
	</div>
Powered by <span style="white-space:nowrap"><a class="goog-logo-link" href="https://translate.google.com" target="_blank"><img src="https://www.gstatic.com/images/branding/googlelogo/1x/googlelogo_color_42x16dp.png" width="37px" height="14px" style="padding-right: 5px" alt="Google Translate">Translate</a></span></div></div>
<script>function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en', autoDisplay: false}, 'google_translate_element2');}</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script><style>
a.gtflag {background-image:url('/modules/contrib/gtranslate/gtranslate-files/16a.png');}
a.gtflag:hover {background-image:url('/modules/contrib/gtranslate/gtranslate-files/16.png');}
</style><!--<a href="javascript:doGTranslate('en|en')" title="English" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-0px -0px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="English"></a> <a href="javascript:doGTranslate('en|nl')" title="Dutch" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-0px -100px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="Dutch"></a> <a href="javascript:doGTranslate('en|fr')" title="French" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-200px -100px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="French"></a> <a href="javascript:doGTranslate('en|de')" title="German" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-300px -100px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="German"></a> <a href="javascript:doGTranslate('en|it')" title="Italian" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-600px -100px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="Italian"></a> <a href="javascript:doGTranslate('en|pt')" title="Portuguese" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-300px -200px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="Portuguese"></a> <a href="javascript:doGTranslate('en|ru')" title="Russian" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-500px -200px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="Russian"></a> <a href="javascript:doGTranslate('en|es')" title="Spanish" class="gtflag" style="font-size:16px;padding:1px 0;background-repeat:no-repeat;background-position:-600px -200px;"><img src="/modules/contrib/gtranslate/gtranslate-files/blank.png" height="16" width="16" style="border:0;vertical-align:top;" alt="Spanish"></a>-->
	

<select onchange="doGTranslate(this);" id="gtranslate_selector" class="notranslate" aria-label="Website Language Selector" align="right">
		<option value="">Select Language</option>
		<option value="en|en" style="font-weight:bold;background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -0px;padding-left:18px;">English</option>
		<option value="en|af" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -688px;padding-left:18px;">Afrikaans</option>
		<option value="en|sq" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -560px;padding-left:18px;">Albanian</option>
		<option value="en|ar" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -16px;padding-left:18px;">Arabic</option>
		<option value="en|hy" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -832px;padding-left:18px;">Armenian</option>
		<option value="en|az" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -848px;padding-left:18px;">Azerbaijani</option>
		<option value="en|eu" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -864px;padding-left:18px;">Basque</option>
		<option value="en|be" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -768px;padding-left:18px;">Belarusian</option>
		<option value="en|bn" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -928px;padding-left:18px;">Bengali</option>
		<option value="en|bs" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -944px;padding-left:18px;">Bosnian</option>
		<option value="en|bg" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -32px;padding-left:18px;">Bulgarian</option>
		<option value="en|ca" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -384px;padding-left:18px;">Catalan</option>
		<option value="en|ceb" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -960px;padding-left:18px;">Cebuano</option>
		<option value="en|zh-CN" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -48px;padding-left:18px;">Chinese (Simplified)</option>
		<option value="en|zh-TW" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -64px;padding-left:18px;">Chinese (Traditional)</option>
		<option value="en|hr" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -80px;padding-left:18px;">Croatian</option>
		<option value="en|cs" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -96px;padding-left:18px;">Czech</option>
		<option value="en|da" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -112px;padding-left:18px;">Danish</option>
		<option value="en|nl" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -128px;padding-left:18px;">Dutch</option>
		<option value="en|eo" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -976px;padding-left:18px;">Esperanto</option>
		<option value="en|et" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -576px;padding-left:18px;">Estonian</option>
		<option value="en|tl" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -400px;padding-left:18px;">Filipino</option>
		<option value="en|fi" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -144px;padding-left:18px;">Finnish</option>
		<option value="en|fr" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -160px;padding-left:18px;">French</option>
		<option value="en|gl" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -592px;padding-left:18px;">Galician</option>
		<option value="en|ka" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -880px;padding-left:18px;">Georgian</option>
		<option value="en|de" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -176px;padding-left:18px;">German</option>
		<option value="en|el" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -192px;padding-left:18px;">Greek</option>
		<option value="en|gu" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -992px;padding-left:18px;">Gujarati</option>
		<option value="en|ht" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -896px;padding-left:18px;">Haitian Creole</option>
		<option value="en|ha" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1008px;padding-left:18px;">Hausa</option>
		<option value="en|iw" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -416px;padding-left:18px;">Hebrew</option>
		<option value="en|hi" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -208px;padding-left:18px;">Hindi</option>
		<option value="en|hmn" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1024px;padding-left:18px;">Hmong</option>
		<option value="en|hu" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -608px;padding-left:18px;">Hungarian</option>
		<option value="en|is" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -784px;padding-left:18px;">Icelandic</option>
		<option value="en|ig" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1040px;padding-left:18px;">Igbo</option>
		<option value="en|id" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -432px;padding-left:18px;">Indonesian</option>
		<option value="en|ga" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -736px;padding-left:18px;">Irish</option>
		<option value="en|it" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -224px;padding-left:18px;">Italian</option>
		<option value="en|ja" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -240px;padding-left:18px;">Japanese</option>
		<option value="en|jw" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1056px;padding-left:18px;">Javanese</option>
		<option value="en|kn" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1072px;padding-left:18px;">Kannada</option>
		<option value="en|km" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1088px;padding-left:18px;">Khmer</option>
		<option value="en|ko" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -256px;padding-left:18px;">Korean</option>
		<option value="en|lo" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1104px;padding-left:18px;">Lao</option>
		<option value="en|la" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1120px;padding-left:18px;">Latin</option>
		<option value="en|lv" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -448px;padding-left:18px;">Latvian</option>
		<option value="en|lt" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -464px;padding-left:18px;">Lithuanian</option>
		<option value="en|mk" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -800px;padding-left:18px;">Macedonian</option>
		<option value="en|ms" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -704px;padding-left:18px;">Malay</option>
		<option value="en|mt" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -624px;padding-left:18px;">Maltese</option>
		<option value="en|mi" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1136px;padding-left:18px;">Maori</option>
		<option value="en|mr" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1152px;padding-left:18px;">Marathi</option>
		<option value="en|mn" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1168px;padding-left:18px;">Mongolian</option>
		<option value="en|ne" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1184px;padding-left:18px;">Nepali</option>
		<option value="en|no" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -272px;padding-left:18px;">Norwegian</option>
		<option value="en|fa" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -672px;padding-left:18px;">Persian</option>
		<option value="en|pl" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -288px;padding-left:18px;">Polish</option>
		<option value="en|pt" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -304px;padding-left:18px;">Portuguese</option>
		<option value="en|pa" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1200px;padding-left:18px;">Punjabi</option>
		<option value="en|ro" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -320px;padding-left:18px;">Romanian</option>
		<option value="en|ru" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -336px;padding-left:18px;">Russian</option>
		<option value="en|sr" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -480px;padding-left:18px;">Serbian</option>
		<option value="en|sk" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -496px;padding-left:18px;">Slovak</option>
		<option value="en|sl" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -512px;padding-left:18px;">Slovenian</option>
		<option value="en|so" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1216px;padding-left:18px;">Somali</option>
		<option value="en|es" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -352px;padding-left:18px;">Spanish</option>
		<option value="en|sw" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -720px;padding-left:18px;">Swahili</option>
		<option value="en|sv" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -368px;padding-left:18px;">Swedish</option>
		<option value="en|ta" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1232px;padding-left:18px;">Tamil</option>
		<option value="en|te" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1248px;padding-left:18px;">Telugu</option>
		<option value="en|th" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -640px;padding-left:18px;">Thai</option>
		<option value="en|tr" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -656px;padding-left:18px;">Turkish</option>
		<option value="en|uk" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -528px;padding-left:18px;">Ukrainian</option>
		<option value="en|ur" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -912px;padding-left:18px;">Urdu</option>
		<option value="en|vi" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -544px;padding-left:18px;">Vietnamese</option>
		<option value="en|cy" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -752px;padding-left:18px;">Welsh</option>
		<option value="en|yi" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -816px;padding-left:18px;">Yiddish</option>
		<option value="en|yo" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1264px;padding-left:18px;">Yoruba</option>
		<option value="en|zu" style="background:url('/modules/contrib/gtranslate/gtranslate-files/16l.png') no-repeat scroll 0 -1280px;padding-left:18px;">Zulu</option>
	</select>
</div>



	
<center>

  </div>

  </div>

  </div>

<center>
<br>
<table border="0" cellpadding="1">
<tr>
<td><img src="APA_logo.png" ></img></td>
	
	
	
 <!--<td><img src="{{Profile.ImageSrc}}" class="img-circle" style="width:60px;height:60px;"></img></td>-->
 <td><strong>Welcome to the membership Portal for the Association of Professional Administrators: Salem State Chapter</strong>

</td>
 </tr>
 </table>
</center>
</div>
  </div>

  </div>

  </div>	
</head>

<body>
  
     <center>

    <div class="wrapper">
		<br>
        <br>
		<h2>Password Reset:</h2>
        <p>Please enter login credentials.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
		<table style="width:auto" class="center">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <tr><td> <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>   </td></tr> 
          <tr><td>    <div class="form-group">
              <label>Email:</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div></td></tr>
            <div class="form-group">
             <tr><td>   <input type="submit" class="btn btn-primary" value="Reset Password">
			 <a href="Login.php" class="btn btn-secondary ml-2">Cancel</a>
            </div></td></tr> 
			</form> </table></center> </header>
    </div>
</body>
</html>