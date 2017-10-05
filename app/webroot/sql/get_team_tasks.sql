SELECT
  task_id,
  team_id,
  task_name,
  start_date,
  end_date,
  tasks.user_id,
  first_name,
  surname,
  completed
FROM tasks
INNER JOIN users
  ON tasks.user_id = users.user_id
WHERE tasks.team_id = :id
ORDER BY start_date