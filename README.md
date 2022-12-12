# secret-santa-cli
Un secret santa en CLI pour Antoine BLUCHET, afin de faire un test technique le 12/12/22

```bash
cp .env.example .env
```

Install:

```bash
composer install
```

Create sqlite database:

```bash
touch database.sqlite
```

Run migrations:

```bash
symfony console doctrine:migrations:migrate
```
