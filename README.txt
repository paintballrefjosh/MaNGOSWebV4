// === MangosWeb v3.0.0 Beta 1 README === //

Please note that this is just a Beta readme and is not finished!
Also, there are many features in the site that arenent included yet, or that are unfinished
These will be finished by release!

Oficial support forums: http://keyswow.com/forums/

-- 1.1 Full Install --

	1.1a Requirements:
	
	Apache with Mysql & PhP support
	- Apache v2.2 or higher
	- MySQL 5 or higher
	- Php version 5.2.0 or higher
	- GD compiled into Php (In windows, enable GD exetension in php.ini file).

	1.1b Installing The Site
	
	NOTE: If you used v2 or older, use the "install/sql/delete_v2_tables.sql" before installing v3!

	1. Make sure all files are in the same folder under you "htdocs" or "www" folder
	2. Enter your site url in your Internet Browswer (Ex: http://yourdomain.com)
	3. You will be automatically redirected to the installer.
	4. Just follow the on screen instructions.
	5. On step 2, if you arent able to use mangosweb, you will see the reason why.
	6. Once completed, you need to edit line 3 of the installer. change "$disabled = FALSE;" to "$disabled = TRUE;"
	7. Go straight to the admin panel! and go to site config. Configure the site :P
	8. Go to Realms next, and for each realm you want users to use, you need to edit that realms DB information
		and turn "Site Enabled" from "Disabled" to "Enabled"
	

	1.1c How To Update
	1. Go to your Admin Control Panel and click "Check For Updates" on the last row.
	2. If there are any updates, it will show you a list of files that will be updated. Click "Update MangosWeb" to begin the update process.
	3. The update process is automatic and will end in just a few seconds. Once done click "Return"
	4. Continue the process untill there are no more updates. Its that easy.


-- 1.2 Upgrading From older versions of MangosWeb --
As of right now, it is impossible to use your old MangosWeb Enahnced tables. Because of this You will need to do a fresh install of v3.


-- 2.1 Setting up Remote Access --

	1. To setup remote access to your server, you must have it enabled in your server config. Its best to have it look like this:
		Console.Enable = 1
		Ra.Enable = 1
		Ra.IP = 0.0.0.0
		Ra.Port = 3443
		Ra.MinLevel = 3
		Ra.Secure = 1
		Ra.Stricted = 0

		SOAP.Enabled = 1
		SOAP.IP = 0.0.0.0
		SOAP.Port = 7878
	2. Next you need to create an account to be the remote access "bot" account. I found that with mangos especially, you need
		to create this account either A) Through the server console B) Through the site, then going into the DB and uppercasing
		the whole username... EX: test -> TEST.
	3. Go into the ACP -> Realms -> your realm name. Scroll down to the bottom where it says "Remote Access"
	4. Enter your information. the account name DOES NOT need to be in caps :)
	
-- 3.1 Setting the Donation System --

	1. If you dont already, create a premier paypal account. (It's free)
    2. From the PayPal menu, go to Profile > More Options > Under selling Preferences > Instant Payment Notification Preferences.
    3. Select Instant notification<br />
    4. Enter the full path including your domain name to ipn.php in the root of your
       MaNGOS directory. <br />
       Example: http://you-domain-or-ip/ipn.php
	5. In the ACP -> Site Config. Make sure you have the paypal email address set!
	6. To test using sandbox: 
		A) open 'ipn.php' and edit line 21: "$Paypal->testMode(FALSE);" set the FALSE to TRUE.
		B) Go to https://developer.paypal.com and create a developer account
		C) click "Simulate Instant Payment Notification"
		D) Click "eCheck Complete" and then Enter some random information and hit send
		E) You should get confirmation that the data was sent
		F) Check you DB "mw_donate_transactions" and you should see your test IPN there. If not then check the IPN Log
			"core/logs/ipn.txt"
		NOTE: Paypal sandbox has been really buggy lately. But i have tested the donation system myself over and over
			since re-writting it with no errors at all ;)
	
-- 4.1 Setting up Forum Bridges --

	1. In v3, I have included some php classes (Not written by me, credits are in the php class files themselves), that 
		will create forum accounts when a user logs into the site. If the account exists it will log the user in the forums 
		as well. Please note that i was only able to test the PHPBB3 bridge as i donot have vbulletin. But the vbulletin one should
		work just fine.
	2. Go to your ACP -> Site Config. In the sub nav click "Forum Integration Settings"
	3. You can only have ONE bridge enabled at a time!
	4. For the forum path, you must enter the the PATH, not the url! If the forum is NOT in the same htdocs or www folder as MangosWeb,
		then the bridge will not work!
	5. To test if the bridge works, logout and try to log back in the site. If a white screen displays, or there is an error,
		Then chances are your path is wrong. Dont worry, you will still be logged in the site, but not in the forums
	6. I Cant gaurenty results on the vBulletin bridge until users like yourself test it out. The PHPBB3 bridge has been tested and works.