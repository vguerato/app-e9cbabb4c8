## Requirements
- PHP 8.0 > 
- Composer
- Docker

## Running

```bash
./vendor/bin/sail up -d
```
Without Docker:
```bash
php artisan serve
```

## Testing
Open in browser http://localhost:8000

## Using CURL
Example:
```CURL
curl --location --request POST 'http://localhost:8000/api/import' \
--form 'file=@"/path/to/xml"'
```
