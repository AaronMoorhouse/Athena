SELECT
  users.user_id,
  first_name,
  surname,
  email,
  colour,
  admin_status
FROM users
INNER JOIN teams_users
  ON users.user_id = teams_users.user_id
WHERE team_id = :id
ORDER BY admin_status DESC, first_name ASC