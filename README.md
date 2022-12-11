# Suggestron project in PHP ( you are in CH4)

- from the course / tutorial: **PHPBridge: Intro To PHP**
- original web page is not available, only cached one
- url from cached pages: [PHPBridge: Intro To PHP by web archive](https://github.com/tutsplus/php-fundamentals-2017)
- Thank you to [web archive.org](https://web.archive.org/)

## Goals

- relearning the fundaments of vanilla PHP
- improved original code by using modern PHP (8.1+) like strict types, type hinting, etc
- Using Composer tool for autoloading internal dependencies
- Using Docker to create the development environment
- To better developement it is taked advantages of this two wonderfull vscode extensions:
  - [Docker](hhttps://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker) (By Microsoft): to manage docker containers in vs code
  - [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) (By Microsoft): to use vscode inside of the container.

## Editor and Recommend extensions (Beside mention on goals section)

- Editor: [VS Code](https://code.visualstudio.com) (By Microsoft)

- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) (By Ben Mewburn)

- [PHP Namespace Resolver](https://marketplace.visualstudio.com/items?itemName=MehediDracula.php-namespace-resolver) (By Mehedi Hassan)

- [PHP Awesome Snippets](https://marketplace.visualstudio.com/items?itemName=hakcorp.php-awesome-snippets) (By HakCorp)

## How this project is organized

- this project is organized similar to original website
- each chapter is a git branch, with its own CH\*.md file with some steps and notes
- the expections are CH1 and CH2 that stay at main branch

## Differences between original and this project

- the original was setup with Vagrant tool, this will use Docker
- The lastest chapter will include some code improvements / refactors
- Composer configuration will be included

## PHP and DB

- PHP: 8.1
- DB: MySQL 8

## Notes

- to run this code DOCKER is not required, with this tools would be enough: XAMP, WAMP, MAMP, etc.
- Docker compose is not used here, since it is a simple and educational goals project
- if you are using MySQL as simple container, **don't forget to verify the ip address**

## Images:
