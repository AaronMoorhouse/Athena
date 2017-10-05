SELECT
  post_id,
  users.first_name,
  users.surname,
  users.colour,
  content,
  posted
FROM posts
INNER JOIN users
  ON posts.user_id = users.user_id
WHERE discussion_id = :id
ORDER BY posted ASC