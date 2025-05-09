# AxiomPro Sample Code

# Requirements

- PHP 8.*
- Composer
- extensions pdo_sqlite and fileinfo enabled

# Technologies

- Backend:
  - PHP 
  - Laravel
- Database:
  - SQLite

# Setup Instructions

1. Navigate to the /api/database folder.
2. Create an empty file named database.sqlite inside this folder.
3. Copy the absolute path of this new file.
4. Open the .env file in the /api folder and set the DB_DATABASE key with this absolute path.
5. Run composer install on /api folder.

Example:
DB_DATABASE=/full/path/to/api/database/database.sqlite

# Running the project

1. Navigate to api folder
2. Run the command 
  ```cmd 
  php artisan serve
  ```

# Testing the API

You can find a Postman collection and environment at the root of the project.
Import the provided collection into Postman to test the available API endpoints.
- Be sure to select the envrioment before test!
