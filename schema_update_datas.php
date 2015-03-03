<?php
$db = new mysqli('localhost','root','sslover','jlm');
$query = array();





$init = array(
'CREATE TABLE jlm_transmitter_product_transmitter (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_3EAD03534584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_daily_product_workshop (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_574DBA194584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_daily_product_work (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_9928F3964584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_event_follower (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_event_follower_join_event (event_follower_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_BCBDF267AD2BD3 (event_follower_id), UNIQUE INDEX UNIQ_BCBDF2671F7E88B (event_id), PRIMARY KEY(event_follower_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_quotevariant_join_quote_line (quotevariant_id INT NOT NULL, quoteline_id INT NOT NULL, INDEX IDX_E3936BAF11791C8 (quotevariant_id), UNIQUE INDEX UNIQ_E3936BA8EF03C82 (quoteline_id), PRIMARY KEY(quotevariant_id, quoteline_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_product_order (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_81D967244584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_commerce_event (id INT AUTO_INCREMENT NOT NULL, creation DATETIME NOT NULL, name VARCHAR(255) NOT NULL, options LONGTEXT NOT NULL COMMENT '(DC2Type:array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_follow_starter (id INT AUTO_INCREMENT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_follow_starterquote (id INT NOT NULL, variant_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_922C43943B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_follow_thread (id INT AUTO_INCREMENT NOT NULL, starter_id INT DEFAULT NULL, startDate DATETIME NOT NULL, UNIQUE INDEX UNIQ_CC1FDB58AD5A66CC (starter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
'CREATE TABLE jlm_follow_starterintervention (id INT NOT NULL, intervention_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_93A09CAC8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;',
);
$end = array(
'ALTER TABLE jlm_transmitter_product_transmitter ADD CONSTRAINT FK_3EAD03534584665A FOREIGN KEY (product_id) REFERENCES products (id);',
'ALTER TABLE jlm_daily_product_workshop ADD CONSTRAINT FK_574DBA194584665A FOREIGN KEY (product_id) REFERENCES products (id);',
'ALTER TABLE jlm_daily_product_work ADD CONSTRAINT FK_9928F3964584665A FOREIGN KEY (product_id) REFERENCES products (id);',
'ALTER TABLE jlm_commerce_event_follower_join_event ADD CONSTRAINT FK_BCBDF267AD2BD3 FOREIGN KEY (event_follower_id) REFERENCES jlm_commerce_event_follower (id);',
'ALTER TABLE jlm_commerce_event_follower_join_event ADD CONSTRAINT FK_BCBDF2671F7E88B FOREIGN KEY (event_id) REFERENCES jlm_commerce_event (id);',
'ALTER TABLE jlm_commerce_quotevariant_join_quote_line ADD CONSTRAINT FK_E3936BAF11791C8 FOREIGN KEY (quotevariant_id) REFERENCES quote_variant (id);',
'ALTER TABLE jlm_commerce_quotevariant_join_quote_line ADD CONSTRAINT FK_E3936BA8EF03C82 FOREIGN KEY (quoteline_id) REFERENCES quote_lines (id);',
'ALTER TABLE jlm_commerce_product_order ADD CONSTRAINT FK_81D967244584665A FOREIGN KEY (product_id) REFERENCES products (id);',
'ALTER TABLE jlm_follow_starterquote ADD CONSTRAINT FK_922C43943B69A9AF FOREIGN KEY (variant_id) REFERENCES quote_variant (id);',
'ALTER TABLE jlm_follow_starterquote ADD CONSTRAINT FK_922C4394BF396750 FOREIGN KEY (id) REFERENCES jlm_follow_starter (id) ON DELETE CASCADE;',
'ALTER TABLE jlm_follow_thread ADD CONSTRAINT FK_CC1FDB58AD5A66CC FOREIGN KEY (starter_id) REFERENCES jlm_follow_starter (id);',
'ALTER TABLE jlm_follow_starterintervention ADD CONSTRAINT FK_93A09CAC8EAE3863 FOREIGN KEY (intervention_id) REFERENCES shifting_interventions (id);',
'ALTER TABLE jlm_follow_starterintervention ADD CONSTRAINT FK_93A09CACBF396750 FOREIGN KEY (id) REFERENCES jlm_follow_starter (id) ON DELETE CASCADE;',
'ALTER TABLE orders ADD close DATETIME DEFAULT NULL;',
'ALTER TABLE bill ADD eventFollower_id INT DEFAULT NULL;',
'ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3111D5ED3 FOREIGN KEY (eventFollower_id) REFERENCES jlm_commerce_event_follower (id);',
'CREATE UNIQUE INDEX UNIQ_7A2119E3111D5ED3 ON bill (eventFollower_id);',
'ALTER TABLE quote ADD eventFollower_id INT DEFAULT NULL;',
'ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4111D5ED3 FOREIGN KEY (eventFollower_id) REFERENCES jlm_commerce_event_follower (id);',
'CREATE UNIQUE INDEX UNIQ_6B71CBF4111D5ED3 ON quote (eventFollower_id);',
'ALTER TABLE quote_lines DROP FOREIGN KEY FK_42FE01F73B69A9AF;',
'DROP INDEX IDX_42FE01F73B69A9AF ON quote_lines;',
'ALTER TABLE quote_lines DROP variant_id;',
);

$quoteLineQuery = "SELECT id, variant_id FROM quote_lines";
$quoteLines = $db->query($quoteLineQuery);
while ($quoteLine = $quoteLines->fetch_array())
{
	$query[] = 'INSERT INTO jlm_commerce_quotevariant_join_quote_line (quoteline_id, quotevariant_id) VALUES ('.$quoteLine['id'].','.$quoteLine['variant_id'].');';
}

$query = array_merge($init,$query,$end);
/*
$productQuery = "SELECT * FROM products";

$products = $db->query($productQuery);
$query = array();

$date = new \DateTime;
while ($product = $products->fetch_array())
{
	$query[] = 'INSERT INTO jlm_product_stock (product_id, lastModified) VALUES ('.$product['id'].',"'.$date->format('Y-m-d H:i:s').'");';
}


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
	$query[] = 'INSERT INTO jlm_commerce_bill_join_bill_line (billline_id, bill_id) VALUES ('.$billLine['id'].','.$billLine['bill_id'].');';
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
*/
foreach ($query as $q)
{
  if ($db->query($q) == false)
  {
    echo $q.chr(10);
  }
}

