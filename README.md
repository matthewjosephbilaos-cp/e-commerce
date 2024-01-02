# Laravel Application

## Local Development Environment

Docker is a pre-requisite for local development. Please install Docker Desktop for your operating system:

- Ubuntu: https://docs.docker.com/engine/install/ubuntu/ then make sure to follow the steps for post-installation here:
  https://docs.docker.com/engine/install/linux-postinstall/
- Windows (WSL): https://docs.docker.com/desktop/windows/wsl/
- Mac: https://docs.docker.com/desktop/install/mac-install/

After ensuring that you have Docker installed, clone this repository and follow the steps below.

Copy the `.env.example` file to `.env`:

```
cp .env.example .env
```

Run the following command to start the development environment:

```
make up
```

The web application should now be accessible at http://localhost.

Make sure to never run local PHP commands outside of the Docker container. To run a command inside the Docker container,
run:

```
make shell
```

For now, `tinker` requires a separate command to run:

```
make tinker
```

To stop the development environment, run:

```
make down
```

## Before making pull requests

Before making pull requests, make sure to run the following commands:

```
make phpcs
```

That command will run PHP Code Sniffer to check for any coding standards violations. If there are any violations,
you will need to fix them before making a pull request. Run the following command to fix the violations automatically:

```
make phpcbf
```

Also make sure to run the following command to run the tests:

```
make test
```

## Convenience Commands

The following commands are available for convenience:

- `make composer-install` - Run `composer install` inside the Docker container.
- `make composer-update` - Run `composer update` inside the Docker container.
- `make npm-install` - Run `npm install` inside the Docker container.
- `make npm-dev` - Run `npm run dev` inside the Docker container.
- `make npm-build` - Run `npm run build` inside the Docker container.
