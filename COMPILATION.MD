COMPILATION INSTRUCTIONS
------------------------

Please note: This is for advanced users. If you didn't made any modifications to source and you don't wanna go through this process your self, then [download any of precompiled binary releases](https://github.com/xZero707/xzbase64/releases) for your OS (currently Windows only).

**What you will need:**
1. [Bamcompile - Bambalam PHP compiler/embeder (PHP 4.4.4)](https://github.com/xZero707/Bamcompile/releases)
2. xzbase64 src folder and files:
+ compile.bat (Batch file witch will execute all needed commands. Otherwise you have to.)
+ compile_config.ini (Settings from it are used to create Bamcompile project file BCP)
+ program.ico (Default icon file, or whatever icon you like but with that name, otherwise you must modify .ini(2.) to comply with changes)


**Let's start:**
1. Download latest release of Bamcompile
2. After download is finished, extract all Bamcompile files where you like.
3. In folder where your Bamcompile copy is, you will find Examples folder. Navigate to it.
4. Now create a new folder inside and name it xzbase64 (or however you'd like)
5. Navigate to newly created folder from previous step
6. Now, there place src folder and files compile_config.ini, compile.bat and program.ico
7. Execute file compile.bat
8. Compilation is done! Now you just need your executable, nothing else as everything needed is embedded already (this is not guaranteed if you used any other PHP compiler/embeder).


compile.bat have some parameters, so you may use them if needed:
```
compile.bat -bcponly    | Will only generate Bamcompile project file (BCP)
compile.bat -keepbcp    | Generated Bamcompile will be not treated as temporary file but keept instead
```