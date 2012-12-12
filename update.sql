ALTER TABLE trustees ADD billingLabel VARCHAR(255) DEFAULT NULL, CHANGE accountNumber accountNumber INT DEFAULT NULL;
ALTER TABLE doors ADD billing_prelabel LONGTEXT DEFAULT NULL
