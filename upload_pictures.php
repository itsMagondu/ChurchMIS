<?php include('Connections/church.php'); ?>

<?php 





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon  Peter ---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parsing section for the member picture... only runs if they attempt to upload or replace a picture
if ($_POST['upload_pic'] == "pic"){

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

} // close the condition that checks the posted "upload_pic" value for image upload or replace

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//------------------------------Created By Teflon---------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

   <form id="pic1_form"  action="upload_pictures.php" method="post"  enctype="multipart/form-data" name="pic1_form">
             <tr>
          <td width="16%" height="23"><?php print "$user_pic" ;?></td>
          <td width="73%">
        <input type="file" name="fileField" id="fileField" size="42" />
         50 kb Max 
          </td>
          <td width="11%">
          <input name="upload_pic" type="hidden" value="pic"/>
            <input type="submit" name="button" id="button" value="Submit" />
          </td>
        </tr>
        </form>