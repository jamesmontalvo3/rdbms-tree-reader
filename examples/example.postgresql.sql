CREATE TABLE IF NOT EXISTS items (
	id serial PRIMARY KEY,
	parent_id int,
	title varchar(63),
	part_number varchar(31),
	serial_number varchar(15),
	company varchar(63),
	notes text
);

INSERT INTO items 
	(id, parent_id, title,           part_number,    serial_number, company, notes)
VALUES
	(1,  0,         "Toolbox",       "ABC-123-456",  "0001",        "Acme",  ""),
	(2,  1,         "Drawer 1",      "Drawer-01",    "0001",        "Acme",  ""),
	(3,  2,         "Hammer",        "XYZ-987-456",  "0001",        "Acme",  ""),
	(4,  2,         "Nails",         "NAI-00030",    "100003",      "Nails, Inc",  ""),
	(5,  1,         "Drawer 2",      "Drawer-01",    "0002",        "Acme",  ""),
	(6,  5,         "Socket Wrench", "ASDF-454376",  "0010",        "Sockets, Inc",  ""),
	(7,  6,         "16mm Socket",   "ASDF-000121",  "0001",        "Sockets, Inc",  ""),
	(8,  5,         "Socket Holder", "ABC-744-003",  "2352",        "Acme",  ""),
	(9,  8,         "20mm Socket",   "ASDF-000131",  "0011",        "Sockets, Inc",  ""),
	(10, 8,         "24mm Socket",   "ASDF-000141",  "0008",        "Sockets, Inc",  "");
