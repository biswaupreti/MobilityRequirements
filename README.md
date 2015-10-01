# MobilityRequirements

Project Set Up Note:
After cloning the project in your local server perform the following steps to make it workable:
 - Download and install the composer in your system. (Ref: https://getcomposer.org/) 
 - Duplicate .env.example file and rename it as .env and update the necessary configuration values
 - Create a database in mysql as named in .env file
 - Run the migration script to import the database. Use command "php artisan migrate". 
 - You are good to go.