# PHP-Chat-Application-Backend-bunq


This is a backend for a chat application built using PHP, the Slim framework, and SQLite. The application allows users to create and join chat groups, send messages, and view messages within groups.

## Features

- Create and join public chat groups
- Send messages in groups
- List all messages within a group
- Store data in an SQLite database
- Simple RESTful JSON API

## Requirements

- PHP 7.4 or higher
- Composer
- SQLite

## Installation

1. **Clone the repository**:
   ```bash
   https://github.com/meenakundan/PHP-Chat-Application-Backend-bunq-.git
   cd PHP-Chat-Application-Backend-bunq-
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up the SQLite database**:
   - Create an empty `database.sqlite` file in the project root.
   - Run the following command to create tables:
     ```bash
     php -d extension=pdo_sqlite -d extension=sqlite3 create_tables.php
     ```

4. **Start the PHP development server**:
   ```bash
   php -d extension=pdo_sqlite -d extension=sqlite3 -S localhost:8080 -t public
   ```

## API Endpoints

### 1. Create a User
   - **Endpoint**: `POST /user`
   - **Request Body**:
     ```json
     {
       "username": "GroupName"
     }
     ```
   - **Response**:
     ```json
     {
       "status": "User added",
       "user_id": 1
     }
     ```
### 2. Create a Group
   - **Endpoint**: `POST /group`
   - **Request Body**:
     ```json
     {
       "name": "GroupName"
     }
     ```
   - **Response**:
     ```json
     {
       "status": "Group created",
       "group_id": 1
     }
     ```

### 3. Join a Group
   - **Endpoint**: `POST /group/{group_id}/join`
   - **Request Body**:
     ```json
     {
       "user_id": 1
     }
     ```
   - **Response**:
     ```json
     {
       "status": "Joined group"
     }
     ```

### 4. Send a Message
   - **Endpoint**: `POST /group/{group_id}/message`
   - **Request Body**:
     ```json
     {
       "user_id": 1,
       "message": "Hello, group!"
     }
     ```
   - **Response**:
     ```json
     {
       "status": "Message sent"
     }
     ```

### 5. List Messages in a Group
   - **Endpoint**: `GET /group/{group_id}/messages`
   - **Response**:
     ```json
     [
       {
         "id": 1,
         "message": "Hello, group!",
         "timestamp": "2024-11-05 18:40:07",
         "username": "User1"
       },
     ]
     ```

## Notes

- Ensure that the `Content-Type` header is set to `application/json` for all `POST` requests.
- To view line breaks in responses, `\n` will render in logs or consoles; use `<br>` tags for HTML rendering.

## License

This project is licensed under the MIT License.

---

This README provides essential information to get the project running and interact with the API. Let me know if you'd like to add anything specific!
