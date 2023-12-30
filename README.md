# Raketech Challenge

## Commands

### Start the project
```shell
sail up
```

### Run tests
```shell
sail artisan test
```

### Run Development Environment
```shell
sail npm run dev
```

## Additional Information

### Project usage

- http://localhost:8000/
- There's a **"Login"** link in the header the redirects to Auth0 login page
- Once authenticated a **"Flags"** link appears in the header

### Architecture breakdown

- All business logic for the challenge is under `app/Raketech`
- There's a `config/flags.php` where is possible to select the default adapter (the first adapter to run) and others providers (adapter to serve as fallback)
- A new provider was created in `app/Provider/FlagServiceProvider.php` make all necessary bindings and create the fallback logic (this last part ideally should be in another class for Separation fo Concerns)
- Tests created in `tests/Feature/FlagTest.php`
- Flags endpoint in `routes/api.php` can be protected but the middleware is commented due to issues to integrate Auth0 authentication with Vue component
