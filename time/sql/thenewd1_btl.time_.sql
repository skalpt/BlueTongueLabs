USE thenewd1_btl;

CREATE TABLE time_User
(
	UserId int NOT NULL AUTO_INCREMENT,
	Username varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	PRIMARY KEY (UserId),
	CONSTRAINT uc_time_User_Username
		UNIQUE (Username)
) ENGINE=InnoDB;

INSERT INTO time_User (Username, Password) 
VALUES
(
	'Julian',
	'B1u3T0n6u3!'
),
(
	'Gemma',
	'B1u3T0n6u3!'
),
(
	'Damien',
	'B1u3T0n6u3!'
),
(
	'Naydeen',
	'B1u3T0n6u3!'
),
(
	'Tim',
	'B1u3T0n6u3!'
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

CREATE TABLE time_Log
(
	LogId int NOT NULL AUTO_INCREMENT,
	UserId int NOT NULL,
	Date datetime NOT NULL,
	Hours decimal(7,3) NOT NULL,
	BusinessId int NOT NULL,
	Task varchar(1000) NOT NULL,
	CreatedTime timestamp DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (LogId),
	CONSTRAINT fk_time_Log_UserId
		FOREIGN KEY (UserId)
			REFERENCES time_User(UserId)
			ON DELETE RESTRICT
			ON UPDATE CASCADE,
	CONSTRAINT fk_time_Log_BusinessId
		FOREIGN KEY (BusinessId)
			REFERENCES time_Business(BusinessId)
			ON DELETE RESTRICT
			ON UPDATE CASCADE
) ENGINE=InnoDB;