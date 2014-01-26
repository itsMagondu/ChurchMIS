echo 
set mySqlPath=C:\Program Files\MySQL\MySQL Server 5.1

set dbUser=stpeters
set dbPassword=backup
set dbName=stpeters_kirangari
set file=%dbName%.%date:~0,3%_%date:~4,2%_%date:~7,2%_%date:~10,4%.sql
set path=C:\Users\ADMIN\Google Drive\Databsebackup

echo Running dump for database %dbName% ^> ^%path%\%file% 
"%mySqlPath%\bin\mysqldump.exe" -u %dbUser% -p%dbPassword% --result-file="%path%\%file%" %dbName%


echo Done!
