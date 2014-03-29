USE thenewd1_btl;

CREATE TABLE time_User
(
	UserId int NOT NULL AUTO_INCREMENT,
	Username varchar(255) NOT NULL,
    Email varchar(255) NULL,
	Password varchar(255) NOT NULL,
    TogglToken varchar(255) NULL,
	PRIMARY KEY (UserId),
	CONSTRAINT uc_time_User_Username
		UNIQUE (Username),
    CONSTRAINT uc_time_User_TogglToken
        UNIQUE (TogglToken)
) ENGINE=InnoDB;

INSERT INTO time_User (Username, Email, Password, TogglToken) 
VALUES
(
	'Julian',
    'julian@bluetonguelabs.com',
	'BlueTongue',
    '9db008a3306bce4cf0b2313e5a2dec75'
),
(
	'Gemma',
    'gemma@bluetonguelabs.com',
	'BlueTongue',
    NULL
),
(
	'Damien',
    'alairian@gmail.com',
	'BlueTongue',
    NULL
),
(
	'Naydeen',
    'n.lewis211212@gmail.com',
	'BlueTongue',
    NULL
),
(
	'Tim',
    'tdabbs@optusnet.com.au',
	'BlueTongue',
    NULL
);

CREATE TABLE time_Business
(
	BusinessId int NOT NULL AUTO_INCREMENT,
	Name varchar(255) NOT NULL,
	PRIMARY KEY (BusinessId),
	CONSTRAINT uc_time_Business_Name
		UNIQUE (Name)
) ENGINE=InnoDB;

INSERT INTO time_Business (Name) 
VALUES
(
	'BlueTongue Labs'
),
(
	'BlueTongue Kids'
),
(
	'BlueTongue Events'
),
(
	'BlueTongue Media'
);

CREATE TABLE time_Project
(
	ProjectId int NOT NULL AUTO_INCREMENT,
	BusinessId int NOT NULL,
	Name varchar(255) NOT NULL,
	PRIMARY KEY (ProjectId),
	CONSTRAINT fk_time_Project_BusinessId
		FOREIGN KEY (BusinessId)
			REFERENCES time_Business(BusinessId)
			ON DELETE RESTRICT
			ON UPDATE CASCADE,
	CONSTRAINT uc_time_Project_BusinessId_Name
		UNIQUE (BusinessId, Name)
) ENGINE=InnoDB;

INSERT INTO time_Project (BusinessId, Name) 
VALUES
(
	1, 'General'
),
(
	2, 'Surprise boxes'
),
(
	2, 'Light bars'
),
(
	3, 'Photobooth'
);

CREATE TABLE time_Log
(
	LogId int NOT NULL AUTO_INCREMENT,
	UserId int NOT NULL,
	Date datetime NOT NULL,
	Hours decimal(7,3) NOT NULL,
	ProjectId int NOT NULL,
	Task varchar(1000) NOT NULL,
	CreatedTime timestamp DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (LogId),
	CONSTRAINT fk_time_Log_UserId
		FOREIGN KEY (UserId)
			REFERENCES time_User(UserId)
			ON DELETE RESTRICT
			ON UPDATE CASCADE,
	CONSTRAINT fk_time_Log_ProjectId
		FOREIGN KEY (BusinessId)
			REFERENCES time_Project(ProjectId)
			ON DELETE RESTRICT
			ON UPDATE CASCADE
) ENGINE=InnoDB;