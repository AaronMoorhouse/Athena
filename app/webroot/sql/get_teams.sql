SELECT
  teams.team_id,
  team_name
FROM teams
INNER JOIN teams_users
  ON teams.team_id = teams_users.team_id
WHERE user_id = :id