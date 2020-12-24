# PressToPizza

## What is this

A repository for a school project. The main goal was to create an online pizza shop.
You want to be able to

- Register
- Log in
- Order a pizza

Admins can archive the orders when they're done.

## Getting started

- `cp .env.example .env`
- Fill the `.env` file
- `php bin/console doctrine:database:create` > Create the db. If you already have one, skip this step
- `php bin/console doctrine:migrations:migrate` > Launches the migrations
- `php bin/console doctrine:fixtures:load` > Creates the first pizzas and ingredients
- `symfony server:start`
- Enjoy
