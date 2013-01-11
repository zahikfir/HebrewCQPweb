<?php
/*
 * CQPweb: a user-friendly interface to the IMS Corpus Query Processor
 * Copyright (C) 2008-today Andrew Hardie and contributors
 *
 * See http://cwb.sourceforge.net/cqpweb.php
 *
 * This file is part of CQPweb.
 * 
 * CQPweb is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * CQPweb is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Improtant note: this is non-secure, so is blocked from being run from anywhere but the command line
 * only use this script if you know what you are doing!
 * it was originally invented to allow the setup process access to library functions.
 */


// TODO: get the first superuser username and set it as username by popping it
// into the right place for defaults.inc.php to find it (as if it had come via the web)


/* refuse to run unless we are in CLI mode */

if (php_sapi_name() != 'cli')
	exit("Offline script must be run in CLI mode!");


if (!isset($argv[1]))
{
	echo "Usage: cd path/to/a/corpus/directory && php ../lib/execute-cli.php function arg1 arg2 ...\n\n";
	exit(1);
}

if (isset($_GET))
	unset($_GET);

$_GET['function'] = $argv[1];
unset($argv[0],$argv[1]);
if (!empty($argv))
	$_GET['args'] = implode('#', $argv);
unset($argc, $argv);

require('../lib/execute.inc.php');

//TODO use output buffering to capture the results, strip html and print?


?>