#!/bin/sh

DB_SERVER=$1
DB_BANCO=$2
DB_USER=$3
DB_PASSWORD=$4

#define the template.
cat  << EOF
<?php
define('DB_SERVER',$DB_SERVER);
define('DB_BANCO',$DB_BANCO);
define('DB_USER',$DB_USER);
define('DB_PASSWORD',"$DB_PASSWORD");

EOF

