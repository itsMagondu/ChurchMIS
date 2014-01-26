<?php
session_start(); 
if(!$_SESSION['id']){
$msgToUser='<br/><br/><font color="FF0000">Only site Members can do that </font><p><a href="register.php">JOIN HERE </a>';

include_once 'msgToUser.php';
exit();
	


}
  ///////////////////End Log Check/////////////////


// Connect to database
include "connect.php";

// If coming from category page

$id = $_SESSION['id'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon  Peter ---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for the member picture... only runs if they attempt to upload or replace a picture
if ($_POST['parse_var'] == "pic"){

        if (!$_FILES['fileField']['tmp_name']) { 
		
            $error_msg = '<font color="#FF0000">ERROR: Please browse for an image before you press submit.</font>';
			
        } else {

            $maxfilesize =  649118 ; // 649,118 bytes  equals 633kb
            if($_FILES['fileField']['size'] > $maxfilesize ) { 

                        $error_msg = '<font color="#FF0000">ERROR: Your image was too large, please try again.</font>';
                        unlink($_FILES['fileField']['tmp_name']); 

            } else if (!preg_match("/\.(gif|jpg|png)$/i", $_FILES['fileField']['name'] ) ) {

                        $error_msg = '<font color="#FF0000">ERROR: Your image was not one of the accepted formats, please try again.</font>';
                        unlink($_FILES['fileField']['tmp_name']); 

            } else { 

              $newname = "image01.jpg";
         $place_file = move_uploaded_file($_FILES['fileField']['tmp_name'], "members/$id/".$newname);
          $success_msg = '<font color="#009900">Your image has been updated, it may take a few minutes for the changes to show... please                                                    be patient.</font>';
            }

        } // close else that checks file exists

} // close the condition that checks the posted "parse_var" value for image upload or replace

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for changing Names ... only runs if they attempt to change that
if($_POST['parse_var']=="nameForm"){
	
	
	
	
	}
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Adam Khoury @ www.developphp.com---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for changing location info... only runs if they attempt to change that
if ($_POST['parse_var'] == "location"){

        $country = $_POST['country'];
		$city = $_POST['city'];
		
		
        // Error handling for missing data
        if ((!$state) || (!$city) || (!$zip)) { 
        $error_msg = '<font color="#FF0000">ERROR: Please do not make the field(s) blank in that section</font>';
		} else {
		
				$city = eregi_replace("'", "&#39;", $city);
				$city = eregi_replace("`", "&#39;", $city);
        		$city = mysql_real_escape_string($city);
				$country = eregi_replace("'", "&#39;", $country );
				$country  = eregi_replace("`", "&#39;", $country );
        		$country = mysql_real_escape_string($country);		
        		$sqlUpdate = mysql_query("UPDATE myMembers SET country='$country', state='$state', city='$city', zip='$zip' WHERE id='$id'");
       		    if ($sqlUpdate){
           		      $success_msg = '<font color="#009900">Your location data has been updated.</font>';
       		    } else {
					  $error_msg = '<font color="#FF0000">ERROR: Problems connecting to server, please try again later.</font>';
			    }

		}
}






/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for changing website URL... only runs if they attempt to change that
if ($_POST['parse_var'] == "website"){

        $website = $_POST['website'];
		$website = eregi_replace("http://", "", $website);
		$website = eregi_replace("'", "&#39;", $website);
		$website = eregi_replace("`", "&#39;", $website);
        $website = mysql_real_escape_string($website);
        $sqlUpdate = mysql_query("UPDATE myMembers SET website='$website' WHERE id='$id'");
        if ($sqlUpdate){
            $success_msg = '<font color="#009900">Your website URL has been updated.</font>';
        } else {
			$error_msg = '<font color="#FF0000">ERROR: Problems connecting to server, please try again later.</font>';
		}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for changing YouTube channel name... only runs if they attempt to change that
if ($_POST['parse_var'] == "youtube"){

        $youtube = $_POST['youtube'];
	    $youtube = eregi_replace("http://www.youtube.com/user/", "", $youtube); 
		$youtube = eregi_replace("'", "&#39;", $youtube);
		$youtube = eregi_replace("`", "&#39;", $youtube);
        $youtube = mysql_real_escape_string($youtube);
        $sqlUpdate = mysql_query("UPDATE myMembers SET youtube='$youtube' WHERE id='$id'");
        if ($sqlUpdate){
            $success_msg = '<font color="#009900">Your youtube channel name has been updated.</font>';
        } else {
			$error_msg = '<font color="#FF0000">ERROR: Problems connecting to server, please try again later.</font>';
		}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for changing YouTube channel name... only runs if they attempt to change that
if ($_POST['parse_var'] == "bio_body"){

        $bio_body = $_POST['bio_body'];
		$bio_body = eregi_replace("'", "&#39;", $bio_body);
		$bio_body = eregi_replace("`", "&#39;", $bio_body);
        $bio_body = mysql_real_escape_string($bio_body);
        $bio_body = nl2br(htmlspecialchars($_POST['bio_body']));
        $sqlUpdate = mysql_query("UPDATE myMembers SET bio_body='$bio_body' WHERE id='$id'");
        if ($sqlUpdate){
            $success_msg = '<font color="#009900">Your About section has been updated.</font>';
        } else {
			$error_msg = '<font color="#FF0000">Problems connecting to server, please try again later.</font>';
		}

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// All parsing has ended by this point in the script, so query the most current data for member
// This will show refreshed data to the user so they do not see old data after making changes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Final default sql query that will refresh the member data on page, and show most current

$sql = mysql_query("SELECT * FROM mymembers WHERE id='$id'");

while($row = mysql_fetch_array($sql)){ 

	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$country = $row["country"];	
	$state = $row["state"];
	$city = $row["city"];
	$zip = $row["zip"];
	//$style_sheet="style_sheet";
	
	$bio_body = $row["bio_body"];	
	$website = $row["website"];
	$youtube = $row["youtube"];
	
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic\" width=\"300px\" />"; // forces picture to be 100px wide and no more
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"300px\" />"; // forces default picture to be 100px wide and no more
	}
	///////  Mechanism to Display Youtube Channel or not  //////////////////////////
	if ($youtube == "") {
    $youtubeChannel = "<br />This user has no YouTube channel yet.";
	} else {
	$youtubeChannel = ' <script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/youtube.xml&amp;up_channel=' . $youtube . '&amp;synd=open&amp;w=290&amp;h=370&amp;title=&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>  '; // forces default picture to be 100px wide and no more
	}	

} // close while loop

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transition//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml 1-tranitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content=" Teflon Social Site profile edit area  <?php print "$firstname,$lastname";?> "/>
<meta name="keywords" content="edit,profile,data,infornation <?php print "$firstname$lastname,$city,$state,$country";?>"/>
<meta name="rating" content="General"/>
<meta name="revist-after" content="7 days"/>
 

<title> EDIT PROFILE AREA  FOR  <br><?php print "$firstname$lastname";?> </title>

<link href="style/main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

</head>
<body>
<?php include_once"header_template.php";?>

<table width="950" border="1" align="center">
  <td height="14"><tr>
    <td height="22"><td width="754" valign="top"><br/>
      
      <table width="90%" border="0" align="center">
      
      <tr>
      <td width="80%"><h3>Edit Your Profile <?php print "$firstname";?></h3></td>
      <td width="20%"><a href="edit_settings.php">Edit Account Settings</a></td>
      </tr>
      </table>
	  <?php print "$error_msg"; ?><?php print "$success_msg"; ?>
      
      <hr align="center" width="680"/>
      <br/>
      <table width="90%" border="0" align="center">
   <form id="pic1_form"  action="edit_profile.php" method="post"  enctype="multipart/form-data" name="pic1_form">
             <tr>
          <td width="16%" height="23"><?php print "$user_pic" ;?></td>
          <td width="73%">
        <input type="file" name="fileField" id="fileField" size="42" />
         50 kb Max 
          </td>
          <td width="11%">
          <input name="parse_var" type="hidden" value="pic"/>
            <input type="submit" name="button" id="button" value="Submit" />
          </td>
        </tr>
        </form>
      </table>
     <hr align="center" width="680"/>
   
     <p>&nbsp; </p>
   
<p>&nbsp; </p>
     <hr align="center" width="680"/>
   <table width="90%" border="0" align="center">
   <form action="edit_profile.php" enctype="multipart/form-data" method="post" name="locationForm" id="locationForm">
   <tr>
   <td width="16%">Location:</td>
   <td width="31"><select name="country" class="formFields">
   <option value="<?php print "$country";?>"><?php print "$country" ;?></option>
   <option value="United States of America">United States of America</option>
              <option value="Afghanistan">Afghanistan</option>
              <option value="Albania">Albania</option>
              <option value="Algeria">Algeria</option>
              <option value="American Samoa">American Samoa</option>
              <option value="Andorra">Andorra</option>
              <option value="Angola">Angola</option>
              <option value="Anguilla">Anguilla</option>
              <option value="Antigua and Barbuda">Antigua and Barbuda</option>
              <option value="Argentina">Argentina</option>
              <option value="Armenia">Armenia</option>
              <option value="Aruba">Aruba</option>
              <option value="Australia">Australia</option>
              <option value="Austria">Austria</option>
              <option value="Azerbaijan">Azerbaijan</option>
              <option value="Bahamas">Bahamas</option>
              <option value="Bahrain">Bahrain</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Barbados">Barbados</option>
              <option value="Belarus">Belarus</option>
              <option value="Belgium">Belgium</option>
              <option value="Belize">Belize</option>
              <option value="Benin">Benin</option>
              <option value="Bermuda">Bermuda</option>
              <option value="Bhutan">Bhutan</option>
              <option value="Bolivia">Bolivia</option>
              <option value="Bonaire">Bonaire</option>
              <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
              <option value="Botswana">Botswana</option>
              <option value="Brazil">Brazil</option>
              <option value="British Indian Ocean">British Indian Ocean Ter</option>
              <option value="Brunei">Brunei</option>
              <option value="Bulgaria">Bulgaria</option>
              <option value="Burkina Faso">Burkina Faso</option>
              <option value="Burundi">Burundi</option>
              <option value="Cambodia">Cambodia</option>
              <option value="Cameroon">Cameroon</option>
              <option value="Canada">Canada</option>
              <option value="Canary Islands">Canary Islands</option>
              <option value="Cape Verde">Cape Verde</option>
              <option value="Cayman Islands">Cayman Islands</option>
              <option value="Central African Republic">Central African Republic</option>
              <option value="Chad">Chad</option>
              <option value="Channel Islands">Channel Islands</option>
              <option value="Chile">Chile</option>
              <option value="China">China</option>
              <option value="Christmas Island">Christmas Island</option>
              <option value="Cocos Island">Cocos Island</option>
              <option value="Columbia">Columbia</option>
              <option value="Comoros">Comoros</option>
              <option value="Congo">Congo</option>
              <option value="Cook Islands">Cook Islands</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Cote D'Ivoire">Cote D'Ivoire</option>
              <option value="Croatia">Croatia</option>
              <option value="Cuba">Cuba</option>
              <option value="Curacao">Curacao</option>
              <option value="Cyprus">Cyprus</option>
              <option value="Czech Republic">Czech Republic</option>
              <option value="Denmark">Denmark</option>
              <option value="Djibouti">Djibouti</option>
              <option value="Dominica">Dominica</option>
              <option value="Dominican Republic">Dominican Republic</option>
              <option value="East Timor">East Timor</option>
              <option value="Ecuador">Ecuador</option>
              <option value="Egypt">Egypt</option>
              <option value="El Salvador">El Salvador</option>
              <option value="Equatorial Guinea">Equatorial Guinea</option>
              <option value="Eritrea">Eritrea</option>
              <option value="Estonia">Estonia</option>
              <option value="Ethiopia">Ethiopia</option>
              <option value="Falkland Islands">Falkland Islands</option>
              <option value="Faroe Islands">Faroe Islands</option>
              <option value="Fiji">Fiji</option>
              <option value="Finland">Finland</option>
              <option value="France">France</option>
              <option value="French Guiana">French Guiana</option>
              <option value="French Polynesia">French Polynesia</option>
              <option value="French Southern Ter">French Southern Ter</option>
              <option value="Gabon">Gabon</option>
              <option value="Gambia">Gambia</option>
              <option value="Georgia">Georgia</option>
              <option value="Germany">Germany</option>
              <option value="Ghana">Ghana</option>
              <option value="Gibraltar">Gibraltar</option>
              <option value="Great Britain">Great Britain</option>
              <option value="Greece">Greece</option>
              <option value="Greenland">Greenland</option>
              <option value="Grenada">Grenada</option>
              <option value="Guadeloupe">Guadeloupe</option>
              <option value="Guam">Guam</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Guinea">Guinea</option>
              <option value="Guyana">Guyana</option>
              <option value="Haiti">Haiti</option>
              <option value="Hawaii">Hawaii</option>
              <option value="Honduras">Honduras</option>
              <option value="Hong Kong">Hong Kong</option>
              <option value="Hungary">Hungary</option>
              <option value="Iceland">Iceland</option>
              <option value="India">India</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Iran">Iran</option>
              <option value="Iraq">Iraq</option>
              <option value="Ireland">Ireland</option>
              <option value="Isle of Man">Isle of Man</option>
              <option value="Israel">Israel</option>
              <option value="Italy">Italy</option>
              <option value="Jamaica">Jamaica</option>
              <option value="Japan">Japan</option>
              <option value="Jordan">Jordan</option>
              <option value="Kazakhstan">Kazakhstan</option>
              <option value="Kenya">Kenya</option>
              <option value="Kiribati">Kiribati</option>
              <option value="Korea North">Korea North</option>
              <option value="Korea South">Korea South</option>
              <option value="Kuwait">Kuwait</option>
              <option value="Kyrgyzstan">Kyrgyzstan</option>
              <option value="Laos">Laos</option>
              <option value="Latvia">Latvia</option>
              <option value="Lebanon">Lebanon</option>
              <option value="Lesotho">Lesotho</option>
              <option value="Liberia">Liberia</option>
              <option value="Libya">Libya</option>
              <option value="Liechtenstein">Liechtenstein</option>
              <option value="Lithuania">Lithuania</option>
              <option value="Luxembourg">Luxembourg</option>
              <option value="Macau">Macau</option>
              <option value="Macedonia">Macedonia</option>
              <option value="Madagascar">Madagascar</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Malawi">Malawi</option>
              <option value="Maldives">Maldives</option>
              <option value="Mali">Mali</option>
              <option value="Malta">Malta</option>
              <option value="Marshall Islands">Marshall Islands</option>
              <option value="Martinique">Martinique</option>
              <option value="Mauritania">Mauritania</option>
              <option value="Mauritius">Mauritius</option>
              <option value="Mayotte">Mayotte</option>
              <option value="Mexico">Mexico</option>
              <option value="Midway Islands">Midway Islands</option>
              <option value="Moldova">Moldova</option>
              <option value="Monaco">Monaco</option>
              <option value="Mongolia">Mongolia</option>
              <option value="Montserrat">Montserrat</option>
              <option value="Morocco">Morocco</option>
              <option value="Mozambique">Mozambique</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Nambia">Nambia</option>
              <option value="Nauru">Nauru</option>
              <option value="Nepal">Nepal</option>
              <option value="Netherland Antilles">Netherland Antilles</option>
              <option value="Netherlands">Netherlands</option>
              <option value="Nevis">Nevis</option>
              <option value="New Caledonia">New Caledonia</option>
              <option value="New Zealand">New Zealand</option>
              <option value="Nicaragua">Nicaragua</option>
              <option value="Niger">Niger</option>
              <option value="Nigeria">Nigeria</option>
              <option value="Niue">Niue</option>
              <option value="Norfolk Island">Norfolk Island</option>
              <option value="Norway">Norway</option>
              <option value="Oman">Oman</option>
              <option value="Pakistan">Pakistan</option>
              <option value="Palau Island">Palau Island</option>
              <option value="Palestine">Palestine</option>
              <option value="Panama">Panama</option>
              <option value="Papua New Guinea">Papua New Guinea</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Peru">Peru</option>
              <option value="Philippines">Philippines</option>
              <option value="Pitcairn Island">Pitcairn Island</option>
              <option value="Poland">Poland</option>
              <option value="Portugal">Portugal</option>
              <option value="Puerto Rico">Puerto Rico</option>
              <option value="Qatar">Qatar</option>
              <option value="Reunion">Reunion</option>
              <option value="Romania">Romania</option>
              <option value="Russia">Russia</option>
              <option value="Rwanda">Rwanda</option>
              <option value="St Barthelemy">St Barthelemy</option>
              <option value="St Eustatius">St Eustatius</option>
              <option value="St Helena">St Helena</option>
              <option value="St Kitts-Nevis">St Kitts-Nevis</option>
              <option value="St Lucia">St Lucia</option>
              <option value="St Maarten">St Maarten</option>
              <option value="St Pierre and Miquelon">St Pierre and Miquelon</option>
              <option value="St Vincent and Grenadines">St Vincent and Grenadines</option>
              <option value="Saipan">Saipan</option>
              <option value="Samoa">Samoa</option>
              <option value="Samoa American">Samoa American</option>
              <option value="San Marino">San Marino</option>
              <option value="Sao Tome and Principe">Sao Tome and Principe</option>
              <option value="Saudi Arabia">Saudi Arabia</option>
              <option value="Senegal">Senegal</option>
              <option value="Seychelles">Seychelles</option>
              <option value="Serbia and Montenegro">Serbia and Montenegro</option>
              <option value="Sierra Leone">Sierra Leone</option>
              <option value="Singapore">Singapore</option>
              <option value="Slovakia">Slovakia</option>
              <option value="Slovenia">Slovenia</option>
              <option value="Solomon Islands">Solomon Islands</option>
              <option value="Somalia">Somalia</option>
              <option value="South Africa">South Africa</option>
              <option value="Spain">Spain</option>
              <option value="Sri Lanka">Sri Lanka</option>
              <option value="Sudan">Sudan</option>
              <option value="Suriname">Suriname</option>
              <option value="Swaziland">Swaziland</option>
              <option value="Sweden">Sweden</option>
              <option value="Switzerland">Switzerland</option>
              <option value="Syria">Syria</option>
              <option value="Tahiti">Tahiti</option>
              <option value="Taiwan">Taiwan</option>
              <option value="Tajikistan">Tajikistan</option>
              <option value="Tanzania">Tanzania</option>
              <option value="Thailand">Thailand</option>
              <option value="Togo">Togo</option>
              <option value="Tokelau">Tokelau</option>
              <option value="Tonga">Tonga</option>
              <option value="Trinidad and Tobago">Trinidad and Tobago</option>
              <option value="Tunisia">Tunisia</option>
              <option value="Turkey">Turkey</option>
              <option value="Turkmenistan">Turkmenistan</option>
              <option value="Turks and Caicos Is">Turks and Caicos Is</option>
              <option value="Tuvalu">Tuvalu</option>
              <option value="Uganda">Uganda</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="United States of America">United States of America</option>
              <option value="Uruguay">Uruguay</option>
              <option value="Uzbekistan">Uzbekistan</option>
              <option value="Vanuatu">Vanuatu</option>
              <option value="Vatican City State">Vatican City State</option>
              <option value="Venezuela">Venezuela</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Virgin Islands (Brit)">Virgin Islands Brit</option>
              <option value="Virgin Islands (USA)">Virgin Islands USA</option>
              <option value="Wake Island">Wake Island</option>
              <option value="Wallis and Futana Is">Wallis and Futana Is</option>
              <option value="Yemen">Yemen</option>
              <option value="Zaire">Zaire</option>
              <option value="Zambia">Zambia</option>
              <option value="Zimbabwe">Zimbabwe</option>
            </select>
            </td>&nbsp;&nbsp;&nbsp;&nbsp;
			 
             <td width="16%">City &nbsp;&nbsp; :</td>
			 <td width="35%"><input name="city" type="text" class="formFields" id="city" value="<?php print "$city"; ?>" size="10" maxlength="32" />
			 </td>
              <td width="20%">
            <input name="parse_var" type="hidden" value="location" />
            <input type="submit" name="button3" id="button3" value="Submit" /></td>
      </tr>
     </form>
  </table>
      
      <hr align="center" width="680" />
      
      <br />
      <table width="90%" border="0" align="center">
        <form action="edit_profile.php" enctype="multipart/form-data" method="post" name="websiteForm" id="websiteForm">
          <tr>
            <td width="16%">Website:</td>
            <td width="74%"><strong>http://</strong>
            <input name="website" type="text" class="formFields" id="website" value="<?php print "$website"; ?>" size="36" maxlength="32" /></td>
            <td width="10%">
            <input name="parse_var" type="hidden" value="website" />
            <input type="submit" name="button4" id="button4" value="Submit" /></td>
          </tr>
        </form>
      </table>
      
      <hr align="center" width="680" />
      
      <br />
      <table width="90%" border="0" align="center">
        <form action="edit_profile.php" enctype="multipart/form-data" method="post" name="youtubeForm" id="youtubeForm">
          <tr>
            <td width="16%">Youtube Channel:</td>
            <td width="74%"><strong>http://www.youtube.com/user/</strong>
            <input name="youtube" type="text" class="formFields" id="youtube" value="<?php print "$youtube"; ?>" size="20" maxlength="40" /></td>
            <td width="10%">
            <input name="parse_var" type="hidden" value="youtube" />
            <input type="submit" name="button5" id="button5" value="Submit" /></td>
          </tr>
        </form>
      </table>
      
      <hr align="center" width="680" />
      
      <br />
      <table width="90%" border="0" align="center">
        <form action="edit_profile.php" enctype="multipart/form-data" method="post" name="bioForm" id="bioForm">
          <tr>
            <td width="16%">About You:</td>
            <td width="74%"><textarea name="bio_body" cols="" rows="5" class="formFields" style="width:94%;"><?php print "$bio_body"; ?></textarea></td>
            <td width="10%">
            <input name="parse_var" type="hidden" value="bio_body" />
            <input type="submit" name="button6" id="button6" value="Submit" /></td>
          </tr>
        </form>
      </table>       
      
       <hr align="center" width="680" />
      <p><br />
        <br />
  
<p>&nbsp;</p>
      <p><br/>
        <br/>
      </p>
      <p><br/>
        <br/>
        <br/>
        <br/>
        <br/>
        
<p>&nbsp;</p><td height="42"></td>
    <td width="180" valign="top"><?php include_once"rightAD_template.php";?></td>
  </tr>
</table>
<?php include_once"footer_template.php";?>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
