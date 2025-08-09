# LocalAccommodationBundle

## Installation

1. Add the bundle to your Symfony project (via Composer):

   ```bash
   composer require slns/local-accommodation-bundle:dev-main
   ```

2. Make sure the bundle is registered in `config/bundles.php`:

   ```php
   LocalAccommodationBundle\\LocalAccommodationBundle::class => ['all' => true],
   ```

3. **Manually import the bundle routes:**

   Copy the bundle's routes file to your main project:

   ```bash
   cp vendor/slns/local-accommodation-bundle/config/routes.yaml config/routes/local_accommodation_bundle.yaml
   ```

   Or create the file `config/routes/local_accommodation_bundle.yaml` with the following content:

   ```yaml
   local_accommodation_bundle:
     resource: "@LocalAccommodationBundle/config/routes.yaml"
   ```

4. Clear the cache:

   ```bash
   php bin/console cache:clear
   ```

5. **Frontend assets (Tailwind, Stimulus, Vite):**

LocalaccommodationBundle includes modern assets (Tailwind CSS, Stimulus, Vite) to ensure a beautiful UI and interactivity even if your main project does not use these tools.

### How to build the bundle assets

1. Install the bundle dependencies (in the bundle folder):

   ```bash
   cd vendor/slns/local-accommodation-bundle
   npm install
   ```

2. Build the assets:

   ```bash
   npm run build
   ```

   The files will be generated in `public/build/local-accommodation-bundle`.

3. Make sure to include the bundle CSS/JS in your pages (Twig example):

   ```twig
   {{ asset('build/local-accommodation-bundle/app.css') | stylesheet }}
   {{ asset('build/local-accommodation-bundle/app.js') | script }}
   ```

   Or manually include the `<link>` and `<script>` tags in your base template.

> **Tip:** If your project already uses Vite/Tailwind/Stimulus, you can integrate the bundle assets into your own build, or override styles as needed.

---

## Post-install steps

1. **Generate the database migration:**

   In your main project, run:

   ```bash
   php bin/console make:migration
   php bin/console doctrine:migrations:migrate
   ```

   This will create and apply the `guest` and `accommodation` tables in your database.

2. **Test the full flow in the UI:**

   - Access `/local-accommodation/guests` and `/local-accommodation/accommodations` in your browser.
   - Test creating, editing, and deleting guests and accommodations.
   - Check that the UI is correct and data is persisted.

3. **Integrate the module into the menu/sidebar (optional):**

   The bundle provides automatic sidebar integration via `menu.yaml`. If you want to add a custom link, edit your menu template (e.g., `templates/components/sidebar.html.twig`) and add:

   ```twig
   <li>
     <a href="{{ path('local_accommodation_guests') }}" class="...">Guests</a>
   </li>
   <li>
     <a href="{{ path('local_accommodation_accommodations') }}" class="...">Accommodations</a>
   </li>
   ```

   If you want the bundle to add the menu automatically, see the documentation or request support.

---

Ready! The bundle's services, routes, UI, and database will be available and visually integrated.

## Uninstall

1. **Remove the bundle routes** before uninstalling:

   ```bash
   php vendor/slns/local-accommodation-bundle/scripts/remove_routes.php
   ```

2. Remove the bundle with Composer:

   ```bash
   composer remove slns/local-accommodation-bundle
   ```

3. The bundle and its services will no longer be available in your main project.
