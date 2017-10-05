SELECT
  invite_id,
  invites.team_id,
  team_name
FROM invites
INNER JOIN teams
  ON invites.team_id = teams.team_id
WHERE user_id = :id