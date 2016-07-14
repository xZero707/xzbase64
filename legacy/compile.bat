@ECHO OFF
setlocal enableextensions enabledelayedexpansion
:: Package: xzbase64
:: Author: xZero

:: You may modify only this
SET CONFIGURATION=compile_config.ini

:: Do not modify any further
TITLE Initializing...
ECHO Loading configuration %CONFIGURATION% ...
IF NOT EXIST "%CONFIGURATION%" call :CREATE_DEFAULT_CONFIG
ping localhost -n 03 -w 02>NUL
:: Load configuration file
for /f "delims=" %%a in ('find "=" ^< "%CONFIGURATION%"') do call set "%%a"

SET ERRORS=0
SET PROJ_BCP=%PROJ_NAME%.bcp
SET PROJ_EXE=%PROJ_NAME%.exe
SET ERR_DESCR_COMPILER=
SET ERR_DESCR_BCP=
SET ERR_DESCR_ICON=
SET LOG_FILE="%TEMP%\%PROJ_NAME%_COMP_%rand%%rand%%rand%.log"
SET ERR_ORDER=1
SET DELETE=call :DELETE
SET UPX_COMPRESS_OUT=; compress
SET TITLE=TITLE Bamcompile %PROJ_NAME% - 
%TITLE% Loading
ECHO Checking required files...
IF NOT EXIST "%COMPILER%" SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_COMPILER=Missing compiler executable %COMPILER%
IF NOT EXIST "%PROJ_ICON%" SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_ICON=Missing project icon %PROJ_ICON%

IF EXIST "%PROJ_EXE%" %DELETE% "%PROJ_EXE%"
IF "%DEL_STATUS%"=="false" SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_EXE=Failed to remove existing executable %PROJ_EXE%

IF EXIST "%PROJ_BCP%" %DELETE% "%PROJ_BCP%"
IF "%DEL_STATUS%"=="false" 1 SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_BCPD=Failed to remove existing Bamcompile project file %PROJ_BCP%

ECHO Creating Bamcompile project file %PROJ_BCP% ...
call :CREATE_BCP
IF NOT EXIST "%PROJ_BCP%" SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_BCP=Missing Bamcompile project file %PROJ_BCP%
IF "%~1"=="-bcponly" PAUSE&GOTO EXIT
%TITLE% Compiling...
%COMPILER% "%PROJ_BCP%"
::IF ERRORLEVEL 3 SET/a ERRORS=%ERRORS%+1&SET ERR_DESCR_COMP=Failed to compile due to an error(s):

IF NOT "%ERRORS%"=="0" GOTO FAILURE
IF "%~1"=="-keepbcp" ECHO Leaving %PROJ_BCP% intact... &GOTO FINISH
ECHO Deleting residual file %PROJ_BCP%...
%DELETE% "%PROJ_BCP%">NUL
:FINISH
TITLE Bamcompile %PROJ_NAME% - Done
ECHO.
ECHO Finished.
ECHO.
IF NOT "%DEBUG%"=="ON" ping localhost -n 03 -w 02>NUL
IF "%DEBUG%"=="ON" PAUSE
GOTO EXIT
:FAILURE
TITLE Bamcompile %PROJ_NAME% - Error
ECHO.
ECHO.
ECHO There are %ERRORS% errors ocurred:
ECHO.
::IF NOT "%ERR_DESCR_COMP%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_COMP%
IF NOT "%ERR_DESCR_COMPILER%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_COMPILER%
IF NOT "%ERR_DESCR_BCP%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_BCP%
IF NOT "%ERR_DESCR_BCPD%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_BCPD%
IF NOT "%ERR_DESCR_ICON%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_ICON%
IF NOT "%ERR_DESCR_EXE%"=="" SET/a ERR_ORDER=%ERR_ORDER%+1& ECHO  %ERR_ORDER%. %ERR_DESCR_EXE%
ECHO.


ECHO If you^'re reading this, that may, or may not mean that compilation has failed.
ECHO.
ECHO.
PAUSE
:EXIT
TITLE Bamcompile %PROJ_NAME% - Exiting...
%DELETE% "%LOG_FILE%"
EXIT



:: Functions

:CREATE_DEFAULT_CONFIG
ECHO Failed...
ECHO Creating configuration %CONFIGURATION% with default values...
ECHO Writting...
ECHO # Package: xzbase64>"%CONFIGURATION%"
ECHO # Author: xZero>>"%CONFIGURATION%"
ECHO [PROGRAM]>>"%CONFIGURATION%"
ECHO # Better to not modify those, dictates how batch will work>>"%CONFIGURATION%"
ECHO DEBUG=ON>>"%CONFIGURATION%"
ECHO COMPILER=..\..\bamcompile.exe>>"%CONFIGURATION%"
ECHO.>>"%CONFIGURATION%"
ECHO [PHP_COMPILE_PROJECT_SETTINGS]>>"%CONFIGURATION%"
ECHO # Project settings>>"%CONFIGURATION%"
ECHO # Batch file will use those values to create Bamcompile project file (bcp).>>"%CONFIGURATION%"
ECHO PROJ_NAME=xzbase64>>"%CONFIGURATION%"
ECHO.>>"%CONFIGURATION%"
ECHO # Final executable will have this icon>>"%CONFIGURATION%"
ECHO PROJ_ICON=program.ico>>"%CONFIGURATION%"
ECHO.>>"%CONFIGURATION%"
ECHO # Folder which contains source files (including MAINFILE below), this will embed it into final executable>>"%CONFIGURATION%"
ECHO EMBED=src>>"%CONFIGURATION%"
ECHO.>>"%CONFIGURATION%"
ECHO # Main PHP file - this one will be executed>>"%CONFIGURATION%"
ECHO MAINFILE=xzbase64.php>>"%CONFIGURATION%"
ECHO.>>"%CONFIGURATION%"
ECHO # Compress with UPX - true or false>>"%CONFIGURATION%"
ECHO COMPRESS=true>>"%CONFIGURATION%"
IF EXIST "%CONFIGURATION%" ECHO File created& GOTO :eof
ECHO Failed to create configuration file with default values. Check permissions.
ECHO Program terminated.
ECHO.
PAUSE
GOTO EXIT

:CREATE_BCP
ECHO ; Bamcompile project file>%PROJ_BCP%
ECHO ; By xZero>>%PROJ_BCP%
ECHO mainfile %MAINFILE%>>%PROJ_BCP%
ECHO embed %EMBED%>>%PROJ_BCP%
ECHO icon %PROJ_ICON%>>%PROJ_BCP%
IF "%UPX_COMPRESS%"=="true" SET UPX_COMPRESS_OUT=compress
ECHO %UPX_COMPRESS_OUT%>>%PROJ_BCP%
IF EXIST "%PROJ_BCP%" ECHO %PROJ_BCP% created!&GOTO :eof
ECHO Failed to create Bamcompile project file. Check permissions.
ECHO Program terminated.
ECHO.
PAUSE
GOTO EXIT

:DELETE
SET DEL_STATUS=true
DEL/F/S/Q "%~1">NUL
IF EXIST "%~1%" SET DEL_STATUS=false
GOTO :eof