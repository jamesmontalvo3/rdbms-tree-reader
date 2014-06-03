<?php

// require the TreeReader file
require '../TreeReader.php';

// database credentials
$db_host = "sqlsrv:Server=example.com;Database=your_db";
$db_user = "user"; 
$db_pass = "password";

// this is the table that has the parent-child relationship
$table    = 'itemtable';

// $pid_col for one item points to $id_col on it's parent
$id_col   = 'id';
$pid_col  = 'parent_id';

// which column to consider the "name" field.
// Only required for HTML format type. Default = $id_col
$name_col = 'title';

// which columns to select. Default = * (all)
$default_select_cols = array(		
	"id",
	"parent_id",
	"title",
	"part_number",
	"serial_number",
	"company",
	"notes"
);

// create new TreeReader object with settings from above
$tr = new TreeReader(
	$db_host,
	$db_user,
	$db_pass,
	$table,
	$id_col,
	$pid_col,
	$name_col,
	$default_select_cols
);	

// create an array from query string values ($_GET)
// with $where['part_number'] == YourPartNumber,
// and optionally include values for serial_number and company.
// This will add to the SQL WHERE-clause "part_number = 'YourPartNumber', for example
$where = array();
$where['part_number'] = $_GET['part_number'];
if( isset($_GET['serial_number']) )
	$where['serial_number'] = $_GET['serial_number'];
if ( isset($_GET['company']) )
	$where['company'] = $_GET['company'];
	
/**
 * TreeReader methods are chainable (most of them, anyway). The following code
 * performs your database query, restructures it into a tree of parent-child
 * relationships, then converts to JSON and is echoed to the client.
 * 
 * itemQuery(array $where):
 *   Takes the part_number, serial_number and company arguments from above and
 *   performs the SQL query accordingly. The values for part_number,
 *   serial_number and company are used to match exact equality (e.g 
 *   serial_number = 'YourSerialNumber') by default. If you'd like to match a
 *   partial string you can use the following:
 *
 *     Find exact matches (default)
 *     $where['serial_number'] = '1234';
 *
 *     Find exact matches (explicitly declare exact match)
 *     $where['serial_number'] = '=1234';
 *
 *     Matches serial_number != 1234 (Serial Numbers other than 1234)
 *     $where['serial_number'] = '!1234';
 *
 *     Matches serial_number LIKE '1234%' (wildcard at end of string)
 *     $where['serial_number'] = '^1234';
 *
 *     Matches serial_number LIKE '%1234' (wildcard at start of string)
 *     $where['serial_number'] = '$1234';
 *
 *     Matches serial_number LIKE '%1234%' (wildcard at start & end of string)
 *     $where['serial_number'] = '*1234';
 *
 * treeify():
 *   The data returned by itemQuery() is the same "flat" format as in your
 *   relational database, but now in a PHP array. The treeify() method performs
 *   the restructuring into a tree format.
 *
 * toJSON(bool $pretty, string $callback):
 *   Converts TreeReader data to JSON. Note, can also be performed by doing
 *   $tr->toResponseFormat($format) where $format can be json, json-pretty,
 *   html (minimally supported), or xml (not yet supported). This function
 *   makes it easier to specify format in a GET request.
 *
 *   bool $pretty: if true returns human-readable JSON.
 *     Default=false
 *   string $callback: if true JSONP is returned with the specified callback.
 *     Default=null
 *
 **/
echo $tr->itemQuery($where)->treeify()->toJSON(true);

