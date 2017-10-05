SELECT
  task_id,
  tasks.team_id,
  task_name,
  team_name,
  start_date,
  end_date,
  completed
FROM tasks
INNER JOIN teams
  ON tasks.team_id = teams.team_id
WHERE user_id = :id AND completed = 0