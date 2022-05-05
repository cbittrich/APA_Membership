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
$User_Name_First = $User_Name_Last = $User_Position_State = $User_Position_SSU = $User_Position_IsContract = $User_Position_HireDate = $User_Position_Funding = $User_Position_Salary = $User_Position_APA = $User_Ethnicity = $User_BirthMonth = $User_BirthYear = $User_EdLevel = $User_MTANumber ="";
$User_Name_First_err = $User_Name_Last_err = $User_Position_State_err = $User_Position_IsContract_err = $User_Position_HireDate_err = $User_Position_Funding_err = $User_Position_Salary_err = $User_Position_APA_err ="";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    

    
    // Validate Terminationdate Terminationdate
    $input_User_Name_First = trim($_POST["User_Name_First"]);
    if(empty($input_User_Name_First)){
        $User_Name_First_err = "Please enter an User_Name_First.";     
    } else{
        $User_Name_First = $input_User_Name_First;
    }
        $input_User_Name_Last = trim($_POST["User_Name_Last"]);
    if(empty($input_User_Name_Last)){
        $User_Name_Last_err = "Please enter an User_Name_Last.";     
    } else{
        $User_Name_Last = $input_User_Name_Last;
    }
        $input_User_Position_State = trim($_POST["User_Position_State"]);
    if(empty($input_User_Position_State)){
        $User_Position_State_err = "Please enter an User_Position_State.";     
    } else{
        $User_Position_State = $input_User_Position_State;
    }
        $input_User_Position_SSU = trim($_POST["User_Position_SSU"]);
    if(empty($input_User_Position_SSU)){
        $User_Position_SSU_err = "Please enter an User_Position_SSU.";     
    } else{
        $User_Position_SSU = $input_User_Position_SSU;
    }	  
        $input_User_Position_IsContract = trim($_POST["User_Position_IsContract"]);
    if(empty($input_User_Name_Last)){
        $User_Position_IsContract_err = "Please enter an User_Position_IsContract.";     
    } else{
        $User_Position_IsContract = $input_User_Position_IsContract;
    }
        $input_User_Position_HireDate = trim($_POST["User_Position_HireDate"]);
    if(empty($input_User_Position_HireDate)){
        $User_Position_HireDate_err = "Please enter an User_Position_HireDate.";     
    } else{
        $User_Position_HireDate = $input_User_Position_HireDate;
    }
        $input_User_Position_Funding = trim($_POST["User_Position_Funding"]);
    if(empty($input_User_Position_Funding)){
        $User_Position_Funding_err = "Please enter an User_Position_Funding.";     
    } else{
        $User_Position_Funding = $input_User_Position_Funding;
    }
        $input_User_Position_Salary = trim($_POST["User_Position_Salary"]);
    if(empty($input_User_Position_Salary)){
        $User_Position_Salary_err = "Please enter an User_Position_Salary.";     
    } else{
        $User_Position_Salary = $input_User_Position_Salary;
    } 
        $input_User_Position_APA = trim($_POST["User_Position_APA"]);
    if(empty($input_User_Position_APA)){
        $User_Position_APA_err = "Please enter an User_Position_APA.";     
    } else{
        $User_Position_APA = $input_User_Position_APA;
    }  	
	$input_User_Ethnicity = trim($_POST["User_Ethnicity"]);
	$User_Ethnicity = $input_User_Ethnicity;
	$input_User_BirthMonth = trim($_POST["User_BirthMonth"]);
	$User_BirthMonth = $input_User_BirthMonth;
	$input_User_BirthYear = trim($_POST["User_BirthYear"]);
	$User_BirthYear = $input_User_BirthYear;
	
	$input_User_EdLevel = trim($_POST["User_EdLevel"]);
	$User_EdLevel = $input_User_EdLevel;
	
	$input_User_MTANumber = trim($_POST["User_MTANumber"]);
	$User_MTANumber = $input_User_MTANumber;
    // Check input errors before inserting in database
    if(empty($User_Name_First_err) && empty($User_Name_Last_err) && empty($User_Position_State_err) && empty($User_Position_SSU_err) && empty($User_Position_IsContract_err) && empty($User_Position_HireDate_err) && empty($User_Position_Funding_err) && empty($User_Position_Salary_err) && empty($User_Position_APA_err)){
        // Prepare an update statement
        //$sql = "UPDATE User SET User_Effdt=now(), User_Name_First=?,User_Name_Last=? WHERE id=?";
        $sql = "UPDATE User SET 
		User_Effdt=now(), 
		User_Name_First=?,	
		User_Name_Last=?,	
		User_Position_State=?,	
		User_Position_SSU=?,	
		User_Position_IsContract=?,	
		User_Position_HireDate=?,	
		User_Position_Funding=?,	
		User_Position_Salary=?,	
		User_Position_APA=?,
		User_Ethnicity=?,	
		User_BirthMonth=?,	
		User_BirthYear=?,	
		User_EdLevel=?,	
		User_MTANumber=?	
		WHERE id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "ssi",  $param_User_Name_First, $param_User_Name_Last, $param_id);
            mysqli_stmt_bind_param($stmt, "ssssssssssssssi", 
			$param_User_Name_First,
			$param_User_Name_Last,
			$param_User_Position_State,
			$param_User_Position_SSU,
			$param_User_Position_IsContract,
			$param_User_Position_HireDate,
			$param_User_Position_Funding,
			$param_User_Position_Salary,
			$param_User_Position_APA,
			$param_User_Ethnicity,
			$param_User_BirthMonth,
			$param_User_BirthYear,
			$param_User_EdLevel,
			$param_User_MTANumber,
			$param_id);
            // Set parameters
            //$param_User_Name_First = $User_Name_First;
            //$param_User_Name_Last = $User_Name_Last;
            //$param_id = $id;
			
			$param_User_Name_First = $User_Name_First;
			$param_User_Name_Last = $User_Name_Last;
			$param_User_Position_State = $User_Position_State;
			$param_User_Position_SSU = $User_Position_SSU;
			$param_User_Position_IsContract = $User_Position_IsContract;
			$param_User_Position_HireDate = $User_Position_HireDate;
			$param_User_Position_Funding = $User_Position_Funding;
			$param_User_Position_Salary = $User_Position_Salary;
			$param_User_Position_APA = $User_Position_APA;
			$param_User_Ethnicity = $User_Ethnicity;
			$param_User_BirthMonth = $User_BirthMonth;
			$param_User_BirthYear = $User_BirthYear;
			$param_User_EdLevel = $User_EdLevel;
			$param_User_MTANumber = $User_MTANumber;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ViewEmployeeRoster.php");
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
        $sql = "SELECT * FROM User WHERE id = ?";
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
					$User_Position_State=$row["User_Position_State"];
					$User_Position_SSU=$row["User_Position_SSU"];
					$User_Position_IsContract=$row["User_Position_IsContract"];
					$User_Position_HireDate=$row["User_Position_HireDate"];
					$User_Position_Funding=$row["User_Position_Funding"];
					$User_Position_Salary=$row["User_Position_Salary"];
					$User_Position_APA=$row["User_Position_APA"];
					$User_Ethnicity=$row["User_Ethnicity"];
					$User_BirthMonth=$row["User_BirthMonth"];
					$User_BirthYear=$row["User_BirthYear"];
					$User_EdLevel=$row["User_EdLevel"];
					$User_MTANumber=$row["User_MTANumber"];
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

<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head> -->
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
    <title>APA - Update Employee Record:</title>
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
                    <h2 class="mt-5">Update Employee: <?php echo $User_Name_First; ?>  <?php echo $User_Name_Last; ?></h2>
                    <p>Enter data for updating employee position.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="Text" name="User_Name_First" required class="form-control <?php echo (!empty($User_Name_First_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Name_First; ?>">
                            <span class="invalid-feedback"><?php echo $User_Name_First_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Last Name:</label>
                            <input type="Text" name="User_Name_Last" required class="form-control <?php echo (!empty($User_Name_Last_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Name_Last; ?>">
                            <span class="invalid-feedback"><?php echo $User_Name_Last_err;?></span>
                        </div>
						<div class="form-group">
                            <label>State Job Title:</label>
                            <input type="Text" name="User_Position_State" required class="form-control <?php echo (!empty($User_Position_State_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Position_State; ?>">
                            <span class="invalid-feedback"><?php echo $User_Position_State_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Salem State Job Title:</label>
                            <input type="Text" name="User_Position_SSU" required class="form-control <?php echo (!empty($User_Position_SSU_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Position_SSU; ?>">
                            <span class="invalid-feedback"><?php echo $User_Position_SSU_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Is Contract?:</label>
                            <select name="User_Position_IsContract" required class="form-control">
							<option value = "" disabled selected>Was a contract offered?</option>							
                            <option value="Y"<?php if ($User_Position_IsContract == 'Y') { echo 'selected'; } ?>>Yes</option>
							<option value="N"<?php if ($User_Position_IsContract == 'N') { echo 'selected'; } ?>>No</option>
							</select>
							<span class="invalid-feedback"><?php echo $User_Position_IsContract_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Hire Date:</label>
                            <input type="Date" name="User_Position_HireDate" required class="form-control <?php echo (!empty($User_Position_HireDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Position_HireDate; ?>">
                            <span class="invalid-feedback"><?php echo $User_Position_HireDate_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Position Funding:</label>
                            <select name="User_Position_Funding" required class="form-control">
								<option value = "" disabled selected>Select Funding Source</option>
								<option value="Trust Fund"<?php if ($User_Position_Funding == 'Trust Fund') { echo 'selected'; } ?>>Trust Fund</option>
								<option value="State Appropriated"<?php if ($User_Position_Funding == 'State Appropriated') { echo 'selected'; } ?>>State Appropriated</option>
								<option value="Federal Grant"<?php if ($User_Position_Funding == 'Federal Grant') { echo 'selected'; } ?>>Federal Grant</option>
								<option value="Other"<?php if ($User_Position_Funding == 'Other') { echo 'selected'; } ?>>Other</option>
								</select>
							<span class="invalid-feedback"><?php echo $User_Position_Funding_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Position Salary:</label>
                            <input type="Currency" name="User_Position_Salary" required class="form-control <?php echo (!empty($User_Position_Salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $User_Position_Salary; ?>">
                            <span class="invalid-feedback"><?php echo $User_Position_Salary_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Union Position (APA):</label>
                            <select name="User_Position_APA" required class="form-control">
								<option value = "" disabled selected>Select Union Position Level</option>
								<option value="Staff Assistant"<?php if ($User_Position_APA == 'Staff Assistant') { echo 'selected'; } ?>>Staff Assistant</option>
								<option value="Staff Associate"<?php if ($User_Position_APA == 'Staff Associate') { echo 'selected'; } ?>>Staff Associate</option>
								<option value="Assistant Director"<?php if ($User_Position_APA == 'Assistant Director') { echo 'selected'; } ?>>Assistant Director</option>
								<option value="Associate Director"<?php if ($User_Position_APA == 'Associate Director') { echo 'selected'; } ?>>Associate Director</option>
								<option value="Assistant Dean"<?php if ($User_Position_APA == 'Assistant Dean') { echo 'selected'; } ?>>Assistant Dean</option>  
								<option value="Director"<?php if ($User_Position_APA == 'Director') { echo 'selected'; } ?>>Director</option>
								<option value="Executive Director"<?php if ($User_Position_APA == 'Executive Director') { echo 'selected'; } ?>>Executive Director</option>
								<option value="Acting Position"<?php if ($User_Position_APA == 'Acting Position') { echo 'selected'; } ?>>Acting Position</option>
								</select>
							<span class="invalid-feedback"><?php echo $User_Position_APA_err;?></span>
                        </div>
						<div class="form-group">
                            <label>Ethnicity:</label>
                            <select name="User_Ethnicity" class="form-control">
							<option value = "" disabled selected>Select Ethnicity</option>
							<option value = "Hispanic"<?php if ($User_Ethnicity == 'Hispanic') { echo 'selected'; } ?>>Hispanic</option>
							<option value = "Not Hispanic"<?php if ($User_Ethnicity == 'Not Hispanic') { echo 'selected'; } ?>>Not Hispanic</option>
							</select>
                        </div>
						<div class="form-group">
                            <label>Birth Month:</label>
                            <select name="User_BirthMonth" class="form-control">
							<option value = "" disabled selected>Employee Birth month?</option>
							<option value = "01"<?php if ($User_BirthMonth == '01') { echo 'selected'; } ?>>01</option>
							<option value = "02"<?php if ($User_BirthMonth == '02') { echo 'selected'; } ?>>02</option>
							<option value = "03"<?php if ($User_BirthMonth == '03') { echo 'selected'; } ?>>03</option>
							<option value = "04"<?php if ($User_BirthMonth == '04') { echo 'selected'; } ?>>04</option>
							<option value = "05"<?php if ($User_BirthMonth == '05') { echo 'selected'; } ?>>05</option>
							<option value = "06"<?php if ($User_BirthMonth == '06') { echo 'selected'; } ?>>06</option>
							<option value = "07"<?php if ($User_BirthMonth == '07') { echo 'selected'; } ?>>07</option>
							<option value = "08"<?php if ($User_BirthMonth == '08') { echo 'selected'; } ?>>08</option>
							<option value = "09"<?php if ($User_BirthMonth == '09') { echo 'selected'; } ?>>09</option>
							<option value = "10"<?php if ($User_BirthMonth == '10') { echo 'selected'; } ?>>10</option>
							<option value = "11"<?php if ($User_BirthMonth == '11') { echo 'selected'; } ?>>11</option>
							<option value = "12"<?php if ($User_BirthMonth == '12') { echo 'selected'; } ?>>12</option>
							</select>

                        </div>
						<div class="form-group">
                            <label>Birth Year:</label>
                            <select name="User_BirthYear" class="form-control">
							<option value = "" disabled selected>Employee Birth day?</option>
							<option value = "1945"<?php if ($User_BirthYear == '1945') { echo 'selected'; } ?>>1945</option>
							<option value = "1946"<?php if ($User_BirthYear == '1946') { echo 'selected'; } ?>>1946</option>
							<option value = "1947"<?php if ($User_BirthYear == '1947') { echo 'selected'; } ?>>1947</option>
							<option value = "1948"<?php if ($User_BirthYear == '1948') { echo 'selected'; } ?>>1948</option>
							<option value = "1949"<?php if ($User_BirthYear == '1949') { echo 'selected'; } ?>>1949</option>
							<option value = "1950"<?php if ($User_BirthYear == '1950') { echo 'selected'; } ?>>1950</option>
							<option value = "1951"<?php if ($User_BirthYear == '1951') { echo 'selected'; } ?>>1951</option>
							<option value = "1952"<?php if ($User_BirthYear == '1952') { echo 'selected'; } ?>>1952</option>
							<option value = "1953"<?php if ($User_BirthYear == '1953') { echo 'selected'; } ?>>1953</option>
							<option value = "1954"<?php if ($User_BirthYear == '1954') { echo 'selected'; } ?>>1954</option>
							<option value = "1955"<?php if ($User_BirthYear == '1955') { echo 'selected'; } ?>>1955</option>
							<option value = "1956"<?php if ($User_BirthYear == '1956') { echo 'selected'; } ?>>1956</option>
							<option value = "1957"<?php if ($User_BirthYear == '1957') { echo 'selected'; } ?>>1957</option>
							<option value = "1958"<?php if ($User_BirthYear == '1958') { echo 'selected'; } ?>>1958</option>
							<option value = "1959"<?php if ($User_BirthYear == '1959') { echo 'selected'; } ?>>1959</option>
							<option value = "1960"<?php if ($User_BirthYear == '1960') { echo 'selected'; } ?>>1960</option>
							<option value = "1961"<?php if ($User_BirthYear == '1961') { echo 'selected'; } ?>>1961</option>
							<option value = "1962"<?php if ($User_BirthYear == '1962') { echo 'selected'; } ?>>1962</option>
							<option value = "1963"<?php if ($User_BirthYear == '1963') { echo 'selected'; } ?>>1963</option>
							<option value = "1964"<?php if ($User_BirthYear == '1964') { echo 'selected'; } ?>>1964</option>
							<option value = "1965"<?php if ($User_BirthYear == '1965') { echo 'selected'; } ?>>1965</option>
							<option value = "1966"<?php if ($User_BirthYear == '1966') { echo 'selected'; } ?>>1966</option>
							<option value = "1967"<?php if ($User_BirthYear == '1967') { echo 'selected'; } ?>>1967</option>
							<option value = "1968"<?php if ($User_BirthYear == '1968') { echo 'selected'; } ?>>1968</option>
							<option value = "1969"<?php if ($User_BirthYear == '1969') { echo 'selected'; } ?>>1969</option>
							<option value = "1970"<?php if ($User_BirthYear == '1970') { echo 'selected'; } ?>>1970</option>
							<option value = "1971"<?php if ($User_BirthYear == '1971') { echo 'selected'; } ?>>1971</option>
							<option value = "1972"<?php if ($User_BirthYear == '1972') { echo 'selected'; } ?>>1972</option>
							<option value = "1973"<?php if ($User_BirthYear == '1973') { echo 'selected'; } ?>>1973</option>
							<option value = "1974"<?php if ($User_BirthYear == '1974') { echo 'selected'; } ?>>1974</option>
							<option value = "1975"<?php if ($User_BirthYear == '1975') { echo 'selected'; } ?>>1975</option>
							<option value = "1976"<?php if ($User_BirthYear == '1976') { echo 'selected'; } ?>>1976</option>
							<option value = "1977"<?php if ($User_BirthYear == '1977') { echo 'selected'; } ?>>1977</option>
							<option value = "1978"<?php if ($User_BirthYear == '1978') { echo 'selected'; } ?>>1978</option>
							<option value = "1979"<?php if ($User_BirthYear == '1979') { echo 'selected'; } ?>>1979</option>
							<option value = "1980"<?php if ($User_BirthYear == '1980') { echo 'selected'; } ?>>1980</option>
							<option value = "1981"<?php if ($User_BirthYear == '1981') { echo 'selected'; } ?>>1981</option>
							<option value = "1982"<?php if ($User_BirthYear == '1982') { echo 'selected'; } ?>>1982</option>
							<option value = "1983"<?php if ($User_BirthYear == '1983') { echo 'selected'; } ?>>1983</option>
							<option value = "1984"<?php if ($User_BirthYear == '1984') { echo 'selected'; } ?>>1984</option>
							<option value = "1985"<?php if ($User_BirthYear == '1985') { echo 'selected'; } ?>>1985</option>
							<option value = "1986"<?php if ($User_BirthYear == '1986') { echo 'selected'; } ?>>1986</option>
							<option value = "1987"<?php if ($User_BirthYear == '1987') { echo 'selected'; } ?>>1987</option>
							<option value = "1988"<?php if ($User_BirthYear == '1988') { echo 'selected'; } ?>>1988</option>
							<option value = "1989"<?php if ($User_BirthYear == '1989') { echo 'selected'; } ?>>1989</option>
							<option value = "1990"<?php if ($User_BirthYear == '1990') { echo 'selected'; } ?>>1990</option>
							<option value = "1991"<?php if ($User_BirthYear == '1991') { echo 'selected'; } ?>>1991</option>
							<option value = "1992"<?php if ($User_BirthYear == '1992') { echo 'selected'; } ?>>1992</option>
							<option value = "1993"<?php if ($User_BirthYear == '1993') { echo 'selected'; } ?>>1993</option>
							<option value = "1994"<?php if ($User_BirthYear == '1994') { echo 'selected'; } ?>>1994</option>
							<option value = "1995"<?php if ($User_BirthYear == '1995') { echo 'selected'; } ?>>1995</option>
							<option value = "1996"<?php if ($User_BirthYear == '1996') { echo 'selected'; } ?>>1996</option>
							<option value = "1997"<?php if ($User_BirthYear == '1997') { echo 'selected'; } ?>>1997</option>
							<option value = "1998"<?php if ($User_BirthYear == '1998') { echo 'selected'; } ?>>1998</option>
							<option value = "1999"<?php if ($User_BirthYear == '1999') { echo 'selected'; } ?>>1999</option>
							<option value = "2000"<?php if ($User_BirthYear == '2000') { echo 'selected'; } ?>>2000</option>
							<option value = "2001"<?php if ($User_BirthYear == '2001') { echo 'selected'; } ?>>2001</option>
							<option value = "2002"<?php if ($User_BirthYear == '2002') { echo 'selected'; } ?>>2002</option>
							<option value = "2003"<?php if ($User_BirthYear == '2003') { echo 'selected'; } ?>>2003</option>
							<option value = "2004"<?php if ($User_BirthYear == '2004') { echo 'selected'; } ?>>2004</option>
							<option value = "2005"<?php if ($User_BirthYear == '2005') { echo 'selected'; } ?>>2005</option>
							</select>
                        </div>
						<div class="form-group">
                            <label>Education Level:</label>
                            <select name="User_EdLevel" class="form-control">
							<option value = "" disabled selected>Highest Awarded Degree/Certificate?</option>							
							<option value = "High School Diploma"<?php if ($User_EdLevel == 'High School Diploma') { echo 'selected'; } ?>>High School Diploma</option>
							<option value = "Associate Degree"<?php if ($User_EdLevel == 'Associate Degree') { echo 'selected'; } ?>>Associate's Degree</option>
							<option value = "Certification"<?php if ($User_EdLevel == 'Certification') { echo 'selected'; } ?>>Certification</option>
							<option value = "Bachelor Degree"<?php if ($User_EdLevel == 'Bachelor Degree') { echo 'selected'; } ?>>Bachelor's Degree</option>
							<option value = "Master Degree"<?php if ($User_EdLevel == 'Master Degree') { echo 'selected'; } ?>>Master's Degree</option>
							<option value = "Doctorate Degree"<?php if ($User_EdLevel == 'Doctorate Degree') { echo 'selected'; } ?>>Doctorate Degree</option>
							</select>
						</div>
						<div class="form-group">
                            <label>MTANumber:</label>
                            <input type="Text" name="User_MTANumber" pattern="[0-9]{8}" class="form-control" value="<?php echo $User_MTANumber; ?>">

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="ViewEmployeeRoster.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>