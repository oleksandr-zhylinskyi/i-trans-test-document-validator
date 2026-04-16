# Document Validator

## Design decisions

The factory exposes two methods to cover both use cases:

- `fromArray(array $rules)` — for a small, fixed set of tenants where rules can be wired up manually.
- `fromBelongsToTenant(BelongsToTenantInterface $context)` — for a larger number of tenants where rules are loaded from config files automatically.

Rules are kept intentionally thin. Heavier interfaces or abstract base classes would constrain flexibility as validation logic varies between tenants.

The interface surface may not be exhaustive, but it covers the current requirements. Callbacks were considered in a few places but left out as unnecessary complexity.

## Integration script

A small integration script is available at `integration/index.php` to exercise the full validation flow end-to-end.

## Usage

All commands run inside a Docker container via `docker compose`. See the `Makefile` for the full list:

```
make install        # composer install
make update         # composer update
make dump-autoload  # composer dump-autoload
make test           # run PHPUnit test suite
make integrations   # run the integration script
```

