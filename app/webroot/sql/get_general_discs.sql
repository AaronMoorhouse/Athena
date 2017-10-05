SELECT
  discussion_id,
  subject,
  users.user_id,
  users.first_name,
  users.surname,
  created,
  users.colour
FROM discussions
INNER JOIN users
  ON discussions.user_id = users.user_id
 WHERE disc_type = 'General'
ORDER BY created DESC