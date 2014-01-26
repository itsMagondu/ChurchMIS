echo on
set mySqlPath=C:\Program Files\MySQL\MySQL Server 5.1
set dbUser=stpeters
set dbPassword=backup
set dbHost=127.0.0.1
set dbName=stpeters_kirangari
set file=%dbName%.%DATE%_-_%time:~0,2%%time:~3,2%%time:~6,2%.sql
set path=C:\Users\ADMIN\Desktop

echo Running dump for database %dbName% ^> ^%path%\%file%
"%mySqlPath%\bin\mysqldump.exe" -u %dbUser% -p%dbPassword% %dbName% --result-file="%path%\%file%" %dbName%

echo Done!