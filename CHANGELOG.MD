Schema:
X.X.X.B

X - Version numbers
B - Build number (binaries)

Version 1.0.4.12
- Version 1.0.4.1 -> 1.0.4.12 = Minor changes and improvements with each build - described below
- Fixed bug: Wrong version shown in help file
- Fixed bug: Encoding of big files (400MB+) - sometimes output contain NUL
- Fixed bug: Unexpected error on decrypting big files (400MB+)
- Added: Parameter checking against internal COMMANDS_DB / Wrong parameters now outputs errors
- COMP: Executable packing optimization 
 
 
Version 1.0.3.109
- Version 1.0.3.1 -> 1.0.3.109 = Minor changes and improvements with each build - described below
- Fixed bug: Output Success even if file writing to root partition failed due to insufficient permissions
- Fixed bug: Empty output if writing to file fails due to insufficient permissions
- Major changes to function responsible for file writing
- Improvements: Auto-update engine
- Update engine now shows status
- Optimization(s) for even faster execution
 
 
Version 1.0.2.83
- Version 1.0.2.1 -> 1.0.2.83 = Minor changes and improvements with each build - described below
- Fixed bug: Encoded file output is damaged (only alphanumerical)
- Fixed bug: No spaces accepted in file names
- Major changes to the code
- Added -s parameter - Suppressing program status output | Will not affect base64 output.
- Added posibility to save output to file
- Removed -nb parameter for directly modificating program output as unnecessary and problematic
- All parameters are now shorter
- Code optimization for supporting larger files
- Fixed bug: Doesn't works with absolute paths
- Added update check and auto update feature
- Fixed bug: No output if output: -fl:filename is not defined properly (Eg. -fl or -fl:)
 
Version 1.0.1.5
- Version 1.0.2.1 -> 1.0.1.5 = Minor changes and improvements with each build - described below
- Fixed bug: Unable to write to file
- Fixed bug: Failing to encode more than 10000 bytes
- Fixed bug: Decoding may fail if input is larger than 10000 bytes
- Optimized code
 
Version 1.0.0.1
- Initial release




