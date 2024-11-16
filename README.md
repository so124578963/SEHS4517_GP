a. STEP of deploy the project

1. put whole folder into C:\xampp\htdocs
e.g. C:\xampp\htdocs\SEHS4517_GP
2. open XAMPP, start Apache & MySQL
3. open browser, access http://localhost/phpmyadmin/
4. click "Import/匯入" on the top menu bar
5. upload the sql file "C:\xampp\htdocs\SEHS4517_GP\mysql\127_0_0_1.sql"
6. install Node.js on your PC
7. open cmd, run below command 
npm install express
npm install ejs
npm install cors
8. cd C:\xampp\htdocs\SEHS4517_GP
9. run "node server.js"
10. open browser, access http://localhost/SEHS4517_GP/

---------------------------------------------------------------------------------------------------

b. File Structure

1. action - the path when form submit
2. class  - PHP OOP coding to connect DB, create, update, select query
3. css    - external css files for web pages
4. images - web pages images files
5. js     - external js files for web pages, mainly jQuery + Ajax
6. mysql  - mysql query statement file
7. views  - Node.js EJS template files

index.html = 1st page
register.html = 2nd page
login.html = 3rd page
reservation.html = 4th page
server.js = Node.js 5th page