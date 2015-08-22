@ECHO OFF
SET DEBUG=ON
SET PROJ_NAME=xzbase64


IF EXIST "%PROJ_NAME%.exe" DEL/F/S/Q  "%PROJ_NAME%.exe">NUL

..\..\bamcompile %PROJ_NAME%.bcp
ping localhost -n 03 -w 02>NUL

IF "%DEBUG%"=="ON" PAUSE>NUL