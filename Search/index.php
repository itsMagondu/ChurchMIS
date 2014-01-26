<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Search Enquiry</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">

		function getScriptPage(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "script_page.php?content=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}	

</script>
<link href="styles.css" rel="stylesheet" type="text/css"></link>	
<link href="../Styles/BluePrint/Style.css" rel="stylesheet" type="text/css">
</head>

<body marginwidth="1">

<table width="700" border="0">
  <tr>
    <td><div class="ajax-div">
	
  <div class="input-div" > 
    <div align="left">Enter Search Name : 
    <!--
    Real time search modification: William
    
    November 10, 2009
    -->
    
     <!-- <input type="text" id="text_content" size="30" onKeyUp="getScriptPage('count_display','text_content','1')">-->
      <input type="text" id="text_content" size="30" onKeyUp="getScriptPage('output_div','text_content','0')">
      <!--<input type="button"  align="right"class="button" value="Search" onMouseUp="getScriptPage('output_div','text_content','0')">-->
    </div>
    <div id="count_display">
		   
		</div>
	</div>
	<div class="output-div-container">
	<div id="output_div"> </div>
  </div>
</div></td>
  </tr>
</table>

</body>
</html>
