# YOUGERV

Is a video streaming website created by [Gervic](https://www.facebook.com/gervic23) as part of portfolio written on [CodeIgniter 4](http://www.codeigniter.com) Framework.

## System Requirements
- PHP 7.0 or highter
- MYSQL or MARIADB
- or much better you use [XAMPP](https://www.apachefriends.org/i) for windows users.
- [FFMPEG](https://ffmpeg.org/)
- Node Package Manager (npm) from [Nodejs](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

## Installation
#### Download from Composer
```bash
$ composer create-project shogo23/yougerv
```

#### Clone from Github
```bash
$ git clone https://github.com/shogo23/yougerv.git
```

#### Clone from Bitbucket
```bash
$ git clone https://gervic23@bitbucket.org/gervic23/ci4.git
```

#### Or Download manualy
[From Github](https://github.com/shogo23/yougerv/archive/master.zip)

## Project Setup
#### Database
- Create a database any name you want.
- Rename env file to .env from root directory.
- Open .env file with your text editor. Find the database section and fill up your database credentials.
```bash
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = ci4
database.default.username = root
database.default.password = root
```

#### Database Migration and Seeding
Open your command terminal and run the following commands. This will create database tables and data.
```bash
$ php spark migrate
```
```bash
$ php spark db:seed MainSeeder
```

#### Setting up FFMPEG
Open .env file and locate the path of ffmpeg.exe and ffprobe.exe. This is my configuration...
```bash
# FFMPEG CONFIGURATION.
ffmpeg.binaries     = C:\ffmpeg-20200420-cacdac8-win64-static\bin\ffmpeg.exe
ffprobe.binaries    = C:\ffmpeg-20200420-cacdac8-win64-static\bin\ffprobe.exe
```

#### Setting up Required PHP and Javascript Libraries.
Setting up PHP Libraries (If you downloaded this project from composer, there is no need for this).
```bash
$ composer install
```
Setting up Javascript Libraries.
```bash
$ npm install
```
Setting up app.js and app.css bundle files. (/public/dist)
```bash
$ npm run production
```

#### Virtual Hosting
Open C:\Windows\system32\divers\etc\host and add this...
```bash
127.0.0.1           yougerv.test
```
Open C:\xampp\apache\conf\extra\httpd-vhost.conf if your are a xampp user and add this configuration.
```bash
<VirtualHost *:80>
    ServerAdmin youremail@email.com
    DocumentRoot "C:/xampp/htdocs/yougerv/public"
    ServerName yougervtest
    ServerAlias yougervtest
    ErrorLog "C:/xampp/htdocs/logs/error.log"
	CustomLog "C:/xampp/htdocs/logs/error.log" common
</VirtualHost>
```

#### Setting up $baseURL
Open /App/Config/App.php and change the value $baseURL to 'http://youegerv.test'

Restart apache2 and now you can access the website at http://yougerv.test

## Contact Author
Email me at gervic@gmx.com or message me on facebook at https://www.facebook.comn/gervic23