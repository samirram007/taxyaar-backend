#### to update database or create a migration to database
as we have two database so we will do two things to transfer smooth transition </br>
1. create database taxyaar_help_center  // ** run this in database first
2. php artisan migrate --database=mysql

to run seeder
1. php artisan db:seed --class=DatabaseSeeder
