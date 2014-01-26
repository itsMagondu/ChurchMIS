<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Query ~~~</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">

		function getScriptPage(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "script_page_contacts.php?content=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}	

</script>
<link href="styles.css" rel="stylesheet" type="text/css"></link>	
</head>

<body w>

<div class="ajax-div">
	
  <div class="input-div"> 
    <div align="left">Enter Search Keyword here : 
      <input type="text" id="text_content" size="40" onKeyUp="getScriptPage('count_display','text_content','1')">
      <input type="button" class="button" value="Search" onMouseUp="getScriptPage('output_div','text_content','0')">
    </div>
    <div id="count_display">
		   
		</div>
	</div>
	<div class="output-div-container">
	<div id="output_div"> </div>
  </div>
</div>
</body>
</html>
