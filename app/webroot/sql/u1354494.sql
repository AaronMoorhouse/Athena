DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS teams_discussions;
DROP TABLE IF EXISTS discussions;
DROP TABLE IF EXISTS teams_users;
DROP TABLE IF EXISTS teams;
DROP TABLE IF EXISTS users;

-- --------------------------------------------------------

--
-- Table structure for table teams
--

CREATE TABLE teams (
  team_id int(11) NOT NULL AUTO_INCREMENT,
  team_name varchar(50) NOT NULL,
  
  PRIMARY KEY (team_id)
);

--
-- Dumping data for table teams
--

INSERT INTO teams (team_id, team_name) VALUES
(1, 'Team Swag');

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  first_name varchar(30) NOT NULL,
  surname varchar(30) NOT NULL,
  email varchar(50) NOT NULL,
  password_bcrypt varchar(255) NOT NULL,
  last_login datetime,
  colour varchar(7),
  
  PRIMARY KEY (user_id)
);

--
-- Dumping data for table users
--

INSERT INTO users (user_id, first_name, surname, email, password_bcrypt, last_login, colour) VALUES
(1, 'Test', 'User', 'test@test.com', '$2y$12$dHUc31/.PBZTSaNwroDsuOuEzfsS/n.tfsk7ODUxMvxltYi.MD0cS', '2016-06-16 10:54:59', '#3a663d'),
(2, 'Aaron', 'Moorhouse', 'aaron.moorhouse95@gmail.com', '$2y$12$7UcguN0db6S2U/UY9x5FxeOkPIO/VpBsepq11tZZpsy.0KEyK94mC', '2017-02-10 10:59:55', '#cf000f');

-- --------------------------------------------------------

--
-- Table structure for table teams_users
--

CREATE TABLE teams_users (
  team_user_id int(11) NOT NULL AUTO_INCREMENT,
  team_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  admin_status int(11) NOT NULL DEFAULT 0,
  
  PRIMARY KEY (team_user_id),
  FOREIGN KEY (team_id) REFERENCES teams (team_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

--
-- Dumping data for table teams_users
--

INSERT INTO teams_users (team_user_id, team_id, user_id) VALUES
(1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table discussions
--

CREATE TABLE discussions (
  discussion_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  subject varchar(40) NOT NULL,
  created datetime NOT NULL,
  disc_type enum('General', 'Team') NOT NULL,
  
  PRIMARY KEY (discussion_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

--
-- Dumping data for table discussions
--

-- --------------------------------------------------------

CREATE TABLE teams_discussions (
  team_discussion_id int(11) NOT NULL AUTO_INCREMENT,
  team_id int(11) NOT NULL,
  discussion_id int(11) NOT NULL,
  
  PRIMARY KEY (team_discussion_id),
  FOREIGN KEY (team_id) REFERENCES teams (team_id) ON DELETE CASCADE,
  FOREIGN KEY (discussion_id) REFERENCES discussions (discussion_id) ON DELETE CASCADE
);

--
-- Dumping data for table discussions
--

-- --------------------------------------------------------

--
-- Table structure for table posts
--

CREATE TABLE posts (
  post_id int(11) NOT NULL AUTO_INCREMENT,
  discussion_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  content varchar(5000) NOT NULL,
  posted datetime NOT NULL,
  
  PRIMARY KEY (post_id),
  FOREIGN KEY (discussion_id) REFERENCES discussions (discussion_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

--
-- Dumping data for table posts
--

-- --------------------------------------------------------

--
-- Table structure for table tasks
--

CREATE TABLE tasks (
  task_id int(11) NOT NULL AUTO_INCREMENT,
  team_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  task_name varchar(100) NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  completed int(11) NOT NULL DEFAULT 0,
  
  PRIMARY KEY (task_id),
  FOREIGN KEY (team_id) REFERENCES teams (team_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

--
-- Dumping data for table tasks
--

INSERT INTO tasks (task_id, team_id, user_id, task_name, start_date, end_date) VALUES 
(1, 1, 2, "Example Task", "2017-02-17", "2017-03-14");

-- --------------------------------------------------------

--
-- Table structure for table invites
--

CREATE TABLE invites (
  invite_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  team_id int(11) NOT NULL,
  
  PRIMARY KEY (invite_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
  FOREIGN KEY (team_id) REFERENCES teams (team_id) ON DELETE CASCADE
);