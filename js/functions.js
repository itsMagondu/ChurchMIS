// JavaScript Document
//validate the passwords
function pwdCompare(f) 
{
	
//check if empty
if ((f.Username.value.length==0) || (f.Username.value==null)) 
{
   alert("Please enter the username");
   f.Username.focus();
   return false;
}
//compare the paswords
var p1 = f.Password.value;
	p1 = p1.replace(/^\s+/g, "");  // strip leading spaces
	var p2 = f.Passwordconf.value;
	p2 = p2.replace(/^\s+/g, "");  // strip leading spaces
	if ((p1.length < 6) || (p1 != p2)) 
		{  // minimum 6 characters
		alert ("The two passwords do not match or have too few characters i.e less than 6 characters!  Try again!");
		f.Password.value = "";
		f.Passwordconf.value = "";
		f.Password.focus();
		return false;
		}
	//validate email
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(f.Email.value))
	{
	return (true);
	}
	else
	{
	alert("Invalid E-mail Address! Please re-enter.");
	return (false);
	}

}

function pwdCompare2(f) 
{
	
//check if empty
if ((f.Users.value.length==0) || (f.Users.value==null)) 
{
   alert("Please enter the username");
   f.Users.focus();
   return false;
}
//check if empty
if ((f.oldpwd.value.length==0) || (f.oldpwd.value==null)) 
{
   alert("Please enter the old password");
   f.oldpwd.focus();
   return false;
}
var p1 = f.newpwd.value;
p1 = p1.replace(/^\s+/g, "");  // strip leading spaces
var p2 = f.newpwd2.value;
p2 = p2.replace(/^\s+/g, "");  // strip leading spaces
if ((p1.length < 6) || (p1 != p2)) {  // minimum 6 characters
alert ("The two passwords do not match or have too few characters i.e less than 6 characters!  Try again!");
f.newpwd.value = "";
f.newpwd2.value = "";
f.newpwd.focus();
return false;
}
}





//to prompt a confirmation before terminating the classes
function ConfirmDelete()
{
if(!confirm("Are you sure you want to delete?"))
return false;
}
//to prompt a confirmation before deleting an upload
function ConfirmDeleteUpload()
{
if(!confirm("Are you sure you want to delete this item as it isnt reversible?"))
return false;
}
//to prompt a confirmation before deleting an upload
function ConfirmPermanentDelete()
{
if(!confirm("Are you sure you want to delete this evaluation?. Note: This is a Permanent Deletion"))
return false;
}
//to prompt a confirmation before deleting an upload
function ConfirmRestore()
{
if(!confirm("Are you sure you want to restore this evaluation? It will be marked as incomplete!"))
return false;
}

//to prompt a confirmation before de-enrol a student
function Confirmdenrol()
{
if(!confirm("Are you sure you want to de-enrol this student as it isnt reversible?"))
return false;
}
//to prompt a confirmation before terminating the lecturer accounts
function ConfirmDereg()
{
if(!confirm("Are you sure you want to de-register the lecturer account as it will delete all his/her information and his/her classes prevoiusly created will be left without a lecturer? NOTE: To re-assign the classes to other lecturers use the manage accounts operation on this page."))
return false;
}

//to prompt a confirmation before terminating the lecturer accounts

function ConfirmTerm()
{
if(!confirm("Are you sure you want to proceed with to terminate/delete this item?"))
return false;
}


//function to disable the reassign form fields on the edit page
function Disable()
{
	Reassign.Class.disabled=false;
	Reassign.Class.value="";
	Reassign.Class.focus();
	Reassign.Names2.disabled=false;
	Reassign.Names2.value="";
	Reassign.Email2.disabled=false;
	Reassign.Email2.value="";
	Reassign.Phone2.value="";
	Reassign.Phone2.style.visibility = "hidden";
	Reassign.Phone2.disabled=true;
	Reassign.Password2.value="";
	Reassign.Password2.disabled=true;
	Reassign.Password2.style.visibility = "hidden";
	//Reassign.my_field[].value="";
	//Reassign.my_field[].disabled=true;
	
}

//function to enable the reassign form fields
function Enable()
{
	Reassign.Class.value="";
	Reassign.Class.focus();
	Reassign.Names2.value="";
	Reassign.Email2.value="";
	Reassign.Phone2.value="";
	Reassign.Phone2.disabled=false;
	Reassign.Phone2.style.visibility = "visible";
	Reassign.Password2.value="";
	Reassign.Password2.disabled=false;
	Reassign.Password2.style.visibility = "visible";
	//Reassign.my_field[].value="";
	//Reassign.my_field[].disabled=false;
	
}
//FUNCTION TO VALIDATE THE FILE FIELD
function ValidateField(f)
{
	if(f.my_field.value=="")
	{
		alert("The upload file name cannot be blank/empty");
		f.my_field.focus();
		return false;
	}
}