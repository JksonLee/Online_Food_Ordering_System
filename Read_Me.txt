============================================================================================================
* Preparation Before Start The Online Food Ordering *
**********************************************
1) Open your XAMPP and start the Apache and MySQL first.

2) After MySQL is start, click on the "Admin" at XAMPP, it will redirect you to the phpMyAdmin page. In this page click on the
     "Database" tag at the top menu. At the create database area create a new database with the following information.
	/ Database Information /
	Database Name: online_food_order
	Type: uft8_general_ci

3) After the database is created, choose the "Import" tag at top menu and import the file which call sqlquery.txt.
	/ Database File /
	sqlquery.txt


4) After create a database table, make sure that you have unzip the OnlienFoodOrderingSystem_BAIT3137 Assignment_SourceCode folder
     and inside the have 4 things, which included Online_Food_Ordering_Client File, Online_Food_Ordering_Server File, 
     sqlquert.txt and Read_Me.txt

============================================================================================================
* Start The Online Food Ordering *
*****************************
1) Open a Command Prompt with Administrator, after that change the path to the assignment path where you put.
	/ Example Command /
	cd C:\Users\User\Downloads\OnlienFoodOrderingSystem_BAIT3137 Assignment_SourceCode\Online_Food_Ordering

2) After the Command Prompt path is change, run the code below to start the laravel server.
	/ Command /
	php artisan serve --port=8000

3) When the laravel server is start DO NOT close it and Open A New Command Prompt to run the code for run Vite.
	/ Command /
	npm run dev

4) After both Command Prompt is running, go to Google Chrome to paste the path show at First Command Prompt for start the 
Food Ordering Client Web Application. Please Login in first before do any action, except viewing the home page. 
Click on the top menu "Login" to login or signup your account.
** If you are a admin click on the Admin Login a href, and the system will redirect you to the Admin Login Page**
	/ Example Path of Food Ordering Client Web Application /
	http://127.0.0.1:8000

	/ Example of Customer Account /
	email: ali@gmail.com
	pw: ali123

	/ Example of Admin Account /
	email: admin@gmail.com
	pw: admin123

5) After Login, now you can play around and enjoy the Online Food Ordering System~