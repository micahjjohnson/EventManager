# EventManager
Git repo for 2018-19 senior design class, UC CECH IT.  James Allen, Micah Johnson, Zach Goodwin.

You need these to develop locally
---------------------------------
1. XAMPP or something similar- installs PHP and MYSQL
2. Make sure it's PHP 7 or higher
3. Git to connect to github
4. Access to TFS/VSTS 
5. Some code editor tool.  Notepad is too simple.  Use the tool maybe the book mentions.


Install XAMPP  
------------------------
https://www.apachefriends.org/download.html
version 7.2.10
start apache, and load "localhost" in browser

Install git for windows 
------------------------
from https://git-scm.com/downloads
version 2.19.0
open command prompt type git to test the install

Github repo
-----------
https://github.com/jamesallen74/EventManager/
See google drive for the steps to take for branching and pull requests


To update database
-------------------
1. Open XAMPP
2. Click on MySQL admin button
3. PHPMyAdmin opens
4. Open SQL Tab
5. Copy and paste the entire script from Database_Scripts/Sql_Script.1.txt into the SQL window
6. Hit GO


Local Setup
-----------
1. Add to hosts file on your machine (PC).  Micah, for Mac, you might want to see if this youtube video helps.  https://www.youtube.com/watch?v=78wFR5Rp_Mw  or https://www.youtube.com/watch?v=5hkyWkxFVLs

For PC, find HOSTS file in C:\Windows\System32\drivers\etc 
Copy to desktop, then open it in notepad
Add this to the bottom and save.
```
127.0.0.1   BRGEMS.LOCAL
```
Then delete the original hosts file in that \etc folder above, and drop and drop the updated hosts file into the hosts folder.


2. Add to httpd-vhosts.conf file this piece of XML at the bottom (Micah, I don't know what the path is for MAC)
Here is the location of httpd-vhosts.config
C:\xampp\apache\conf\extra
Don't forget to restart apache after you save the httpd-vhosts.config file

```XML
   <VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/EventManager/php"
    ServerName brgems.local
    <Directory "C:/xampp/htdocs/EventManager/php">
       Order allow,deny
       Allow from all
       # New directive needed in Apache 2.4.3: 
       Require all granted
    </Directory>
   </VirtualHost>
```
