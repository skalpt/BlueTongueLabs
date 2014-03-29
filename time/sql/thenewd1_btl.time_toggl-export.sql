SELECT
	u.Email,
	b.Name AS 'Client',
	p.Name AS 'Project',
	l.Task AS 'Description',
	DATE(l.Date) AS 'Start date',
	'00:00:00' AS 'Start time',
	TIME(DATE_ADD('1970-01-01', INTERVAL l.Hours * 60 MINUTE)) AS 'Duration'
FROM
	time_Log l
		JOIN time_User u ON
			u.UserId = l.UserId
		JOIN time_Project p ON
			p.ProjectId = l.ProjectId
			JOIN time_Business b ON
				b.BusinessId = p.BusinessId
ORDER BY
	l.LogId;