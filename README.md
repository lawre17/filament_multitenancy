# Filament Multitenancy With Spatie Laravel-multitenancy package

-   This project implements multitenancy in Filament, a powerful PHP framework for building admin panels.
-   It uses the [Spatie Laravel-multitenancy](https://github.com/spatie/laravel-multitenancy) package.

-   The implementation is demonstrated with a simple Todo app using a Filament resource.
-   Note: This example does not follow the domain-driven tenancy model.

## Features

-   Multiple databases tenant management
-   Tenant-specific configurations
-   Seamless integration with Filament

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/lawre17/filament_multitenancy.git
    ```
2. Navigate to the project directory:
    ```bash
    cd filament_multitenancy
    ```
3. Install dependencies:
    ```bash
    composer install
    ```

## Usage

1. Set up your environment variables in the `.env` file.
2. Run the landlord database migrations and seed:
    ```bash
    php artisan migrate --seed --path=database/migrations/landlord --database=landlord
    ```
3. Run the tenants database migrations and seed:
    ```bash
    php artisan tenants:artisan "migrate --database=tenant --seed"
    ```
4. Start the development server:
    ```bash
    php artisan serve
    ```

## How it works

An event listener listens to the Filament Serving event and sets the current tenant. This is enforced by Spatie's middleware, which ensures that all authenticated routes are tenant-aware. A drawback is that the Users table is duplicated in both the tenant databases and the landlord database.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.

## License

This project is licensed under the MIT License.

## Contact

For any inquiries, please contact [email](mailto:lawlens12@gmail.com).
