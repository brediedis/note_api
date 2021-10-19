# Note API

Symfony based note API. Provides API endpoints to create, read, update and delete notes.

## Setup

1. Install [docker](https://www.docker.com/get-started)
2. Start up docker compose instance - `docker-compose up --build -d`
3. Gain access to php bash shell - `docker exec -it php bash`
4. Go to root of symfony project - `cd code`
5. Install dependencies - `composer install`
6. Open site in browser [localhost:8001](http://localhost:8001)

## Tasks

1. Copy this repository to your own github.
2. Add phpmyadmin container to docker compose. Document access in README.md
3. Create Note entity. Note has id,title and text.
4. Make sure to generate migrations.
5. Write code for all routes in NoteController so that application fulfills CRUD tasks.
6. Create PR on your own repository describing changes and test scenarios.
7. Send us a link
