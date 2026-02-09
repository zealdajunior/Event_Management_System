@echo off
echo Adding firewall rule to allow Laravel server access...
netsh advfirewall firewall delete rule name="Laravel Dev Server" protocol=TCP localport=8000
netsh advfirewall firewall add rule name="Laravel Dev Server" dir=in action=allow protocol=TCP localport=8000
echo.
echo Firewall rule added successfully!
echo.
echo Getting your local IP address...
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4"') do set IP=%%a
set IP=%IP:~1%
echo Your local IP address is: %IP%
echo.
echo You can now access the server from other devices on your network at:
echo http://%IP%:8000
echo.
pause
