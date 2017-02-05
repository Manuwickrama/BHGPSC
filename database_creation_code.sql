CREATE TABLE `GenieStat`.`OnlineBookings` ( `ptCount` INT NULL COMMENT
'Number of Patients' , `id` INT NOT NULL AUTO_INCREMENT COMMENT
'Primary Key' , `year` INT NOT NULL COMMENT 'Year' , `month` ENUM('Jan
','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')
NOT NULL COMMENT 'Month' , `clinic` ENUM('GPSC','SMC','BHMC') NOT NULL
COMMENT 'Clinic Code' , `timestamp` TIMESTAMP on update
CURRENT_TIMESTAMP() NOT NULL DEFAULT CURRENT_TIMESTAMP() COMMENT 'Time
Stamp' , PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'Online
Bookings Patient Count Table';
