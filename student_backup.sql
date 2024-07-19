DROP TABLE IF EXISTS student;

CREATE TABLE `student` (
  `student_user` varchar(30) NOT NULL,
  `student_password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `duty_hrs` time NOT NULL,
  `student_status` varchar(25) NOT NULL,
  `title` varchar(25) NOT NULL,
  `school` varchar(25) NOT NULL,
  `section` varchar(15) NOT NULL,
  `room` varchar(20) NOT NULL,
  `yearlvl` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO student VALUES("@mitsu","12345","jerald@gmail","Jerald","Torres","08:44:00","active","Student","AU","S2","100","0");
INSERT INTO student VALUES("jerald","12345","mitzudagret@gmail.com","","","00:00:00","","","","","","0");
INSERT INTO student VALUES("@h","12345","@h","Torres","","00:00:00","pending","Student","2nd","12345","waiting","yearlvl");
INSERT INTO student VALUES("@asdas","12345","@asdas","JElrad","Torres","00:00:00","pending","Student","3rd","1234","waiting","yearlvl");
INSERT INTO student VALUES("asdsd","$2y$10$EQ3QuMMU.RacP87zUQzy2e6","asd@asd","ads","asd","00:00:00","approve","Student","asd","asd","waiting","3rd");



