SELECT
  user_id,
  first_name,
  surname
FROM users
WHERE first_name LIKE :string
OR surname LIKE :string
ORDER BY first_name ASC