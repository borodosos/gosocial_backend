## Project deployment

-   Installing dependencies from lock file.

    > **composer install**

-   Passport's service provider registers its own database migration directory, so you should migrate your database after installing the package.

    > **php artisan migrate**

-   Create the encryption keys needed to generate secure access tokens.

    > **php artisan passport:install**

    You'll receive password access client and password grant client:

    ![logo](https://i.stack.imgur.com/8d7Xp.png).

    **You need password grant client**.

    After generation, add **CLIENT_ID** and **CLIENT_SECRET** of _password grant client_ to _.env_:

    ```
    CLIENT_ID='YOUR_CLIENT_ID'
    GRANT_PASSWORD='YOUR_CLIENT_SECRET'
    ```

-   Generate application key.

    > **php artisan key:generate**
