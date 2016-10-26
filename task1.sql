CREATE TABLE users (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(100),
        PRIMARY KEY (id))
        ENGINE=InnoDB;

CREATE TABLE contacts (
id INT NOT NULL AUTO_INCREMENT,
contact1_id int,
contact2_id int,
FOREIGN KEY(contact1_id) REFERENCES users(id),
FOREIGN KEY(contact2_id) REFERENCES users(id),
        PRIMARY KEY (id))
        ENGINE=InnoDB;

insert into users (name) values ('vacja'), ('oleg'), ('vova'), ('sasha'), ('dima') , ('andrei'), ('sveta');
insert into contacts (contact1_id, contact2_id) values (1,2), (1,3), (2,1), (3,1), (4,1),(4,2), (4,3), (4,5), (4,6), (4,7)

select u.*, count(u.id) as cnt from users u inner join contacts c
   on u.id=c.contact1_id
group by u.id having cnt>5

select c.contact1_id, u.name, c.contact2_id, u2.name from contacts c
  inner join contacts c2 on c2.contact1_id = c.contact2_id and c2.contact2_id = c.contact1_id
  inner join users u on u.id = c.contact1_id
  inner join users u2 on u2.id = c.contact2_id
group by  (c.id*c2.id)