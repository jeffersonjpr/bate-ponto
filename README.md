## Banco de dados
```bash
docker start servidor-mysql
```

## Dependências
```bash
composer require slim/slim
composer require slim/psr7
composer require selective/basepath
```
## Iniciar os servidores
```bash
php -S localhost:8000 -t Api/
php -S localhost:9000 -t Public/
```
