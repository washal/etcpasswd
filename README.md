/etc/passwd Analyzer
======================

Small utility to quickly analyze a *nix system's user accounts. 
The main reason to create this utility is to assist is automated review of the /etc/passwd file - primarily in environments with large number of user accounts configured.

Checklist:
------------

* Check for users with `uid=0` (root privileged users)
* Check for users with `gid=0` (users belonging to root group)
* Check for accounts with interactive logins

Author:
* Wasim Halani (washal) 
Blog: http://securitythoughts.wordpress.com
Twitter: @washalsec
