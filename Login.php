<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $IsAdmin = $firstname = $lastname = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT p.id, u.User_Name_First, u.User_Name_Last,a.User_admin_effdt, p.user_id, p.user_password FROM User_Password p left join User u on u.id = p.id 
left join User_Admin a on p.id = a.id

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
                    mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname, $IsAdmin, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
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
                            header("location: Welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
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

    <title>Update Address</title>
    <link rel="stylesheet" media="all" href="/sites/default/files/css/css_d-1tZHzkr7xOZPiR4KtU_mnkuiKCGYEV9ab8FK2md9k.css">
<link rel="stylesheet" media="all" href="/webform/css/newsletter_webform?r3gnm2">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_1WUJ2M294DQx5H2eH7RlQLSlzPdKefrhLvm74Ac_IHo.css">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_uMLXRqj8oiKfaVlMJHgY0GlWN6CE1J9Bl8aaz2eEMqw.css">
<link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;display=swap">
<link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Merriweather:400,700,900&amp;display=swap">
<link rel="stylesheet" media="all" href="/sites/default/files/css/css_5dMDjxM_GhJLXJmCzYesb9Fdh4E9nPO-kgXUOcbjUic.css">

    
  <script data-dapp-detection="">!function(){let e=!1;function n(){if(!e){const n=document.createElement("meta");n.name="dapp-detected",document.head.appendChild(n),e=!0}}if(window.hasOwnProperty("ethereum")){if(window.__disableDappDetectionInsertion=!0,void 0===window.ethereum)return;n()}else{var t=window.ethereum;Object.defineProperty(window,"ethereum",{configurable:!0,enumerable:!1,set:function(e){window.__disableDappDetectionInsertion||n(),t=e},get:function(){if(!window.__disableDappDetectionInsertion){const e=arguments.callee;e&&e.caller&&e.caller.toString&&-1!==e.caller.toString().indexOf("getOwnPropertyNames")||n()}return t}})}}();</script><link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css"><script type="text/javascript" charset="UTF-8" src="https://translate.googleapis.com/_/translate_http/_/js/k=translate_http.tr.en_US.5ry4TwO4tFM.O/am=AQ/d=1/exm=el_conf/ed=1/rs=AN8SPfoLubijnObGZYRJqTH9fQ8LHAJBiA/m=el_main"></script><style type="text/css">.fl-progEnhance-basic, .fl-ProgEnhance-basic { display: none; } .fl-progEnhance-enhanced, .fl-ProgEnhance-enhanced { display: block; }</style></head>
 <center>
<table border="0" cellpadding="15">
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
  <!--<button role="button" id="translateButton" aria-expanded="false" aria-controls="gtranslateContainer">Translate to...</button> -->

<!--<div class="layout-container">

  <header id="navbar" role="banner" class="navbar">
    <div class="navbar-header">
        <div class="region region-nav-header">
    <div id="block-rtf-branding" class="block block-system block-system-branding-block">
  
    
        <a href="/" rel="home" class="site-logo">
      <img src="/sites/default/files/logo.png" alt="Home">
    </a>
      </div>

  </div>-->

    <!--  <button class="navbar-toggler" type="button" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="visually-hidden">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>-->

    	  	


  

  

  
     <center>

    <div class="wrapper">
        <h2>Login</h2>
        <p>Please enter login credentials </p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
		<table style="width:auto" class="center">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <tr><td> <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>   </td></tr> 
          <tr><td>    <div class="form-group">
              <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div></td></tr>
            <div class="form-group">
             <tr><td>   <input type="submit" class="btn btn-primary" value="Login"></td></tr>
            </div>
            <tr><td><p>Don't have an account? <a href="Register.php">Sign up now</a>.</p></td></tr>
			</form> </table></center> </header>
    </div>
</body>
</html>
