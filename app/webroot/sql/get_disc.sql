SELECT
  discussion_id,
  subject,
  discussions.user_id,
  users.first_name,
  users.surname,
  created,
  disc_type
FROM discussions
INNER JOIN users
  ON discussions.user_id = users.user_id
WHERE discussion_id = :id