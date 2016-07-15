' CREATED BY xZero
' CHECKSUM: NUL

set xZeroArgs=wscript.Arguments

if xZeroArgs.Count < 2 then
    WScript.Echo "Execution failed. Parameters missing."
    WScript.Echo "USAGE: " & Wscript.ScriptName & " [STATUS -pass|-fail] [version]"
    WScript.quit()
end if


DIM objFSO
Set objFSO = CreateObject("Scripting.FileSystemObject")

Dim sCurPath
sCurPath = CreateObject("Scripting.FileSystemObject").GetAbsolutePathName(".")

UpdVer = xZeroArgs(1)
If xZeroArgs(0) = "-pass" Then
x=msgbox("Update xzbase64 to version " & UpdVer & " complete!" ,64, "xzbase64 - Auto update")
else
x=msgbox("Errors ocurred with update xzbase64 to version " & UpdVer,48, "xzbase64 - Auto update")
End If



            


strScript = Wscript.ScriptFullName
objFSO.DeleteFile(strScript)
