#CIS 475

### Docker based LAMP server
*WARNING:* Docker and Docker Compose must be installed to run server image!

1. Create .env file `cp .env.sample .env`
2. Add project settings in `.env` file
3. Start server `docker-comose up`

### Useful commands
Start server

`docker-compose up`

Start server in backgound

`docker-compose up -d`

Stop server 

`docker-compose down`

Rebuild Server

`docker-compose build`