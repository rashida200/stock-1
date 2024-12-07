# Stock Management System

## Installation Guide

Follow these steps to install the Stock Management System on your local machine.

### 1. Clone the Repository

Open your terminal and run the following command to clone the repository:

```bash
git clone https://github.com/rashida200/stock-1.git
```

### 2. Navigate to the Project Folder

After cloning, go to the project directory:

```bash
cd repo
```

### 3. Install PHP Dependencies

Ensure that you have Composer installed on your machine. Then, install the required PHP dependencies:

```bash
composer install
```

### 4. Set Up the `.env` File

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Open the `.env` file and update the following database settings:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Generate the Application Key

Run the following command to generate the Laravel application key:

```bash
php artisan key:generate
```

### 6. Set Up the Database

Create a database on your local machine and update the `.env` file with the correct credentials.

### 7. Run Migrations

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

### 8. Seed the Database (Optional)

If your project includes seeders, you can populate the database with sample data:

```bash
php artisan db:seed
```

### 9. Install Frontend Dependencies (Optional)

If your project has frontend assets (e.g., Tailwind CSS), run the following to install the Node.js dependencies:

```bash
npm install
```

Then, compile the assets:

```bash
npm run dev
```

### 10. Serve the Application

To run the Laravel development server, use the following command:

```bash
php artisan serve
```

Your application will now be accessible at `http://localhost:8000`.

---

That's it! The Stock Management System should now be set up and running on your local machine.
