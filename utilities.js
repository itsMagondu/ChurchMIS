// JavaScript Document


//to prompt a confirmation before deleting
function ConfirmDelete()
{
if(!confirm("Are you sure you want to delete the evaluation?"))
return false;
}
//to prompt a confirmation before restoring
function ConfirmRestore()
{
if(!confirm("Are you sure you want to Restore the evaluation? It will be categorized as Incomplete until you go through it to confirm the choices therein"))
return false;
}
function ConfirmRevert()
{
if(!confirm("Are you sure you want to Revert the audit? It will be categorized as complete until you specify that it is audited"))
return false;
}
function ConfirmPermanentDelete()
{
if(!confirm("Are you sure you want to Permanently Delete this evaluation? Note that this is irreversible!"))
return false;
}
function ConfirmAudit()
{
if(!confirm("Are you sure you want to Mark this evaluation as Audited?"))
return false;
}
function ConfirmAuto()
{
if(!confirm("Are you sure you want to perform the Auto Evaluation? This will automatically Evaluate the position"))
return false;
}