# Laravel practice project

Project's purpose is to practice using Laravel framework.

## Features

1. Standard auth
2. Two roles `client` and `manager`   
2. Client can create application
3. Email is sent to manager when application is created   
4. Client can view his applications
5. Manager can view all applications
6. Manager can mark application as "responded"

## Setup

To set up project on your computer you need `docker` and `docker-compose` installed on your computer.
Then just run:
`sail up`  
`sail php artisan migrate`
`sail php artisan db:seed`
We finished set up. Got to `http://localhost`

### Redis queue setup

- `.env` set `QUEUE_CONNECTION=redis`
- run worker `sail php artisan queue:work`

### Mail catcher

To see that emails are sent got to `http://localhost:8025/`

### Credentials to login as `manager`

login:      `manager@test.com`
password:   `password`

### To run tests

`sail test`
