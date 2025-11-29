# Helpdesk Api

## How To Deploy

### For first time only !



- `git clone https://github.com/Gobozzz/helpdesk-api.git helpdesk`
- `cd helpdesk`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `composer setup`

### From the second time onwards

`docker compose up -d (The workers are turned on automatically)`

### env.example -> .env

`cp .env.example .env`

### Laravel App
- URL: http://localhost
