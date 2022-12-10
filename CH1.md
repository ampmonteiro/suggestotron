# Chapter 1 - Setup the enviornment

## Goals

- choose tools for setup the enviornment
- setup the enviornment
- show php simple program running

## Tools

- Tools like XAMP / MAMP / WAMP
- Docker
- PHP: 8.1
- DB: MySQL 8
- Editor: VS Code ( or other of your choise)

### With XAMP / WAMP / MAMP

- simple to setup ( because already with need tools like Server and DB)
- if you are not using Linux base OS
- if you dont have experience with docker (Which is available in any OS)

### With Docker

- It is recommend if you have some experience with Docker
- its is recommend if you are you using linux based OS
- if you are using windows 10+ with WSL2 installed, with PowerSHell and terminal App
- link: [Get Docker](https://docs.docker.com/get-docker/)

### Instrutions / Setps for Docker users

1. Copy the Docker file available in the github repo
2. Build image: `docker build -t  php:suggestron`
3. Install the recommend extensions of you are using vs code ( read README.md file)

### Project

- create suggestron folder ( if using other tools see where to create this folder )
- inside of the folder create index.php file with following code:

  ```php
    # suggestron/index.php
    <?php

    phpinfo();

  ```

- for docker user, on terminal inside of suggestron folder:
  ```
  docker run --name app-suggestron -d -v $(pwd)/:/var/www/html -p 80:80 php:suggestron
  ```
- Point your web browser to `localhost`

- You will see something like:

![PHP info](/start.png 'Simple Program')

### Explanation

We now have a running PHP server, showing the configuration of our PHP installation.

Any changes you make from now on will be immediately visible simply by refreshing your browser.

Note:

- `if you are not using docker, just run in you browser localhost/suggestron/`
- if you are using docker, use `dev container` extension, to dev inside container
