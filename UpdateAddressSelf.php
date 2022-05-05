<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
}
?>

<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Address_Street1 = $Address_Street2 = $Address_City = $Address_Zip = $Address_State = $Address_Email = $Address_Phone ="";
$Address_Street1_err = $Address_Street2_err = $Address_City_err = $Address_State_err = $Address_Zip_err = $Address_Email_err = $Address_Phone_err = "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    

    
    // Validate Terminationdate Terminationdate
    $input_Address_Street1 = trim($_POST["Address_Street1"]);
    if(empty($input_Address_Street1)){
        $Address_Street1_err = "Please enter an Address_Street1.";     
    } else{
        $Address_Street1 = $input_Address_Street1;
    }
        $input_Address_Street2 = trim($_POST["Address_Street2"]);

        $Address_Street2 = $input_Address_Street2;

        $input_Address_City = trim($_POST["Address_City"]);
    if(empty($input_Address_City)){
        $Address_City_err = "Please enter an Address_City.";     
    } else{
        $Address_City = $input_Address_City;
    }
	  
        $input_Address_State = trim($_POST["Address_State"]);
    if(empty($input_Address_State)){
        $Address_State_err = "Please enter an Address_State.";     
    } else{
        $Address_State = $input_Address_State;
    }
	    $input_Address_Zip = trim($_POST["Address_Zip"]);
    if(empty($input_Address_Zip)){
        $Address_Zip_err = "Please enter an Address_Zip.";     
    } else{
        $Address_Zip = $input_Address_Zip;
    }
        $input_Address_Email = trim($_POST["Address_Email"]);
    if(empty($input_Address_Email)){
        $Address_Email_err = "Please enter an Address_Email.";     
    } else{
        $Address_Email = $input_Address_Email;
    } 
	        $input_Address_Phone = trim($_POST["Address_Phone"]);
    if(empty($input_Address_Phone)){
        $Address_Phone_err = "";     
		$Address_Phone_err = "Please enter an Address_Phone.";     

    } else{
        $Address_Phone = $input_Address_Phone;
    } 
	//$input_Address_Phone = trim($_POST["Address_Phone"]);
	//$User_Address_Phone = $input_Address_Phone;
    // Check input errors before inserting in database
    if(empty($Address_Street1_err) && empty($Address_Street2_err) && empty($Address_City_err) && empty($Address_Zip_err) && empty($Address_State_err) && empty($Address_Email_err)){
        // Prepare an update statement
        //$sql = "UPDATE User SET User_Effdt=now(), Address_Street1=?,Address_Street2=? WHERE id=?";
        $sql = "UPDATE Address SET 
		Address_effdt=now(), 
		Address_street1=?,	
		Address_street2=?,	
		Address_city=?,		
		Address_state=?,
		Address_zip=?,		
		Address_email=?,	
		Address_phone=?	
		WHERE id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "ssi",  $param_Address_Street1, $param_Address_Street2, $param_id);
            mysqli_stmt_bind_param($stmt, "sssssssi", 
			$param_Address_Street1,
			$param_Address_Street2,
			$param_Address_City,
			$param_Address_State,
			$param_Address_Zip,
			$param_Address_Email,
			$param_Address_Phone,
			$param_id);
            // Set parameters
            //$param_Address_Street1 = $Address_Street1;
            //$param_Address_Street2 = $Address_Street2;
            //$param_id = $id;
			
			$param_Address_Street1 = $Address_Street1;
			$param_Address_Street2 = $Address_Street2;
			$param_Address_City = $Address_City;
			$param_Address_State = $Address_State;
			$param_Address_Zip = $Address_Zip;
			$param_Address_Email = $Address_Email;
			$param_Address_Phone = $Address_Phone;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: Welcome.php");
                exit();
            } else{
                echo "1st Oops! Something went wrong. Please try again later.";

            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM MembershipAddress WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
					$User_Name_First=$row["User_Name_First"];
					$User_Name_Last=$row["User_Name_Last"];
				    $Address_Street1=$row["Address_street1"];
					$Address_Street2=$row["Address_street2"];
					$Address_City=$row["Address_city"];
					$Address_State=$row["Address_state"];
					$Address_Zip=$row["Address_zip"];
					$Address_Email=$row["Address_email"];
					$Address_Phone=$row["Address_phone"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "2nd Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>APA - Update Address</title>
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
	<div class="topnav">
	<?php if (empty($_SESSION["IsAdmin"])) {

} else
{
echo "<a class=active href=WelcomeAdmin.php>Admin</a>";
}; ?>
	<a href="Welcome.php">Home</a>
<a href="Profile.php?id=<?php echo htmlspecialchars($_SESSION["id"]); ?>" class="mr-3" title="Profile" data-toggle="tooltip">Profile</a>
	<a href="Contact.php">Contact</a>
	<a href="logout.php">Sign Out</a>
	
	</div>
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
 <td>Welcome, <strong><?php echo htmlspecialchars($_SESSION["firstname"]); ?> <?php echo htmlspecialchars($_SESSION["lastname"]); ?></strong>
<br>Your username is: <?php echo htmlspecialchars($_SESSION["username"]); ?>
</td>
 </tr>
 </table>
</center>
</div>
  </div>

  </div>

  </div>	
</head>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
													
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Address: <?php echo $User_Name_First; ?>  <?php echo $User_Name_Last; ?></h2>
                    <p>Please complete the required address information for the user.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Street Address:</label>
                            <input type="Text" name="Address_Street1" placeholder="352 Lafayette St." required class="form-control <?php echo (!empty($Address_Street1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Address_Street1; ?>">
                            <span class="invalid-feedback"><?php echo $Address_Street1_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Street Address2:</label>
                            <input type="Text" name="Address_Street2" placeholder="Stanley Building" class="form-control <?php echo (!empty($Address_Street2_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Address_Street2; ?>">
                            <span class="invalid-feedback"><?php echo $Address_Street2_err;?></span>
                        </div>
						<div class="form-group">
                            <label>City:</label>
                            <input type="Text" name="Address_City" placeholder="Salem"required class="form-control <?php echo (!empty($Address_City_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Address_City; ?>">
                            <span class="invalid-feedback"><?php echo $Address_City_err;?></span>
                        </div>
						<div class="form-group">
                            <label>State:</label>

                            <select name="Address_State" required class="form-control" <?php echo (!empty($Address_State_err)) ? 'is-invalid' : ''; ?>value="<?php echo $Address_State; ?>" >
								<option value = "" disabled selected>Select your State</option>
								<option value = "AZ"<?php if ($Address_State == 'AZ') { echo 'selected'; } ?>>AZ</option>
								<option value = "AR"<?php if ($Address_State == 'AR') { echo 'selected'; } ?>>AR</option>
								<option value = "CA"<?php if ($Address_State == 'CA') { echo 'selected'; } ?>>CA</option>
								<option value = "CZ"<?php if ($Address_State == 'CZ') { echo 'selected'; } ?>>CZ</option>
								<option value = "CO"<?php if ($Address_State == 'CO') { echo 'selected'; } ?>>CO</option>
								<option value = "CT"<?php if ($Address_State == 'CT') { echo 'selected'; } ?>>CT</option>
								<option value = "DE"<?php if ($Address_State == 'DE') { echo 'selected'; } ?>>DE</option>
								<option value = "DC"<?php if ($Address_State == 'DC') { echo 'selected'; } ?>>DC</option>
								<option value = "FL"<?php if ($Address_State == 'FL') { echo 'selected'; } ?>>FL</option>
								<option value = "GA"<?php if ($Address_State == 'GA') { echo 'selected'; } ?>>GA</option>
								<option value = "GU"<?php if ($Address_State == 'GU') { echo 'selected'; } ?>>GU</option>
								<option value = "HI"<?php if ($Address_State == 'HI') { echo 'selected'; } ?>>HI</option>
								<option value = "ID"<?php if ($Address_State == 'ID') { echo 'selected'; } ?>>ID</option>
								<option value = "IL"<?php if ($Address_State == 'IL') { echo 'selected'; } ?>>IL</option>
								<option value = "IN"<?php if ($Address_State == 'IN') { echo 'selected'; } ?>>IN</option>
								<option value = "IA"<?php if ($Address_State == 'IA') { echo 'selected'; } ?>>IA</option>
								<option value = "KS"<?php if ($Address_State == 'KS') { echo 'selected'; } ?>>KS</option>
								<option value = "KY"<?php if ($Address_State == 'KY') { echo 'selected'; } ?>>KY</option>
								<option value = "LA"<?php if ($Address_State == 'LA') { echo 'selected'; } ?>>LA</option>
								<option value = "ME"<?php if ($Address_State == 'ME') { echo 'selected'; } ?>>ME</option>
								<option value = "MD"<?php if ($Address_State == 'MD') { echo 'selected'; } ?>>MD</option>
								<option value = "MA"<?php if ($Address_State == 'MA') { echo 'selected'; } ?>>MA</option>
								<option value = "MI"<?php if ($Address_State == 'MI') { echo 'selected'; } ?>>MI</option>
								<option value = "MN"<?php if ($Address_State == 'MN') { echo 'selected'; } ?>>MN</option>
								<option value = "MS"<?php if ($Address_State == 'MS') { echo 'selected'; } ?>>MS</option>
								<option value = "MO"<?php if ($Address_State == 'MO') { echo 'selected'; } ?>>MO</option>
								<option value = "MT"<?php if ($Address_State == 'MT') { echo 'selected'; } ?>>MT</option>
								<option value = "NE"<?php if ($Address_State == 'NE') { echo 'selected'; } ?>>NE</option>
								<option value = "NV"<?php if ($Address_State == 'NV') { echo 'selected'; } ?>>NV</option>
								<option value = "NH"<?php if ($Address_State == 'NH') { echo 'selected'; } ?>>NH</option>
								<option value = "NJ"<?php if ($Address_State == 'NJ') { echo 'selected'; } ?>>NJ</option>
								<option value = "NM"<?php if ($Address_State == 'NM') { echo 'selected'; } ?>>NM</option>
								<option value = "NY"<?php if ($Address_State == 'NY') { echo 'selected'; } ?>>NY</option>
								<option value = "NC"<?php if ($Address_State == 'NC') { echo 'selected'; } ?>>NC</option>
								<option value = "ND"<?php if ($Address_State == 'ND') { echo 'selected'; } ?>>ND</option>
								<option value = "OH"<?php if ($Address_State == 'OH') { echo 'selected'; } ?>>OH</option>
								<option value = "OK"<?php if ($Address_State == 'OK') { echo 'selected'; } ?>>OK</option>
								<option value = "OR"<?php if ($Address_State == 'OR') { echo 'selected'; } ?>>OR</option>
								<option value = "PA"<?php if ($Address_State == 'PA') { echo 'selected'; } ?>>PA</option>
								<option value = "PR"<?php if ($Address_State == 'PR') { echo 'selected'; } ?>>PR</option>
								<option value = "RI"<?php if ($Address_State == 'RI') { echo 'selected'; } ?>>RI</option>
								<option value = "SC"<?php if ($Address_State == 'SC') { echo 'selected'; } ?>>SC</option>
								<option value = "SD"<?php if ($Address_State == 'SD') { echo 'selected'; } ?>>SD</option>
								<option value = "TN"<?php if ($Address_State == 'TN') { echo 'selected'; } ?>>TN</option>
								<option value = "TX"<?php if ($Address_State == 'TX') { echo 'selected'; } ?>>TX</option>
								<option value = "UT"<?php if ($Address_State == 'UT') { echo 'selected'; } ?>>UT</option>
								<option value = "VT"<?php if ($Address_State == 'VT') { echo 'selected'; } ?>>VT</option>
								<option value = "VI"<?php if ($Address_State == 'VI') { echo 'selected'; } ?>>VI</option>
								<option value = "VA"<?php if ($Address_State == 'VA') { echo 'selected'; } ?>>VA</option>
								<option value = "WA"<?php if ($Address_State == 'WA') { echo 'selected'; } ?>>WA</option>
								<option value = "WV"<?php if ($Address_State == 'WV') { echo 'selected'; } ?>>WV</option>
								<option value = "WI"<?php if ($Address_State == 'WI') { echo 'selected'; } ?>>WI</option>
								<option value = "WY"<?php if ($Address_State == 'WY') { echo 'selected'; } ?>>WY</option>

								</select>
							<span class="invalid-feedback"><?php echo $Address_State_err;?></span>
                        </div>
												<div class="form-group">
                            <label>Zip:</label>
                            <input type="Text" name="Address_Zip" inputmode="numeric" placeholder="01970-0000"pattern="^(?(^00000(|-0000))|(\d{5}(|-\d{4})))$" required class="form-control  <?php echo (!empty($Address_Zip_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Address_Zip; ?>">
                            <span class="invalid-feedback"><?php echo $Address_Zip_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="Address_Email" placeholder="testuser@salemstate.edu" required class="form-control  <?php echo (!empty($Address_Email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Address_Email; ?>">
                            <span class="invalid-feedback"><?php echo $Address_Email_err;?></span>
                        </div>
						
						<div class="form-group">
                            <label>Phone:</label>
                            <input type="Tel" name="Address_Phone" placeholder="555-555-5555" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required class="form-control"  value="<?php echo $Address_Phone; ?>">

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="Welcome.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>