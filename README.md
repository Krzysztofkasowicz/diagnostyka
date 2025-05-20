## How to launch a project?

1. **Sklonuj repozytorium:**

    ```bash
    git clone https://github.com/Krzysztofkasowicz/diagnostyka.git
    cd diagnostyka
    ```

2. **Skopiuj plik `.env.example` do `.env`:**

    ```bash
    cp .env.example .env
    ```

3. **Uruchom composer install**

    ```bash
    composer install
    ```

4. **Uruchom kontenery Dockera:**

    ```bash
    ./vendor/bin/sail up -d
    ```

5. **Wygeneruj klucz aplikacji:**

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6. **Uruchom migracje:**

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

## Dostępne endpointy API

### Kategorie

* `GET /api/categories` - Pobranie listy wszystkich kategorii.
* `POST /api/categories` - Utworzenie nowej kategorii.
* `GET /api/categories/{category}` - Pobranie szczegółów konkretnej kategorii (zastąp `{category}` ID kategorii).
* `PUT/PATCH /api/categories/{category}` - Aktualizacja istniejącej kategorii (zastąp `{category}` ID kategorii).
* `DELETE /api/categories/{category}` - Usunięcie konkretnej kategorii (zastąp `{category}` ID kategorii).

### Produkty

* `GET /api/products` - Pobranie listy wszystkich produktów.
* `GET /api/products?categoryId={categoryID}` - Pobranie listy wszystkich produktów dla podanej kategorii.
* `POST /api/products` - Utworzenie nowego produktu.
* `GET /api/products/{product}` - Pobranie szczegółów konkretnego produktu (zastąp `{product}` ID produktu).
* `PUT/PATCH /api/products/{product}` - Aktualizacja istniejącego produktu (zastąp `{product}` ID produktu).
* `DELETE /api/products/{product}` - Usunięcie konkretnego produktu (zastąp `{product}` ID produktu).
