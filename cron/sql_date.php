<?php 

/quesries for date update
	
	UPDATE `member_info_date` SET `birthdayyear` = YEAR(`date`), `birthdaymonth` = DATE_FORMAT(`birthdaymonth`, '%m'), `birthdate` = DATE_FORMAT(`date`, '%d')