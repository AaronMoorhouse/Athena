SELECT
  t1.discussion_id,
  subject,
  t1.user_id,
  team_id,
  users.first_name,
  users.surname,
  disc_type,
  created
FROM (SELECT
  discussions.discussion_id,
  subject,
  user_id,
  team_id,
  disc_type,
  created
FROM discussions
INNER JOIN teams_discussions
  ON discussions.discussion_id = teams_discussions.discussion_id) AS t1
INNER JOIN users
  ON t1.user_id = users.user_id
WHERE t1.discussion_id = :id