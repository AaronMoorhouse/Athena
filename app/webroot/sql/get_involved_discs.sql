SELECT DISTINCT
  discussion_id,
  creator,
  poster,
  subject,
  created,
  disc_type,
  first_name,
  surname,
  colour
FROM (SELECT
  discussions.discussion_id,
  discussions.user_id AS creator,
  posts.user_id AS poster,
  subject,
  created,
  disc_type
FROM discussions
INNER JOIN posts
  ON discussions.discussion_id = posts.discussion_id) AS t1
INNER JOIN users
  ON creator = users.user_id
WHERE poster = :id