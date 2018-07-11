База данных пользователей хранится в Redis.
Для каждого пользователя хранятся следующие поля:

```yaml
Id
name
email
password_hash
```

Необходимо выполнить авторизацию пользователя по email и паролю (для комбинации email, password_hash получить данные пользователя).

```php
/**
 * Creates new user
 *
 * @param array $user_data          User data contains the following fields:
 *                                      - name
 *                                      - email
 *                                      - password_hash
 *
 * @return string                   Returns ID of created user
 *
 * @throws \UserExistsException     Throws exception if user with this email already exists
 *
 */
function create_user(array $user_data)
{
    // your code here
}

/**
 * Finds user by combination of email and password hash
 *
 * @param string $email
 * @param string $password_hash
 *
 * @return string|null                   Returns ID of user or null if user not found
 */
function authorize_user($email, $password_hash)
{
    // your code here
}
```
