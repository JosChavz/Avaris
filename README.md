# Avaris
Avaris is an expiremental side project to better understand PHP, but overall, it is a budget tracking application. The whole idea is to make budgets for yourself throughout the month and organize it accordingly.

## Development

Please ensure to run the following commands:
```
npm install
npm run composer
```
This PHP project relies on TailwindCSS and Composer. Composer is used after creating or renaming files within the `src/partials` directory.

### Architecture

Definitions for constants and global variables can be found in `src/initialize.php` with common functions in `src/functions.php`.

- `public` : This directory will be exposed to the public domain
- `src` : The backend where all classes, partials, etc. is defined
  - `partials` : Reusable components to use in the frontend. *NOTE: Always include Partial in the filename, and please run the composer command to autoload the new partials.*
  - `js` : External JavaScript files that can be minified and included in the `public/js` directory by running `npm run build:js`
  - `templates` : Templates that are used such as a header, footer, main for its respected target such as dashboard or "logged-out" environment. Templates are defined in the frontend by including it to the very end of a page. Please reference any pages in `public` for example.
  - `middleware` : Yeah... not even used, lol.
  - `interfaces` : Why did I make this?
  - `enums` : Used for stricting type-safety in classes for custom MySQL data types.
  - `classes` : Mainly used for connecting with the database but also for the `Session` which is the way to store information to navigate around pages.

### API and Routing

Routing in terms of middleware is found in `public/router.php` but loads the `src/apiRoutes.php` and `src/routes.php` as those files are the definitions and `router.php` is the logic class in how to manage those definitions.

When creating a new page, it is important to also create its own route, but is critical when wanting to pass params as arguments such as `/dashboard/view/:id`.

There is no need to add the `.php` extension in a route as the `Router` will try to figure that out. Therefore both `/auth/login` and `/auth/login.php` are valid URLs as long as `/auth/login` route has been defined.

APIs work the same way as routes where the Router will know if it's an API call or not, and will have different logic in how to handle the two. 

### AuthGuard
This can be found in `/public/router.php` under the variable `$protectedDirs`. That way safe-guarding for every endpoint is not necessary. The schema is the following:

```
{
  dir : string
  roles : UserRoles | UserRoles[]
}
```

The `dir` is relative to the URL such as `/dashboard/`, `/api/`, etc. and requires both `/` beginning and end of the string. Roles can be found in `src/enums/UserRoles.php`. 

#### Creating New Javascript Files

Currently, this application does not use a lot of JavaScript files, but in the case of requiring a JS file, please add the source code in `src/js` and then run `npm run build:js` after being done. This project does use external NPM modules, but they are a little funky to use. 

Reference `src/js/bankgraph.js` as an example.

If a new file is created, please add it into the `vite.config.js` file under `input` object with the same syntax as the rest.

## Self-deployment

I, too, would be sketched out to give my spending habits to someone I don't know on the internet.

That is why I created a docker-composer.yaml file so that you can host it on your server.

***NOTE:** This project relies heavily on its .htaccess file, so please allow rewriting rules on Apache!* 

## Side Story

Avaris came from BudgetTrak, which is essentially the same concept, but in even more raw form of PHP and MySQL. There was some CSS, but it really looked something out of the early 1990s. All of this is only to practice PHP afterall, but I wanted to make something a bit more presentable...
That is when Avaris was born. I let AI pick the name, so don't come after me if a large corporation tries to sue me!

There are so many budget tracking apps out there, but as someone who had horrible money spending problems since my first paycheck at 16 *(I bought a Flash watch and took my mom out to get some pretzels and lemonade at the mall for my first paycheck)*. I thought it was only appropiate for me to make such an application. Perhaps then I will be able to handle my money a little wiser... Perhaps. Also, developing something is fun!


## Debugging

For this project, I use PHPStorm given that the docker container uses xdebug. In order to debug,
please do the following:

1. Run the `docker-compose.yaml` containers
2. Go to Settings > Servers > Create (+)
3. For the **_name_**, use the server name that was passed in the `docker-compose.yaml` file
   1. e.g. `PHP_IDE_CONFIG=serverName=php-app` would be `php-app` for the name 
4. For host and port, default by `localhost` and `80` unless changed. This is what you use to connect to the website
5. For mapping, unless changed from the `Dockerfile`, map your project to the app in the container
   1. e.g. `YOUR_REPO` and `/var/www/html`

Click on the phone on the toolbar to listen to any debugging calls... and that should be it!

### Issues

In the case that `npm run build:css` or `npm run watch:css` throws an error like:

```
thread '<unnamed>' panicked at /usr/local/cargo/registry/src/index.crates.io-6f17d22bba15001f/rayon-core-1.12.1/src/registry.rs:168:10:
The global thread pool has not been initialized.: ThreadPoolBuildError { kind: IOError(Os { code: 11, kind: WouldBlock, message: "Resource temporarily unavailable" }) }
note: run with `RUST_BACKTRACE=1` environment variable to display a backtrace
fatal runtime error: failed to initiate panic, error 5
Aborted (core dumped)
```

Please run `export RAYON_NUM_THREADS=1` to your CLI, or add to your ~/.zshrc or ~/.bashrc file, then source it.
