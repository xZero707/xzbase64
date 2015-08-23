# xzbase64
Flexible yet powerful base64 encode/decode CLI tool

----------

* **Latest version:** 1.0.3
* **Written in:** PHP
* **Platform:** Cross-platform (released [binaries for Windows](https://github.com/xZero707/xzbase64/releases))
* **Windows binaries:** https://github.com/xZero707/xzbase64/releases(1.0.3.109)

**Compiled releases version scheme:**
X.X.X.B
+ X are version numbers
+ B is a build number of version specified | Build is every single compilation after minor changes

**Source version scheme:**
+ Classical X.X.X

----------
xzbase64 is actualy an fork from another batch tool (however it's completely written from scratch).
While I was working on that tool I wanted external, command-line tool for base64 encoding/decoding tasks. 
Since I wasn't able to find flexible base64 tool on internet which suits my needs, I decided to create my own, so there is it.
 
xzbase64 tool is binary safe, so you even may use it for base64 encoding whole executables and binary files in general, and then decoding it back to 
undamaged and fully fuctional files. 
+ You may save results from file
+ You may load input from file
+ You may do both at same time
+ You may read and write to same file at same time as read/write is done asynchronously.
+ You may enter input directly as parameter
+ You may output directly to console instead of file.
 
```
Type xzbase64 -help or /help or /? for usage help
Type xzbase64 -help or /help or /? -file [optional: filename]   < This will extract help to default file xzbase64_help.txt or as you specify.
```

**Windows specific *(until there is more builds for different OS-es)*:**
```
Check regulary for updates by runing 
xzbase64 --update-check 
Or xzbase64 --update-check  --and-update  (This will download and install update automatically.)
 ```

 
**Known issues *(unfixed bugs)*:**
+ Memory intensive for encoding big files (Eg. It take about 200MB for encoding/decoding 100MB file) | Unlikely to be fixed due to it's nature
+ May fail miserably if not enough RAM available (related to memory intensive)


**How to compile it yourself?**

If you have modified original source or for some other reason don't want to use [precompiled binaries](https://github.com/xZero707/Bamcompile/releases), take a look at **[COMPILATION.MD](https://github.com/xZero707/xzbase64/blob/master/COMPILATION.MD)** for detailed instructions.


**You have contributed?**

Then just include modification of [AUTHORS.MD](https://github.com/xZero707/xzbase64/blob/master/AUTHORS.MD) (add your self) in commit. I'll be very happy to add you as well.
For formatting, please follow existing entries.




**LICENSE AGREEMENT**

Read it here: [LICENSE](https://github.com/xZero707/xzbase64/blob/master/LICENSE)
