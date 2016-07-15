# UPA Package - Documentation
For xzbase64 - (Can be adapted for any other software)

----------

**update_check.exe**
+ Is Batch file compiled with [Bat to Exe converter](http://www.f2ko.de/en/b2e.php). This file is executed after SFX archive is extracted. For batch source code, please navigate [here](https://github.com/xZero707/xzbase64/blob/master/UPA_Package/sources/update_check.cmd).

**d78dfbc50f097f57.xzr**
+ Is actualy an .exe file originaly named md5sum.exe and calculates md5 sum for specified files. I do not own source nor I do remember where I got it from.

**_update.ini**
+ INI configuration file which carry information about new update. Used by **update_check.exe**
Must be updated accordingly with update.

**update_finish.vbs**
+ Does stuff batch alone can't do - alert messages. Used by **update_check.exe**

**Building UPA**

Now you're missing two files - xzbase64.exe and readme.txt. Those are packed together with files above.
Proceed to create new UPA with WinRar and in comment type this:
```
; UPA

Setup=update_check.exe
Silent=1
Overwrite=1
```

This configures SFX package to be silent, overwrite xzbase64 files without asking and at end executing **update_check.exe**
You also need to encrypt SFX archive with password and save password for later use (You need it for **update.json**).
Code/method above works with WinRar. If you're creating SFX archive with some other tool, then you may have to configure options manualy.

**LICENSE AGREEMENT**

Read it here: [LICENSE](https://github.com/xZero707/xzbase64/blob/master/LICENSE)
