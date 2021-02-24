## installation

```
composer install
./bin/console doctrine:migrations:migrate
./bin console doctrine:fixtures:load
symfony serve or php -S 127.0.0.1:8888 -t public
```

## what's inside

:warning: not a state-of-the-art example - just the fastest way to achieve minimum functionality with minimal effort 

* basic auth demo (via login form)
* basic users (doctrine entity with sqlite db as a backend)
* remember me enabled (disabled at `basic` tag)
* /password (with horrible form even without csrf) to change password for current user
* one user (admin:12345) out-of-the-box provided with fixtures

## testing scenario

### with remember me
* go to / - see that you are anon
* go to /login and login with username/password `admin`/`1235`
* observe that you are logged in and have `PHPSESSID` and `REMEMBERME` cookies
* repeat the same in another browser
* observe the same
* refresh page a couple of times. observe that session is alive, and you are still logged in
* delete `PHPSESSID` cookie, reload a page. observe that remember me functionality is working correctly
* go to /password
* change your password to anything
* reload your another browser, observe that you are "logged out" now

### without remember me

* checkout to `basic` tag (without remember me functionality)
* repeat the process from "with remember me" section, skipping checks of remember me