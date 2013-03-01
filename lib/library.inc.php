<?php
/*
 * CQPweb: a user-friendly interface to the IMS Corpus Query Processor
 * Copyright (C) 2008-10 Andrew Hardie and contributors
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







/* this file contains a library of broadly useful functions */






/*
 * If mysql extension does not exist, include fake-mysql.inc.php to restore the functions
 * that are actually used and emulate them via mysqli.
 * 
 * This is global code in a library file; normally a no-no.
 * it -only- addresses what files need to be included and which don't.
 */
if  (!extension_loaded('mysql'))
{
	if (!class_exists('mysqli', false))
		exit('CQPweb fatal error: neither mysql nor mysqli is available. Contact the system administrator.');
	else
		include('../lib/fake-mysql.inc.php');
}










/*
 * FLAGS for cqpweb_startup_environment()
 */
 
define('CQPWEB_NO_STARTUP_FLAGS',             0);
define('CQPWEB_STARTUP_DONT_CONNECT_CQP',     1);
define('CQPWEB_STARTUP_DONT_CONNECT_MYSQL',   2);
define('CQPWEB_STARTUP_DONT_CHECK_URLTEST',   4);


/**
 * Function that starts up CQPweb and sets up the required environment.
 * 
 * All scripts that require the environment should call this function.
 * 
 * It should be called *after* the inclusion of most functions, but
 * *before* the inclusion of admin functions (if any).
 * 
 * Ultimately, this function will be used instead of the various "setup
 * stuff" that uis currently done repeatedly, per-script.
 * 
 * Pass in bitwise-OR'd flags to control the behaviour. 
 * 
 * TODO When we have the new user system, this function will prob get bigger
 * and bigger. Also when the system can be silent for the web-api, this
 * function will deal with it. As a result it will prob
 * be necessary to move this function, as well as the equiv shutdown
 * function, into a file of its own. (startup.inc.php) together with
 * depedencies like session setup functions, the control flag constants, etc.
 */
function cqpweb_startup_environment($flags = CQPWEB_NO_STARTUP_FLAGS)
{
	// TODO, move here the check for a bad URL.
	// conditional on CQPWEB_STARTUP_DONT_CHECK_URLTEST
	
	
	// TODO ,move into here the getting of the username
	// TODO, a call to session_start() -- and other cookie/login stuff -
	// prob belongs here.
	
	// TODO, move into here the setup of plugins
	// (so this is done AFTER all functions are imported, not
	// in the defaults.inc.php file)

	// TODO, move into here setting the HTTP response headers, charset and the like???
	// (make dependent on whether we are writing plaintext or an HTML response?
	// (do we want a flag CQPWEB_STARTUP_NONINTERACTIVE for when HTML response is NTO wanted?
	
	// TODO likewise have an implicit policy on ob_*_flush() usage in different scirpts.

	/*
	 * The flags are for "dont" because we assume the default behaviour
	 * is to need both a DB connection and a slave CQP process.
	 * 
	 * If one or both is not required, a script can be passed in to 
	 * save the connection (not much of a saving in the case of the DB,
	 * potentially quite a performance boost for the slave process.)
	 */
	if ($flags & CQPWEB_STARTUP_DONT_CONNECT_CQP)
		;
	else
		connect_global_cqp();
	
	if ($flags & CQPWEB_STARTUP_DONT_CONNECT_MYSQL)
		;
	else
		connect_global_mysql();
}

/**
 * Performs shutdown and cleanup for the CQPweb system.
 * 
 * The only thing that it will not do is finish off HTML. The
 * script should do that separately -- BEFORE calling this script.
 * 
 * TODO this function does not really contain much yet, but eventually all
 * web-callable scruipts should use it.
 */
function cqpweb_shutdown_environment()
{
	// TODO, should it do a client disconnect? 
	// if so, it needs to be done AFTER a location call / print end of page.
	// should the location call / print end of page be done here?
	
	/* these funcs have their own "if" clauses so can be called here unconditionally... */
	disconnect_global_cqp();
	disconnect_global_mysql();
}










/* connect/disconnect functions */

/**
 * Creates a global connection to a CQP child process.
 */
function connect_global_cqp()
{
	global $cqp;
	global $cqpweb_tempdir;
	global $corpus_cqp_name;
	global $path_to_cwb;
	global $cwb_registry;
	global $print_debug_messages;

	/* connect to CQP */
	$cqp = new CQP("/$path_to_cwb", "/$cwb_registry");
	/* select an error handling function */
	$cqp->set_error_handler("exiterror_cqp");
	/* set CQP's temporary directory */
	$cqp->execute("set DataDirectory '/$cqpweb_tempdir'");
	/* select corpus */
	$cqp->set_corpus($corpus_cqp_name);
	/* note that corpus must be (RE)SELECTED after calling "set DataDirectory" */
	
	if ($print_debug_messages)
		$cqp->set_debug_mode(true);
}

/**
 * Disconnects the global CQP child process.
 */
function disconnect_global_cqp()
{
	global $cqp;
	if (isset($cqp))
	{
		$cqp->disconnect();
		unset($GLOBALS['cqp']);
	}
}


/**
 * This function refreshes CQP's internal list of queries currently existing in its data directory
 * 
 * NB should this perhaps be part of the CQP object model?
 * (as perhaps should set DataDirectory!)
 */
function refresh_directory_global_cqp()
{
	global $cqp;
	global $cqpweb_tempdir;
	global $corpus_cqp_name;
	
	if (isset($cqp))
	{
		$switchdir = getcwd();
		$cqp->execute("set DataDirectory '$switchdir'");
		$cqp->execute("set DataDirectory '/$cqpweb_tempdir'");
		$cqp->set_corpus($corpus_cqp_name);
		// TODO Question: is this still necessary?
		// TODO Windows compatability fail point! like all uses of $cqpweb_tempdir of course
	}
}

/**
 * Creates a global variable $mysql_link containing a connection to the CQPweb
 * database, using the settings in the config file.
 */
function connect_global_mysql()
{
	global $mysql_link;
	global $mysql_server;
	global $mysql_webuser;
	global $mysql_webpass;
	global $mysql_schema;
	global $utf8_set_required;
	
	/* Connect with flag 128 == mysql client lib constant CLIENT_LOCAL_FILES;
	 * this overrules deactivation at PHP's end of LOAD DATA LOCAL. (If L-D-L
	 * is deactivated at the mysqld end, e.g. by my.cnf, this won't help, but 
	 * won't hurt either.) 
	 */ 
	$mysql_link = mysql_connect($mysql_server, $mysql_webuser, $mysql_webpass, false, 128);
	/* Note, in theory there are performance gains to be had by using a 
	 * persistent connection. However, current judgement is that the risk
	 * of problems is too great to justify doing so, due to the use of SET
	 * NAMES on some corpora but not all, and other uncertainties. MySQLi
	 * does link cleanup so if ever we shift over to that, persistent 
	 * connections are more likely to be useful.
	 */
	
	if (! $mysql_link)
		exiterror_general('MySQL did not connect - please try again later!');
	
	mysql_select_db($mysql_schema, $mysql_link);
	
	/* utf-8 setting is dependent on a variable defined in config.inc.php */
	if ($utf8_set_required)
		mysql_query("SET NAMES utf8", $mysql_link);
	// TODO but see: http://www.php.net/manual/en/function.mysql-set-charset.php
}
/**
 * Disconnects from the MySQL server.
 * 
 * Scripts could easily disconnect mysql_link locally. So this function
 * only exists so there is function-name-symmetry, and (less anally-retentively) so 
 * a script never really has to use mysql_link in the normal way of things. As
 * a consequence mysql_link is entirely contained within this module.
 */
function disconnect_global_mysql()
{
	global $mysql_link;
	if(isset($mysql_link))
		mysql_close($mysql_link);
}

/**
 * Disconnects from both cqp & mysql, assuming standard global variable names are used.
 * 
 * DEPRACATED: use cqpweb_shutdown_environment() instead.
 */
function disconnect_all()
{
	disconnect_global_cqp();
	disconnect_global_mysql();
}



/**
 * Does a MySQL query on the CQPweb database, with error checking.
 * 
 * Note - this function should replace all direct calls to mysql_query,
 * thus avoiding duplication of error-checking code.
 * 
 * Returns the result resource.
 */ 
function do_mysql_query($sql_query)
{
	global $mysql_link;

	print_debug_message("About to run the following MySQL query:\n\n$sql_query\n");
	$start_time = time();
	
	$result = mysql_query($sql_query, $mysql_link);
	
	if ($result == false) 
		exiterror_mysqlquery(mysql_errno($mysql_link), mysql_error($mysql_link));
			
	print_debug_message("The query ran successfully in " . (time() - $start_time) . " seconds.\n");
		
	return $result;
}


/**
 * Does a mysql query and puts the result into an output file.
 * 
 * This works regardless of whether the mysql server program (mysqld)
 * is allowed to write files or not.
 * 
 * The mysql $query should be of the form "select [something] FROM [table] [other conditions]" 
 * -- that is, it MUST NOT contain "into outfile $filename", and the FROM must be in capitals. 
 * 
 * The output file is specified by $filename - this must be a full absolute path.
 * 
 * Typically used to create a dump file (new format post CWB2.2.101)
 * for input to CQP e.g. in the creation of a postprocessed query. 
 * 
 * Its return value is the number of rows written to file. In case of problem,
 * exiterror_* is called here.
 */
function do_mysql_outfile_query($query, $filename)
{
	global $mysql_has_file_access;
	global $mysql_link;
	
	if ($mysql_has_file_access)
	{
		/* We should use INTO OUTFILE */
		
		$into_outfile = 'INTO OUTFILE "' . mysql_real_escape_string($filename) . '" FROM ';
		$replaced = 0;
		$query = str_replace("FROM ", $into_outfile, $query, $replaced);
		
		if ($replaced != 1)
			exiterror_mysqlquery('no_number',
				'A query was prepared which does not contain FROM, or contains multiple instances of FROM: ' 
				. $query , __FILE__, __LINE__);
		
		print_debug_message("About to run the following MySQL query:\n\n$query\n");
		$result = mysql_query($query);
		if ($result == false)
			exiterror_mysqlquery(mysql_errno($mysql_link), mysql_error($mysql_link));
		else
		{
			print_debug_message("The query ran successfully.\n");
			return mysql_affected_rows($mysql_link);
		}
	}
	else 
	{
		/* we cannot use INTO OUTFILE, so run the query, and write to file ourselves */
		print_debug_message("About to run the following MySQL query:\n\n$query\n");
		$result = mysql_unbuffered_query($query, $mysql_link); /* avoid memory overhead for large result sets */
		if ($result == false)
			exiterror_mysqlquery(mysql_errno($mysql_link), mysql_error($mysql_link));
		print_debug_message("The query ran successfully.\n");
	
		if (!($fh = fopen($filename, 'w'))) 
			exiterror_general("Could not open file for write ( $filename )", __FILE__, __LINE__);
		
		$rowcount = 0;
		
		while ($row = mysql_fetch_row($result)) 
		{
			fputs($fh, implode("\t", $row) . "\n");
			$rowcount++;
		}
		
		fclose($fh);
		
		return $rowcount;
	}
}


/**
 * Loads a specified text file into the given MySQL table.
 * 
 * Note: this is done EITHER with LOAD DATA (LOCAL) INFILE, OR
 * with a loop across the lines of the file.
 * 
 * The latter is EXTREMELY inefficient, but necessary if we're 
 * working on a box where LOAD DATA (LOCAL) INFILE has been 
 * disabled.
 * 
 * "FIELDS ESCAPED BY" behaviour is normally not specified,
 * but if $no_escapes is true, it will be set to an empty
 * string.
 * 
 * Function returns the (last) update/import query result if
 * all went well; false in case of error.
 */
function do_mysql_infile_query($table, $filename, $no_escapes = false)
{
	global $mysql_infile_disabled;
	global $mysql_LOAD_DATA_INFILE_command;
	
	/* check variables */
	if (! is_file($filename))
		return false;
	$table = mysql_real_escape_string($table);
	
	/* massive if/else: overall two branches. */
	
	if (! $mysql_infile_disabled)
	{
		/* the normal sensible way */
		
		$sql = "$mysql_LOAD_DATA_INFILE_command '$filename' INTO TABLE $table";
		if ($no_escapes)
			$sql .= ' FIELDS ESCAPED BY \'\'';
		
		return do_mysql_query($sql);
	}
	else
	{
		/* the nasty hacky workaround way */
		
//		exiterror_general("MySQL workaround not built yet!", __SCRIPT__, __LINE__);
		
		/* first we need to find out about the table ... */
		$fields = array();
		
		/* note: we currently allow for char, varchar, and text as "quote-needed"
		 * types, because those are the ones CQPweb uses. There are, of course,
		 * others. See the MySQL manual. */
		
		$result = do_mysql_query("describe $table");
		while (false !== ($f = mysql_fetch_object($result)))
		{
			/* format of "describe" is such that "Field" contains the fieldname,
			 * and "Type" its type. All types should be lowercase, but let's make sure */
			$f->Type = strtolower($f->Type);
			$quoteme =    /* quoteme equals the truth of the following long condition. */
				(
					substr($f->Type, 0, 7) == 'varchar'
					||
					$f->Type == 'text'
					||
					substr($f->Type, 0, 4) == 'char'
				);
			$fields[] = array('field' => $f->Field, 'quoteme' => $quoteme);	
		}
		unset($result);
		
		$source = fopen($filename, 'r');
		
		/* loop across lines in input file */
		while (false !== ($line = fgets($source)));
		{
			/* necessary for security, but might possibly lead to data being
			 * escaped where we don't want it; if so, tant pis */
			$line = mysql_real_escape_string($line);
			$line = rtrim($line, "\r\n");
			$data = explode($line, "\t");

			
			$blob1 = $blob2 = '';
			
			for ( $i = 0 ; true ; $i++ )
			{
				/* require both a field and data; otherwise break */
				if (!isset($data[$i], $fields[$i]))
					break;
				$blob1 .= ", {$fields[$i]['field']}";
				
				if ( (! $no_escapes) && $data[$i] == '\\N' )
					/* data for this field is NULL, so type doesn't matter */
					$blob2 .= ', NULL';
				else 
					if ( $fields[$i]['quoteme'] )
						/* data for this field needs quoting (string) */
						$blob2 .= ", '{$data[$i]}'";
					else
						/* data for this field is an integer or like type */
						$blob2 .= ", '{$data[$i]}'";
			}
			
			$blob1 = ltrim($blob1, ', ');
			$blob2 = ltrim($blob2, ', ');
			
			$result = do_mysql_query("insert into $table ($blob1) values ($blob2)");
		}
		fclose($source);
		
		return $result;
		
	} /* end of massive if/else that branches this function */
}



/* 
 * the next two functions are really just for convenience
 */

/** Turn off indexing for a given MySQL table. */
function database_disable_keys($table)
{
	do_mysql_query("alter table " . mysql_real_escape_string($table) . " disable keys");
}
/** Turn on indexing for a given MySQL table. */
function database_enable_keys($table)
{
	do_mysql_query("alter table " . mysql_real_escape_string($table) . " enable keys");
}






/**
 * Returns an integer containing the RAM limit to be passed to CWB programs that
 * allow a RAM limit to be set - note, the flag (-M or whatever) is not returned,
 * just the number of megabytes as an integer.
 */
function get_cwb_memory_limit()
{
	global $cwb_max_ram_usage;
	global $cwb_max_ram_usage_cli;
	
	return ((php_sapi_name() == 'cli') ? $cwb_max_ram_usage_cli : $cwb_max_ram_usage);
}




/**
 * Prints a debug message. 
 * 
 * Messages are not printed if the config variable $print_debug_messages is not set to
 * true.
 * 
 * (Currently, this function just wraps pre_echo, or echoes naked to the command line
 * - but we might want to create a more HTML-table-friendly version later.)
 */
function print_debug_message($message)
{
	global $debug_messages_textonly;
	global $print_debug_messages;
	
	if ($print_debug_messages)
	{
		if ($debug_messages_textonly)
			echo $message. "\n\n";
		else
			pre_echo($message);
	}
}


/**
 * Echoes a string, but with HTML 'pre' tags (ideal for debug messages).
 */
function pre_echo($s)
{
	// TODO we should prob call htmlspecialchars here, sans double encoding....
	echo "\n\n<pre>\n$s\n</pre>\n";
}

/**
 * Imports the settings for a corpus into global variable space.
 * 
 * If there is an active CQP object, it is set to use that corpus.
 */
function import_settings_as_global($corpus)
{
	$data = file_get_contents("../$corpus/settings.inc.php");
	
	/* get list of variables and create global references */
	preg_match_all('/\$(\w+)\W/', $data, $m, PREG_PATTERN_ORDER);
	foreach($m[1] as $v)
	{
		global $$v;	
	}
	include("../$corpus/settings.inc.php");
	
	/* one special one */
	global $cqp;
	if (isset($cqp, $corpus_cqp_name))
		$cqp->set_corpus($corpus_cqp_name);
}


/** 
 * This function removes any existing start/end anchors from a regex
 * and adds new ones.
 */
function regex_add_anchors($s)
{
	$s = preg_replace('/^\^/', '', $s);
	$s = preg_replace('/^\\A/', '', $s);
	$s = preg_replace('/\$$/', '', $s);
	$s = preg_replace('/\\[Zz]$/', '', $s);
	return '^' . $s . '$';
}

/**
 * Converts an integer to a string with commas every three digits.
 * 
 * Note: this was created when I didn't know about the existence of number_format()! -- AH.
 */
function make_thousands($number)
{
	return number_format((float)$number);
}




/**
 * Replacement for htmlspecialcharacters which DOESN'T change & to &amp; if it is already part of
 * an entity; otherwise equiv to htmlspecialchars($string, ENT_COMPAT, 'UTF-8', false) 
 * 
 * Note the double-encode flag exists in PHP >= 5.2.3. So we don't really need this
 * function, since - officially! - CQPweb requires PHP 5.3. But let's keep it since it's no effort to
 * do so and it might let people without upgrade power keep running the system a little longer.
 */
function cqpweb_htmlspecialchars($string)
{
	$string = str_replace('&', '&amp;', $string);
	$string = str_replace('<', '&lt;', $string);
	$string = str_replace('>', '&gt;', $string);
	$string = str_replace('"', '&quot;', $string);

	return preg_replace('/&amp;(\#?\w+;)/', '&$1', $string);
} 


/**
 * Removes any nonhandle characters from a string.
 *  
 * A "handle" can only contain ascii letters, numbers, and underscore.
 * 
 * If removing the nonhandle characters reduces it to an
 * empty string, then it will be converted to "__HANDLE".
 * 
 * (Other code must be responsible for making sure the handle is unique
 * where necessary.)
 * 
 * A maximum length can also be enforced if the second parameter
 * is set to greater than 0.
 */
function cqpweb_handle_enforce($string, $length = -1)
{
	$handle = preg_replace('/[^a-zA-Z0-9_]/', '', $string);
	if (empty($handle))
		$handle = '__HANDLE';
	return ($length < 1 ? $handle : substr($handle, 0, $length) );
}

/**
 * Returns true iff the argument string is OK as a handle,
 * that is, iff there are no non-word characters (i.e. no \W)
 * in the string and it is not empty.
 * 
 * A maximum length can also be checked if the second parameter
 * is set to greater than 0.
 */
function cqpweb_handle_check($string, $length = -1)
{
	return (
			is_string($string)
			&&   $string !== ''
			&&   0 >= preg_match('/\W/', $string) 
			&&   ( $length < 1 || strlen($string) <= $length )
			);
}




/**
 * Sets the location field in the HTTP response
 * to an absolute location based on the supplied relative URL,
 * iff the headers have not yet been sent.
 * 
 * If, on the other hand, the headers have been sent, 
 * the function does nothing.
 * 
 * The function DOES NOT exit. Instead, it returns the
 * value it itself got from the headers_sent() function.
 * This allows the caller to check whether it needs to
 * do something alternative.
 */
function set_next_absolute_location($relative_url)
{
	if (false == ($test = headers_sent()) )
		header('Location: ' . url_absolutify($relative_url));
	return $test;
}


/**
 * This function creates absolute URLs from relative ones by adding the relative
 * URL argument $u to the real URL of the directory in which the script is running.
 * 
 * The URL of the currently-running script's containing directory is worked out  
 * in one of two ways. If the global configuration variable "$cqpweb_root_url" is
 * set, this address is taken, and the corpus handle (SQL version, IE lowercase, which 
 * is the same as the subdirectory that accesses the corpus) is added. If no SQL
 * corpus handle exists, the current script's containing directory is added to 
 * $cqpweb_root_url.
 * 
 * $u will be treated as a relative address  (as explained above) if it does not 
 * begin with "http" and as an absolute address if it does.
 * 
 * Note, this "absolute" in the sense of having a server specified at the start, 
 * it can still contain relativising elements such as '/../' etc.
 */
function url_absolutify($u, $special_subdir = NULL)
{
	global $cqpweb_root_url;
	global $corpus_sql_name;

	if (preg_match('/\Ahttps?:/', $u))
		/* address is already absolute */
		return $u;
	else
	{
		/* make address absolute by adding server of this script plus folder path of this URI;
		 * this may not be foolproof, because it assumes that the path will always lead to the 
		 * folder in which the current php script is located -- but should work for most cases 
		 */
		if (empty($cqpweb_root_url))
			return ($_SERVER['HTTPS'] ? 'https://' : 'http://')
				  /* host name */
				. $_SERVER['HTTP_HOST']
				  /* path from request URI excluding filename */ 
				. preg_replace('/\/[^\/]*\z/', '/', $_SERVER['REQUEST_URI'])
				  /* target path relative to current folder */ 
				. $u;
		else
			return $cqpweb_root_url 
				. ( (!empty($corpus_sql_name)) 
					/* within a corpus, use the root + the corpus sql name */
					? $corpus_sql_name . '/' 
					/* outside a corpus, extract the immeidate containing directory
					 * from REQUEST_URI (e.g. 'adm') */
					: preg_replace('/\A.*\/([^\/]+)\/[^\/]*\z/',
									'/$1/', $_SERVER['REQUEST_URI']) 
				) 
				. $u; 
	}
}



/** 
 * Checks whether the current script has $_GET['uT'] == "y" 
 * (&uT=y is the terminating element of all valid CQPweb URIs).
 * 
 * "uT" is short for "urlTest", by the way.
 */
function url_string_is_valid()
{
	return (array_key_exists('uT', $_GET) && $_GET['uT'] == 'y');
}




/**
 * Returns a string of "var=val&var=val&var=val".
 * 
 * $changes = array of arrays, 
 * where each array consists of [0] a field name  
 *                            & [1] the new value.
 * 
 * If [1] is an empty string, that pair is not included.
 * 
 * WARNING: adds values that weren't already there at the START of the string.
 * 
 */
function url_printget($changes = "Nope!")
{
	$change_me = is_array($changes);

	$string = '';
	foreach ($_GET as $key => $val)
	{
		if (!empty($string))
			$string .= '&';

		if ($change_me)
		{
			$newval = $val;

			foreach ($changes as &$c)
				if ($key == $c[0])
				{
					$newval = $c[1];
					$c[0] = '';
				}
			/* only add the new value if the change array DID NOT contain a zero-length string */
			/* otherwise remove the last-added & */
			if ($newval != "")
				$string .= $key . '=' . urlencode($newval);
			else
				$string = preg_replace('/&\z/', '', $string);
				
		}
		else
			$string .= $key . '=' . urlencode($val);
		/* urlencode needed here since $_GET appears to be un-makesafed automatically */
	}
	if ($change_me)
	{
		$extra = '';
		foreach ($changes as &$c)
			if ($c[0] != '' && $c[1] != '')
				$extra .= $c[0] . '=' . $c[1] . '&';
		$string = $extra . $string;
		
	}
	return $string;
}

/**
 * Returns a string of "&lt;input type="hidden" name="key" value="value" /&gt;..."
 * 
 * $changes = array of arrays, 
 * where each array consists of [0] a field name  
 *                            & [1] the new value.
 * 
 * If [1] is an empty string, that pair is not included.
 *  
 * WARNING: adds values that weren't there at the START of the string.
 */
function url_printinputs($changes = "Nope!")
{
	$change_me = is_array($changes);

	$string = '';
	foreach ($_GET as $key => $val)
	{
		if ($change_me)
		{
			$newval = $val;
			foreach ($changes as &$c)
				if ($key == $c[0])
				{
					$newval = $c[1];
					$c[0] = '';
				}
			/* only add the new value if the change array DID NOT contain a zero-length string */
			if ($newval != '')
				$string .= '<input type="hidden" name="' . $key . '" value="' 
					. htmlspecialchars($newval, ENT_QUOTES, 'UTF-8') . '" />
					';
		}
		else
			$string .= '<input type="hidden" name="' . $key . '" value="' 
				. htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . '" />';

		/* note: should really be htmlspecialchars($val, ENT_QUOTES, UTF-8, false)
		 * etc. BUT the last parameter (whcih turns off the effect on existing entities)
		 * is PHP >=5.2.3 only 
		 * TODO use cqpweb_htmlspecialchars instead.
		 */
	}

	if ($change_me)
	{
		$extra = '';
		foreach ($changes as &$c)
			if ($c[0] !== '' && $c[1] !== '')
				$extra .= '<input type="hidden" name="' . $c[0] . '" value="' 
					. htmlspecialchars($c[1], ENT_QUOTES, 'UTF-8') . '" />';
		$string = $extra . $string;
	}
	return $string;
}



/* invalid values of $pp cause CQPweb to default back to $default_per_page  */
function prepare_per_page($pp)
{
	global $default_per_page;
	
	if ( is_string($pp) )
		$pp = strtolower($pp);
	
	switch($pp)
	{
	/* extra values valid in concordance.php */
	case 'count':
	case 'all':
		if (strpos($_SERVER['PHP_SELF'], 'concordance.php') !== false)
			;
		else
			$pp = $default_per_page;
		break;

	default:
		if (is_numeric($pp))
			settype($pp, 'integer');
		else
			$pp = $default_per_page;
		break;
	}
	return $pp;
}


function prepare_page_no($n)
{
	if (is_numeric($n))
	{
		settype($n, 'integer');
		return $n;
	}
	else
		return 1;
}





function user_is_superuser($username)
{
	/* superusers are determined in the config file */
	global $superuser_username;
		
	$a = explode('|', $superuser_username);
	
	return in_array($username, $a);
}




/**
 * Change the character encoding of a specified text file. 
 * 
 * The re-coded file is saved to the path of $outfile.
 * 
 * Infile and outfile paths cannot be the same.
 */
function change_file_encoding($infile, $outfile, $source_charset_for_iconv, $dest_charset_for_iconv)
{
	if (! is_readable($infile) )
		exiterror_arguments($infile, "This file is not readable.");
	$source = fopen($infile, 'r');

	if (! is_writable(dirname($outfile)) )
		exiterror_arguments($outfile, "This path is not writable.");
	$dest = fopen($outfile,  'w');
	
	while (false !== ($line = fgets($source)) )
		fputs($dest, iconv($source_charset_for_iconv, $dest_charset_for_iconv, $line));
	
	fclose($source);
	fclose($dest);
}




function php_execute_time_unlimit($switch_to_unlimited = true)
{
	static $orig_limit = 30;

	if ($switch_to_unlimited)
	{
		$orig_limit = (int)ini_get('max_execution_time');
		set_time_limit(0);
	}
	else
	{
		set_time_limit($orig_limit);
	}
}

function php_execute_time_relimit()
{
	php_execute_time_unlimit(false);
}


/** THIS IS A DEBUG FUNCTION */
function show_var(&$var, $scope=false, $prefix='unique', $suffix='value')
{
	/* some code off the web to get the variable name */
	if($scope)	$vals = $scope;
	else		$vals = $GLOBALS;
	$old = $var;
	$var = $new = $prefix.rand().$suffix;
	$vname = FALSE;
	foreach($vals as $key => $val) 
	{
		if($val === $new) $vname = $key;
	}
	$var = $old;


	echo "\n<pre>-->\$$vname<--\n";
	var_dump($var);
	echo "</pre>";
}

/** THIS IS A DEBUG FUNCTION */
function dump_mysql_result($result)
{
	$s = '<table class="concordtable"><tr>';
	$n = mysql_num_fields($result);
	for ( $i = 0 ; $i < $n ; $i++ )
		$s .= "<th class='concordtable'>" 
			. mysql_field_name($result, $i)
			. "</th>";
	$s .=  '</tr>
		';
	
	while ( ($r = mysql_fetch_row($result)) !== false )
	{
		$s .= '<tr>';
		foreach($r as $c)
			$s .= "<td class='concordgeneral'>$c</td>\n";
		$s .= '</tr>
			';
	}
	$s .= '</table>';
	
	return $s;
}




function coming_soon_page()
{
	global $corpus_title;
	global $css_path;
	?>
	<html>
	<head>
	<?php
	
	/* initialise variables from settings files in local scope */
	/* -- they will prob not have been initialised in global scope anyway */
	
	require("settings.inc.php");
	
	echo '<title>' . $corpus_title . ' -- unfinished function!</title>';
	echo '<link rel="stylesheet" type="text/css" href="' . $css_path . '" />';
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>

	<?php
	coming_soon_finish_page();
}


function coming_soon_finish_page()
{
	?>
	<p class="errormessage">&nbsp;<br/>
		&nbsp; <br/>
		We are sorry, but that part of CQPweb has not been built yet.
	</p>
	
	</body>
	</html>
	<?php
}



/**
 * Runs a script in perl and returns up to 10Kb of text written to STDOUT
 * by that perl script, or an empty string if Perl writes nothing to STDOUT.
 * 
 * It reads STDERR if nothing is written to STDOUT.
 * 
 * This function is not currently used.
 * 
 * script_path	   path to the script, relative to current PHP script (string)
 * arguments	   anything to add after the script name (string)
 * select_maxtime  time to wait for PErl to respond
 * 
 */
function perl_interface($script_path, $arguments, $select_maxtime='!')
{
	global $path_to_perl;
	
	if (!is_int($select_maxtime))
		$select_maxtime = 10;
	
	if (! file_exists($script_path) )
		return "ERROR: perl script could not be found.";
		
	$call = "/$path_to_perl/perl $script_path $arguments";
	
	$io_settings = array(
		0 => array("pipe", "r"), // stdin 
		1 => array("pipe", "w"), // stdout 
		2 => array("pipe", "w")  // stderr 
	); 
	
	$process = proc_open($call, $io_settings, $handles);

	if (is_resource($process)) 
	{
		/* returns stdout, if stdout is empty, returns stderr */
		if (stream_select($r=array($handles[1]), $w=NULL, $e=NULL, $select_maxtime) > 0 )
			$output = fread($handles[1], 10240);
		else if (stream_select($r=array($handles[2]), $w=NULL, $e=NULL, $select_maxtime) > 0 )
			$output = fread($handles[2], 10240);
		else
			$output = "";

		fclose($handles[0]);    
		fclose($handles[1]);    
		fclose($handles[2]);    
		proc_close($process);
		
		return $output;
	}
	else
		return "ERROR: perl interface could not be created.";
}





/**
 * Creates a table row for the index-page left-hand-side menu, which is either a link,
 * or a greyed-out entry if the variable specified as $current_query is equal to
 * the link handle. It is returned as a string, -not- immediately echoed.
 *
 * This is the version for adminhome.
 */
function print_menurow_admin($link_handle, $link_text)
{
	global $thisF;
	return print_menurow_backend($link_handle, $link_text, $thisF, 'thisF');
}
/**
 * Creates a table row for the index-page left-hand-side menu, which is either a link,
 * or a greyed-out entry if the variable specified as $current_query is equal to
 * the link handle. It is returned as a string, -not- immediately echoed.
 *
 * This is the version for the normal user-facing index.
 */
function print_menurow_index($link_handle, $link_text)
{
	global $thisQ;
	return print_menurow_backend($link_handle, $link_text, $thisQ, 'thisQ');
}
function print_menurow_backend($link_handle, $link_text, $current_query, $http_varname)
{
	/*$s = "\n<tr>\n\t<td class=\"";
	if ($current_query != $link_handle)
		$s .= "concordgeneral\">\n\t\t<a class=\"menuItem\""
			. " href=\"index.php?$http_varname=$link_handle&uT=y\">";
	else 
		$s .= "concordgrey\">\n\t\t<a class=\"menuCurrentItem\">";
	$s .= "$link_text</a>\n\t</td>\n</tr>\n";
	return $s;*/
	
	return "<li><a href=\"index.php?$http_varname=$link_handle&uT=y\">$link_text</a></li>";
}


/**
 * Creates a page footer for CQPweb.
 * 
 * Pass in the string "admin" for an admin-logon link. 
 * Default link is to a help page.
 */ 
function print_footer($link = 'help')
{
	global $username;
	
	/* javascript location diverter */
	$diverter = '../';
	
	if ($link == 'help')
	{
		$help_cell = '<td align="center" class="cqpweb_copynote" width="33%">
			<a class="cqpweb_copynote_link" href="help.php" target="_NEW">Corpus and tagset help</a>
		</td>';
	}
	else if ($link == 'admin')
	{
		/* use the help cell for an admin logon link instead */
		$help_cell = '<td align="center" class="cqpweb_copynote" width="33%">
			<a href="adm"  class="cqpweb_copynote_link" >[Admin logon]</a>
		</td>';	
		/* when link is admin, javascript is in lib, which is a subdir. */
		$diverter = '';
	}
	else
	{
		$help_cell = '<td align="center" class="cqpweb_copynote" width="33%">
			&nbsp;
		</td>';
	}
	
	?>
	<hr/>
	<table class="concordtable" width="100%">
		<tr>
			<td align="left" class="cqpweb_copynote" width="33%">
				CQPweb v<?php echo CQPWEB_VERSION; ?> &#169; 2008-2012
			</td>
			<?php echo $help_cell; ?>  
			<td align="right" class="cqpweb_copynote" width="33%">
				<?php
				if ($username == '__unknown_user')
					echo 'You are not logged in';
				else
					echo "You are logged in as user [$username]";
				?>
			</td>
		</tr>
	</table>
	<p>Copyright (c) 2012 HebrewCQPweb.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">FCT</a>.</p>
	</div>
	<script language="JavaScript" type="text/javascript" src="<? echo $diverter; ?>lib/javascript/wz_tooltip.js">
	</script>
	</body>
</html>
	<?php
}











/**
 * Create a system message that will appear below the main "Standard Query"
 * box (and also on the hompage).
 */
function add_system_message($header, $content)
{
	global $instance_name;
	$sql_query = "insert into system_messages set 
		header = '" . mysql_real_escape_string($header) . "', 
		content = '" . mysql_real_escape_string($content) . "', 
		message_id = '$instance_name'";
	/* timestamp is defaulted */
	do_mysql_query($sql_query);
}

/**
 * Delete the system message associated with a particular message_id.
 *
 * The message_id is the user/timecode assigned to the system message when it 
 * was created.
 */
function delete_system_message($message_id)
{
	$message_id = preg_replace('/\W/', '', $message_id);
	$sql_query = "delete from system_messages where message_id = '$message_id'";
	do_mysql_query($sql_query);
}

/**
 * Print out the system messages in HTML, including links to delete them.
 */
function display_system_messages()
{
	global $instance_name;
	global $username;
	global $this_script;
	global $corpus_sql_name;
	global $rss_feed_available;
	
	if (!isset($corpus_sql_name))
	{
		/* we are in /adm */
		$execute_path = 'index.php?admFunction=execute&function=delete_system_message';
		$after_path = urlencode("index.php?thisF=systemMessages&uT=y");
	}
	else
	{
		/* we are in a corpus */
		$execute_path = 'execute.php?function=delete_system_message';
		$after_path = urlencode("$this_script");
	}
	
	$su = user_is_superuser($username);

	$result = do_mysql_query("select * from system_messages order by timestamp desc");
	
	if (mysql_num_rows($result) == 0)
		return;
	
	?>
	<table class="concordtable" >
		<tr>
			<th colspan="<?php echo ($su ? 3 : 2) ; ?>" class="concordtable">
				System messages 
				<?php
				if ($rss_feed_available)
				{
					/* dirty hack: in mainhome there is no username & img/link URL is different */ 
					$rel_add = (($username != '__unknown_user') ?  '../' : '');
						
					?>
					<a href="<?php echo $rel_add;?>rss">
						<img src="<?php echo $rel_add;?>css/img/feed-icon-14x14.png" />
					</a> 
					<?php	
				}
				?> 
			</th>
		</tr>
	<?php
	
	
	while ( ($r = mysql_fetch_object($result)) !== false)
	{
		?>
		<tr>
			<td rowspan="2" class="concordgrey" nowrap="nowrap">
				<?php echo substr($r->timestamp, 0, 10); ?>
			</td>
			<td class="concordgeneral">
				<strong>
					<?php echo htmlentities(stripslashes($r->header)); ?>
				</strong>
			</td>
		<?php
		if ($su)
		{
			echo '
			<td rowspan="2" class="concordgeneral" nowrap="nowrap">
				<a class="menuItem" onmouseover="return escape(\'Delete this system message\')"
				href="'. $execute_path . '&args='
				. $r->message_id .
				'&locationAfter=' . $after_path . '&uT=y">
					[x]
				</a>
			</td>';
		}
		?>
		</tr>
		<tr>
			<td class="concordgeneral">
				<?php
				/* Sanitise, then add br's, then restore whitelisted links ... */
				echo preg_replace(	'|&lt;a\s+href=&quot;(.*?)&quot;\s*&gt;(.*?)&lt;/a&gt;|', 
									'<a href="$1">$2</a>', 
									str_replace("\n", '<br/>', 
												htmlentities(stripslashes($r->content))));
				?>

			</td>
		</tr>			
		<?php
	}
	echo '</table>';
}


/**
 * Convenience function to delete a specified directory, plus everything in it.
 */
function recursive_delete_directory($path)
{
	if (!is_dir($path))
		return;

	$files_to_delete = scandir($path);
	foreach($files_to_delete as &$f)
	{
		if ($f == '.' || $f == '..')
			;
		else if (is_dir("$path/$f"))
			recursive_delete_directory("$path/$f");
		else
			unlink("$path/$f");
	}
	rmdir($path);
}



/**
 * This function stores values in a table that would be too big to send via GET.
 *
 * Instead, they are referenced in the web form by their id code (which is passed 
 * by get) and retrieved by the script that processes the user input.
 * 
 * The return value is the id code that you should use in the web form.
 * 
 * Things stored in the longvalues table are deleted when they are 5 days old.
 * 
 * The retrieval function is longvalue_retrieve().
 *  
 */
function longvalue_store($value)
{
	global $instance_name;
	
	/* clear out old longvalues */
	$sql_query = "delete from system_longvalues where timestamp < DATE_SUB(NOW(), INTERVAL 5 DAY)";
	do_mysql_query($sql_query);
	
	$value = mysql_real_escape_string($value);
	
	$sql_query = "insert into system_longvalues (id, value) values ('$instance_name', '$value')";
	do_mysql_query($sql_query);

	return $instance_name;
}


/**
 * Retrieval function for values stored with longvalue_store.
 */
function longvalue_retrieve($id)
{	
	$id = mysql_real_escape_string($id);
	
	$sql_query = "select value from system_longvalues where id = '$id'";
	$result = do_mysql_query($sql_query);
	
	$r = mysql_fetch_row($result);
		
	return $r[0];
}



// TODO move these to plugins.inc.php?
// TODO can we remoev the if ! empty call? or is it needed for the case where no registry exists?

/** Returns an object from the plugin registry, or else false if not found. */
function retrieve_plugin_info($class)
{
	global $plugin_registry;
	if (!empty($plugin_registry))
		foreach ($plugin_registry as $p)
			if ($p->class == $class)
				return $p;
	return false;
}


/** Returns a list of the available plugins (array of objects from the global registry) of the specified type. */ 
function list_plugins_of_type($type)
{
	global $plugin_registry;
	$result = array();
	if (!empty($plugin_registry))
		foreach ($plugin_registry as $p)
			if ($p->type & $type)
				$result[] = $p;
	return $result;
}


/** Create a page Menu - which shows all the available corpora.*/
function print_Menu($isMainHome)
{
	if ($use_corpus_categories_on_homepage)
	{
		/* get a list of categories */
		$categories = list_corpus_categories();
	
		/* how many categories? if only one, it is either uncategorised or a single assigned cat: ergo don't use cats */
		$n = count($categories);
		if ($n < 2)
			$use_corpus_categories_on_homepage = false;
	}
	else
	{
		/* empty string: to make the loops cycle once */
		$categories = array(0=>'');
	}
	
	echo "<div id=\"menu-wrapper\">
	<div id=\"menu\">
	<table class=\"concordtable\">";
	

	foreach ($categories as $idno => $cat)
	{
		/* get a list of corpora */
		$sql_query = "select corpus, visible from corpus_metadata_fixed where visible = 1 "
				. ($use_corpus_categories_on_homepage ? "and corpus_cat = '$idno'" : '')
				. " order by corpus asc";
	
		$result = do_mysql_query($sql_query);
			
		$corpus_list = array();
		while ( ($x = mysql_fetch_object($result)) != false)
			$corpus_list[] = $x;
			
		/* don't print a table for empty categories */
		if (empty($corpus_list))
			continue;
			
	
	
		if ($use_corpus_categories_on_homepage);
		echo '<tr><th colspan="3" class="concordtable">' . $cat . "</th></tr>\n\n";
			
			
			
		$i = 0;
		$celltype = 'concordgeneral';
		foreach ($corpus_list as $c)
		{
			if ($i == 0)
				echo '<tr>';
			/* get $corpus_title */
			include ("../{$c->corpus}/settings.inc.php");
			if (empty($corpus_title))
				$corpus_title = $c->corpus;
	
			echo "
			<td class=\"$celltype\">
			&nbsp;<br/>
			<a href=\"";
			if (!$isMainHome)
				echo "../";
			echo "{$c->corpus}/\">$corpus_title</a>
			<br/>&nbsp;
			</td>";
	
	
			if ($i == 5)
			{
			echo '</tr>';
			$i = 0;
		}
		else
		{
		$i++;
		}
	
		unset($corpus_title);
		}
		if ($i != 0){
	
		while ($i < 6)
		{
		echo '<td></td>';
		$i++;
	}
	echo '</tr>';
	}
		
	}
	echo" </table>
		 </div>
		<!-- End of the menu dib -->
		</div>
		<!--  End of the menu-wrapper div -->";
}

?>
