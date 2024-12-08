```bash
git clone https://github.com/rashida200/stock-1.git
```

```bash
cd stock-1
```

```bash
composer install
```

```bash
cp .env.example .env
```

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

```bash
npm install
```


```bash
composer run dev
```