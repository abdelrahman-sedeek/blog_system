# Blog Application

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/abdelrahman-sedeek/blog_system.git
  
2. Install dependencies:
    ```bash
    composer install
    php artisan key:generate
    npm install
3. Configure the .env file:
            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=blog
            DB_USERNAME=blog_goldady
            DB_PASSWORD=secret
4. Run migrations:
     ```bash
    php artisan migrate
5. Start the development server:
    ```bash
    php artisan serve

## API Endpoints
    `POST /api/register: Register a new user
    `POST /api/login: Login a user
    `GET /api/posts: Fetch all posts
    `POST /api/posts: Create a new post
    `GET /api/posts/{id}: Fetch a single post
    `PUT /api/posts/{id}: Update a post
    `DELETE /api/posts/{id}: Delete a post
    `GET /api/categories: Fetch all categories
    `POST /api/categories: Create a new category
    `GET /api/categories/{id}: Fetch a single category
    `PUT /api/categories/{id}: Update a category
    `DELETE /api/categories/{id}: Delete a category
## Running Tests
    Run the tests with the following command:
     ```bash
    php artisan test


