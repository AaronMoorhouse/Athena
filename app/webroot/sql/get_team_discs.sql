SELECT
  t1.discussion_id,
  subject,
  team_id,
  users.user_id,
  users.first_name,
  users.surname,
  created,
  users.colour
FROM (SELECT
  discussions.discussion_id,
  teams_discussions.team_id,
  discussions.user_id,
  subject,
  created
FROM discussions
INNER JOIN teams_discussions
  ON discussions.discussion_id = teams_discussions.discussion_id
WHERE disc_type = 'Team') AS t1
INNER JOIN users
  ON t1.user_id = users.user_id
WHERE team_id = :team