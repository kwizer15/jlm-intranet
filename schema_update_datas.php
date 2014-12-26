<?php
$db = new mysqli('localhost','root','sslover','jlm');


$personQuery = "SELECT * FROM persons";


$contactId = 0;
$phoneId = 0;

$query = array(
'ALTER TABLE jlm.cities RENAME TO jlm.jlm_contact_city;',
'ALTER TABLE jlm.addresses RENAME TO jlm.jlm_contact_address;',
'ALTER TABLE jlm.calendar RENAME TO jlm.jlm_core_calendar;',
'ALTER TABLE jlm.countries RENAME TO jlm.jlm_contact_country;',
'ALTER TABLE jlm_core_calendar CHANGE dt dt DATE NOT NULL;',
'ALTER TABLE contracts CHANGE number number VARCHAR(255) NOT NULL;',
'ALTER TABLE intromodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE penaltymodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE delaymodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE introbillmodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE earlypaymentmodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE paymentmodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE propertymodel CHANGE text text LONGTEXT NOT NULL;',
'ALTER TABLE transmitters_model CHANGE text text LONGTEXT NOT NULL;',
'CREATE TABLE jlm_core_upload_document (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_contact_phone (id INT AUTO_INCREMENT NOT NULL, phone_id INT DEFAULT NULL, `label` VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_17C3A5BF3B7323CB (phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_contact (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_11D566613DA5256D (image_id), UNIQUE INDEX UNIQ_11D56661F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_contact_join_contact_phone (contact_id INT NOT NULL, phone_id INT NOT NULL, INDEX IDX_C2AE9B20E7A1254A (contact_id), UNIQUE INDEX UNIQ_C2AE9B203B7323CB (phone_id), PRIMARY KEY(contact_id, phone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_phone (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_association (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_corporationcontact (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, corporation_id INT DEFAULT NULL, position VARCHAR(255) NOT NULL, INDEX IDX_C1D14A97E7A1254A (contact_id), INDEX IDX_C1D14A97B2685369 (corporation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_corporation (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_person (id INT NOT NULL, title VARCHAR(4) NOT NULL, firstName VARCHAR(255) DEFAULT NULL, lastName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_contact_company (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_bill_join_bill_line (bill_id INT NOT NULL, billline_id INT NOT NULL, INDEX IDX_9D570A4E1A8C12F5 (bill_id), UNIQUE INDEX UNIQ_9D570A4EA3C9DCD7 (billline_id), PRIMARY KEY(bill_id, billline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'ALTER TABLE jlm_contact_contact_phone ADD CONSTRAINT FK_17C3A5BF3B7323CB FOREIGN KEY (phone_id) REFERENCES jlm_contact_phone (id);',
'ALTER TABLE jlm_contact_contact ADD CONSTRAINT FK_11D566613DA5256D FOREIGN KEY (image_id) REFERENCES jlm_core_upload_document (id);',
'ALTER TABLE jlm_contact_contact ADD CONSTRAINT FK_11D56661F5B7AF75 FOREIGN KEY (address_id) REFERENCES jlm_contact_address (id);',
'ALTER TABLE jlm_contact_contact_join_contact_phone ADD CONSTRAINT FK_C2AE9B20E7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'ALTER TABLE jlm_contact_contact_join_contact_phone ADD CONSTRAINT FK_C2AE9B203B7323CB FOREIGN KEY (phone_id) REFERENCES jlm_contact_contact_phone (id);',
'ALTER TABLE jlm_contact_association ADD CONSTRAINT FK_14EB6F52BF396750 FOREIGN KEY (id) REFERENCES jlm_contact_contact (id) ON DELETE CASCADE;',
'ALTER TABLE jlm_contact_corporationcontact ADD CONSTRAINT FK_C1D14A97E7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'ALTER TABLE jlm_contact_corporationcontact ADD CONSTRAINT FK_C1D14A97B2685369 FOREIGN KEY (corporation_id) REFERENCES jlm_contact_corporation (id);',
'ALTER TABLE jlm_contact_corporation ADD CONSTRAINT FK_6D44181DBF396750 FOREIGN KEY (id) REFERENCES jlm_contact_contact (id) ON DELETE CASCADE;',
'ALTER TABLE jlm_contact_person ADD CONSTRAINT FK_EB478A8CBF396750 FOREIGN KEY (id) REFERENCES jlm_contact_contact (id) ON DELETE CASCADE;',
'ALTER TABLE jlm_contact_company ADD CONSTRAINT FK_12088916BF396750 FOREIGN KEY (id) REFERENCES jlm_contact_contact (id) ON DELETE CASCADE;',
'ALTER TABLE technicians ADD contact_id INT DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL;',
'ALTER TABLE suppliers ADD contact_id INT DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL;',
'ALTER TABLE trustees ADD contact_id INT DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL;',
'ALTER TABLE site_contacts DROP FOREIGN KEY FK_3F0DAAA9217BBB47;',
'ALTER TABLE askquote DROP FOREIGN KEY FK_6B83768A217BBB47;',
'ALTER TABLE transmitters_ask DROP FOREIGN KEY FK_E9DDB4E4217BBB47;',
'ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4176FE013;',
'ALTER TABLE technicians DROP FOREIGN KEY FK_63FB4240BF396750;',
'ALTER TABLE suppliers DROP FOREIGN KEY FK_AC28B95CBF396750;',
'ALTER TABLE trustees DROP FOREIGN KEY FK_A8950608BF396750;',
'ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9217BBB47;',
'DROP INDEX UNIQ_1483A5E9217BBB47 ON users;',
'ALTER TABLE users CHANGE person_id contact_id INT DEFAULT NULL;',
'ALTER TABLE site_contacts ADD does INT DEFAULT NULL;',
'ALTER TABLE quote ADD does INT DEFAULT NULL;',
'ALTER TABLE users ADD does INT DEFAULT NULL;',
);

$phonesTypes = array('fixedPhone'=>'Fixe','mobilePhone'=>'Portable','fax'=>'Fax');

$persons = $db->query($personQuery);


while ($person = $persons->fetch_array())
{
  $contactId++;
  $person['firstName'] = str_replace('"','',$person['firstName']);
  $person['lastName'] = str_replace('"','',$person['lastName']);
  $name = trim(strtoupper($person['lastName']).' '.$person['firstName']);
  foreach ($person as $key=>$value)
  {
    if ($value == null)
    {
      $person[$key] = 'NULL';
    }
  }

  $person['email'] = ($person['email'] != 'NULL') ? '"'.$person['email'].'"' : $person['email'];
  $person['firstName'] = ($person['firstName'] != 'NULL') ? '"'.$person['firstName'].'"' : $person['firstName'];
  $query[] = 'INSERT INTO jlm_contact_contact (id,address_id, name, email, discr) VALUES ('.$contactId.','.$person['address_id'].',"'.$name.'",'.trim($person['email']).',"person");';
  $query[] = 'INSERT INTO jlm_contact_person (id, title, firstName, lastName) VALUES ('.$contactId.',"'.$person['title'].'",'.trim($person['firstName']).',"'.trim(strtoupper($person['lastName'])).'");';
  foreach ($phonesTypes as $phoneType => $label)
  {
    if ($person[$phoneType] != 'NULL' && $person[$phoneType] != '0100000000')
    {
       $phoneId++;
       $person[$phoneType] = str_replace(array('.',' '), '', $person[$phoneType]);
       $query[] = 'INSERT INTO jlm_contact_phone (id, number) VALUES ('.$phoneId.',"'.$person[$phoneType].'");';
       $query[] = 'INSERT INTO jlm_contact_contact_phone (id, phone_id, label) VALUES ('.$phoneId.','.$phoneId.',"'.$label.'");';
       $query[] = 'INSERT INTO jlm_contact_contact_join_contact_phone (contact_id, phone_id) VALUES ('.$contactId.','.$phoneId.');';
    }
  }

  if ($person['discr'] == 'technician')
  {
    $query[] = 'UPDATE technicians SET contact_id = '.$contactId.' WHERE technicians.id = '.$person['id'].';';
  }

// site_contact
$query[] = 'UPDATE site_contacts SET person_id = '.$contactId.', does = 1 WHERE person_id = '.$person['id'].' && does IS NULL;';
  if ($person['role'] != 'NULL')
  {
    $person['role'] = str_replace('"','',$person['role']);
    $query[] = 'UPDATE site_contacts SET role = "'.$person['role'].'" WHERE person_id = '.$contactId.' && does IS NOT NULL;';
  }

$query[] = 'UPDATE quote SET contactPerson_id = '.$contactId.', does = 1 WHERE contactPerson_id = '.$person['id'].' && does IS NULL;';
$query[] = 'UPDATE users SET contact_id = '.$contactId.', does = 1 WHERE contact_id = '.$person['id'].' && does IS NULL;';
// askquote
// transmitterask
// quote

}

$companyQuery = "SELECT * FROM companies";
$companies = $db->query($companyQuery);
$phonesTypes = array('phone'=>'Fixe','fax'=>'Fax');

while ($company = $companies->fetch_array())
{
  $contactId++;
  foreach ($company as $key=>$value)
  {
    if ($value == null)
    {
      $company[$key] = 'NULL';
    }
  }
  $company['email'] = ($company['email'] != 'NULL') ? '"'.$company['email'].'"' : $company['email'];
  $query[] = 'INSERT INTO jlm_contact_contact (id,address_id, name, email, discr) VALUES ('.$contactId.','.$company['address_id'].',"'.trim($company['name']).'",'.trim($company['email']).',"company")';
  $query[] = 'INSERT INTO jlm_contact_corporation (id) VALUES ('.$contactId.');';
  $query[] = 'INSERT INTO jlm_contact_company (id) VALUES ('.$contactId.');';
  foreach ($phonesTypes as $phoneType => $label)
  {
    if ($company[$phoneType] != 'NULL' && $company[$phoneType] != '0100000000')
    {
       $phoneId++;
       $company[$phoneType] = str_replace(array('.',' '), '', $company[$phoneType]);
       $query[] = 'INSERT INTO jlm_contact_phone (id, number) VALUES ('.$phoneId.',"'.$company[$phoneType].'");';
       $query[] = 'INSERT INTO jlm_contact_contact_phone (id, phone_id, label) VALUES ('.$phoneId.','.$phoneId.',"'.$label.'");';
       $query[] = 'INSERT INTO jlm_contact_contact_join_contact_phone (contact_id, phone_id) VALUES ('.$contactId.','.$phoneId.');';
    }
  }
  if ($company['discr'] == 'trustee')
  {
    $query[] = 'UPDATE trustees SET contact_id = '.$contactId.' WHERE trustees.id = '.$company['id'].';';
  }
  if ($company['discr'] == 'supplier')
  {
    $query[] = 'UPDATE suppliers SET contact_id = '.$contactId.' WHERE suppliers.id = '.$company['id'].';';
  }
}

$billLineQuery = "SELECT id, bill_id FROM bill_lines";
$billLines = $db->query($billLineQuery);
while ($billLine = $billLines->fetch_array())
{
	$query[] = 'INSERT INTO jlm_commerce_bill_join_bill_line (bill_line_id, bill_id) VALUES ('.$billLine['id'].','.$billLine['bill_id'].');';
}

$q2 = array(
'ALTER TABLE jlm_commerce_bill_join_bill_line ADD CONSTRAINT FK_9D570A4E1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id);',
'ALTER TABLE jlm_commerce_bill_join_bill_line ADD CONSTRAINT FK_9D570A4EA3C9DCD7 FOREIGN KEY (billline_id) REFERENCES bill_lines (id);',
'ALTER TABLE bill_lines DROP FOREIGN KEY FK_79F1D9081A8C12F5;',
'DROP INDEX IDX_79F1D9081A8C12F5 ON bill_lines;',
'ALTER TABLE bill_lines DROP bill_id;',	
'ALTER TABLE site_contacts DROP does ;',
'ALTER TABLE quote DROP does ;',
'ALTER TABLE users DROP does ;',
'ALTER TABLE technicians ADD CONSTRAINT FK_63FB4240E7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'CREATE INDEX IDX_63FB4240E7A1254A ON technicians (contact_id);',
'ALTER TABLE trustees ADD CONSTRAINT FK_A8950608E7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'CREATE INDEX IDX_A8950608E7A1254A ON trustees (contact_id);',
'ALTER TABLE site_contacts ADD CONSTRAINT FK_3F0DAAA9217BBB47 FOREIGN KEY (person_id) REFERENCES jlm_contact_person (id);',
'ALTER TABLE askquote ADD CONSTRAINT FK_6B83768A217BBB47 FOREIGN KEY (person_id) REFERENCES jlm_contact_person (id);',
'ALTER TABLE transmitters_ask ADD CONSTRAINT FK_E9DDB4E4217BBB47 FOREIGN KEY (person_id) REFERENCES jlm_contact_person (id);',
'ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4176FE013 FOREIGN KEY (contactPerson_id) REFERENCES jlm_contact_person (id);',
'ALTER TABLE users ADD CONSTRAINT FK_1483A5E9E7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'ALTER TABLE users DROP INDEX FK_1483A5E9E7A1254A, ADD UNIQUE INDEX UNIQ_1483A5E9E7A1254A (contact_id);',
'DROP TABLE companies_contacts;',
'DROP TABLE companies;',
'DROP TABLE persons;',
'DROP TABLE fees_follower2;',
'ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95CE7A1254A FOREIGN KEY (contact_id) REFERENCES jlm_contact_contact (id);',
'CREATE INDEX IDX_AC28B95CE7A1254A ON suppliers (contact_id);',
);
$query = array_merge($query, $q2);

foreach ($query as $q)
{
  if ($db->query($q) == false)
  {
    echo $q.chr(10);
  }
}

