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

/* ------------------------------- */
/* Constant definitions for CQPweb */
/* ------------------------------- */

/* version number of CQPweb */
define('CQPWEB_VERSION', '3.0.7');

/* php stubs in each corpus directory; we can't make this constant, but it should be treated as if it was! */ 
$cqpweb_script_files = array( 'api', 'collocation', 'concordance', 'context',
						'distribution', 'execute', 'freqlist',
						'freqtable-compile', 'help', 'index',
						'keywords', 'redirect', 'subcorpus-admin',
						'textmeta', 'upload-query');

/* "reserved words" that can't be used for corpus ids;
 * note: all reserved words are 3 lowercase letters and any new ones we add will also be 3 lowercase letters */
$cqpweb_reserved_subdirs = array('adm', 'bin', 'css', 'doc', 'lib', 'rss', 'usr');



/* plugin type constants */

define('PLUGIN_TYPE_UNKNOWN',				0);
define('PLUGIN_TYPE_ANNOTATOR', 			1);
define('PLUGIN_TYPE_FORMATCHECKER',			2);
define('PLUGIN_TYPE_TRANSLITERATOR',		4);
define('PLUGIN_TYPE_POSTPROCESSOR',			8);
define('PLUGIN_TYPE_ANY',					1|2|4|8);
/**
 * Declares a plugin for later use.
 *
 * This function will normally be used only in the config file.
 * It does not do any error checking, that is done later by the plugin
 * autoload function.
 * 
 * TODO: if I later have an "initialisation" file for all the username setup stuff,
 * this func wou be an obvious candidate for moving there. It has to be in defaults,
 * not library, because the function is called in config.inc.php. But obviously, this
 * is really messy.
 * 
 * @param class                The classname of the plugin. This should be the same as the
 *                             file that contains it, minus .php.
 * @param type                 The type of plugin. One of the following constants:
 *                             PLUGIN_TYPE_ANNOTATOR,
 *                             PLUGIN_TYPE_FORMATCHECKER,
 *                             PLUGIN_TYPE_TRANSLITERATOR,
 *                             PLUGIN_TYPE_POSTPROCESSOR.
 * @param path_to_config_file  What it says on the tin; optional.
 * @return                     No return value.
 */
function declare_plugin($class, $type, $path_to_config_file = NULL)
{
	global $plugin_registry;
	if (!isset($plugin_registry))
		$plugin_registry = array();
	
	$temp = new stdClass();
	
	$temp->class = $class;
	$temp->type  = $type;
	$temp->path  = $path_to_config_file;
	
	$plugin_registry[] = $temp;
}


require_once('../lib/config.inc.php');


/* ------------------------ */
/* GENERAL DEFAULT SETTINGS */
/* ------------------------ */

/* can be overridden by setting these variables in config.inc.php */



/* Global setting: are we running on Windows?
 * 
 * This is not expected to be set in the config file, but it can be if
 * the call to php_uname does not have the desired effect.
 */
if (!isset($cqpweb_running_on_windows))
	$cqpweb_running_on_windows = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');


/* Does mysqld have file-write/read ability? If set to true, CQPweb uses LOAD DATA
 * INFILE and SELECT INTO OUTFILE. If set to false, file write/read into/out of
 * mysql tables is done via the client-server link.
 * 
 * Giving mysqld file access, so that CQPweb can directly exchange files in 
 * $cqpweb_tempdir with the MySQL server, may be considerably more efficient.
 * 
 * (BUT -- we've not tested this yet)
 * 
 * The default is false. 
 */
if (!isset($mysql_has_file_access))
	$mysql_has_file_access = false;

/*
 * -- If mysqld has file access,  it is mysqld (not the php-mysql-client) which
 * will do the opening of the file.
 * -- But if mysqld does not have file access, then we should load all infiles locally.
 */
if ($mysql_has_file_access)
	$mysql_LOAD_DATA_INFILE_command = 'LOAD DATA INFILE';
else
	$mysql_LOAD_DATA_INFILE_command = 'LOAD DATA LOCAL INFILE';

/* Has MySQL got LOAD DATA LOCAL disabled? */
if (!isset($mysql_local_infile_disabled))
	$mysql_local_infile_disabled = false;
	
/* From the previous two variables, deduce whether we have ANY infile access. */
if ($mysql_has_file_access)
	/* if the SERVER has file access, then lack of LOAD DATA LOCAL doesn't matter */
	// in THEORY. I haven't checked ths out with a server that has LOAD DATA LOCAL disabled.
	$mysql_infile_disabled = false;
else
	/* otherwise, whether we have ANY infile access is dependent on whether we have local access */
	$mysql_infile_disabled = $mysql_local_infile_disabled;




/* TEMPORARY DIRECTORY */
if (!isset($cqpweb_tempdir))
{
	echo('CRITICAL ERROR: $cqpweb_tempdir has not been set');
	exit();
}


/* These are defaults for the max amount of memory allowed for CWB programs that let you set this,
 * counted in megabytes. The first is used for web-scripts, the second for CLI-scripts. */
if (!isset($cwb_max_ram_usage))
	$cwb_max_ram_usage = 50;
else
	$cwb_max_ram_usage = (int)$cwb_max_ram_usage;
if (!isset($cwb_max_ram_usage_cli))
	$cwb_max_ram_usage_cli = 1000;
else
	$cwb_max_ram_usage_cli = (int)$cwb_max_ram_usage_cli;
/* the default allows generous memory for indexing in command-line mode,
 * but is stingy in the Web interface, so admins can't bring down the server accidentally */


/* Canonical form for $cwb_extra_perl_directories is an array of absolute directories without
 * an initial / even though they are absolute; but the input format is a string of pipe-
 * delimited directories. This bit of code converts. An empty array is used if the config
 * string vairable is not set. 
 */ 
if (isset($cwb_extra_perl_directories))
{
	$cwb_extra_perl_directories = explode('|',$cwb_extra_perl_directories);
	foreach($cwb_extra_perl_directories as &$perldir)
		$perldir = trim($perldir, "/ \t\r\n");
	unset($perldir);
	//TODO when the overall format of resource-location paths is changed, so should the code here. 
}
else
	$cwb_extra_perl_directories = array();
	

/* the following stops calls to CQP::set_corpus causing an error in the "adm" scripts */
if (!isset($corpus_cqp_name))
	$corpus_cqp_name = ';';

if (!isset($utf8_set_required))
	$utf8_set_required = true;
	
/* the next defaults are for tweaks to the system -- not so much critical! */

if (!isset($use_corpus_categories_on_homepage))
	$use_corpus_categories_on_homepage = false;

if (!isset($css_path_for_homepage))
	$css_path_for_homepage = "../css/shotgunandshells_style.css";

if (!isset($css_path_for_adminpage))
	$css_path_for_adminpage = "../css/shotgunandshells_style.css";

if (!isset($homepage_welcome_message))
	$homepage_welcome_message = "Hebrew CQP web!";

if (!isset($searchpage_corpus_name_suffix))
	$searchpage_corpus_name_suffix = ': <em>powered by CQPweb</em>';

if (!isset($create_password_function))
	$create_password_function = "password_insert_internal";

if (!isset($password_more_security))
	$password_more_security = false;

if (!isset($cqpweb_uses_apache))
	$cqpweb_uses_apache = true;

if (!isset($print_debug_messages))
	$print_debug_messages = false;

if (!isset($debug_messages_textonly))
	$debug_messages_textonly = false;
/* but whether it was set or not we override it on the command-line */
if (php_sapi_name() == 'cli')
	$debug_messages_textonly = false;

if (!isset($rss_feed_available))
	$rss_feed_available = false;




/* This is not a default - it cleans up the input, so we can be sure the root
 * URL ends in a slash. */
if (isset($cqpweb_root_url))
	$cqpweb_root_url = rtrim($cqpweb_root_url, '/') . '/';


/* --------------------------- */
/* PER-CORPUS DEFAULT SETTINGS */
/* --------------------------- */
/* for if settings.inc.php don't specify them */

if (!isset($corpus_main_script_is_r2l))
	$corpus_main_script_is_r2l = false;

if (!isset($corpus_need_inverse_numbers))
{
	$corpus_need_inverse_numbers = false;
}

if (!isset($corpus_uses_case_sensitivity))
	$corpus_uses_case_sensitivity = false;

$corpus_sql_collation = $corpus_uses_case_sensitivity ? 'utf8_bin' : 'utf8_general_ci' ;
$corpus_cqp_query_default_flags = $corpus_uses_case_sensitivity ? '' : '%c' ; 


if (!isset($utf8_set_required))
	$utf8_set_required = false;

if (!isset($css_path))
	$css_path = "../css/CQPweb.css";

if (!isset($graph_img_path))
	$graph_img_path = "../css/img/blue.bmp";

if (!isset($dist_num_files_to_list))
	$dist_num_files_to_list = 100;

if (isset($context_s_attribute))
	$context_scope_is_based_on_s = true;
else
	$context_scope_is_based_on_s = false;

if (!isset($context_scope))
	$context_scope = ( $context_scope_is_based_on_s ? 1 : 12 );

//TODO. next few variable names are confusing

if (!isset($default_per_page))
	$default_per_page = 50;

if (!isset($default_history_per_page))
	$default_history_per_page = 100;

if (!isset($default_extended_context))
	$default_extended_context = 100;

if (!isset($default_max_context))
	$default_max_context = 1100;

/* position labels default off */
if (!isset($visualise_position_labels))
	$visualise_position_labels = false;
else
	if (!isset($visualise_position_label_attribute))
		$visualise_position_labels = false;

/* interlinear glossing default off */
if (!isset($visualise_gloss_in_concordance))
	$visualise_gloss_in_concordance = false;
if (!isset($visualise_gloss_in_context))
	$visualise_gloss_in_context = false;
if ($visualise_gloss_in_concordance || $visualise_gloss_in_context)
	if (!isset($visualise_gloss_annotation))
		$visualise_gloss_annotation = 'word'; 

/* supply translations default off */
if (!isset($visualise_translate_in_concordance))
	$visualise_translate_in_concordance = false;
if (!isset($visualise_translate_in_context))
	$visualise_translate_in_context = false;
if (!isset($visualise_translate_s_att))
{
	/* we can't default this one: we'll have to switch off these variables */
	$visualise_translate_in_context = false;
	$visualise_translate_in_concordance = false;
}
else
{
	/* we override $context_scope etc... if this is to be used in concordance */
	if ($visualise_translate_in_concordance)
	{
		$context_s_attribute = $visualise_translate_s_att;
		$context_scope_is_based_on_s = true;
		$context_scope = 1;
	}
}
 

	
/* collocation defaults */
if (!isset($default_colloc_range))
	$default_colloc_range = 5;
	
if (!isset($default_calc_stat))
	$default_calc_stat = 6; 	/* {6 == log-likelihood} is default collocation statistic */

if (!isset($default_colloc_minfreq))
	$default_colloc_minfreq = 5;

if (!isset($default_collocations_per_page))
	$default_collocations_per_page = 50;
	
if (!isset($collocation_warning_cutoff))
	$collocation_warning_cutoff = 5000000; /* cutoff for going from a minor warning to a major warning */

/* collocation download default */
if (!isset($default_words_in_download_context))
	$default_words_in_download_context = 10;





/* ----------------------- */
/* SYSTEM DEFAULT SETTINGS */
/* ----------------------- */

/* some can be overrridden in the config file -- some can't! */


/* control the size of the history table */
if (!isset($history_maxentries))
	$history_maxentries = 5000;
if (!isset($history_weekstokeep))
	$history_weekstokeep = 12;
// TODO note: this doesn't seem to be working ... dunno why...
// TODO but the latest version of BNCweb doesn't delete from query_history anyway
// TODO all history-deleting code should be deleted.


/* other maximums for mysql, NOT settable in config.inc.php */
$max_textid_length = 40;

/* Total size (in bytes) of temp files (for CQP only!) */
/* before cached queries are deleted: default is 3 GB  */
if (!isset($cache_size_limit))
	$cache_size_limit = 3221225472;

//TODO the way DB maxima are calculated is dodgy, to say the least.
// PROBLEMS: (1) names beginning $default that aren;t defaults is confusing, as above
// (2) are the limits working as they should?

/* Default maximum size for DBs -- can be changed on a per-user basis */
if (!isset($default_max_dbsize))
	$default_max_dbsize = 1000000;
/* important note about default_max_dbsize: it refers to the ** query ** on which 
   the create_db action is being run. A distribution database will have as many rows as there
   are solutions, but a collocation database will have the num solutions x window x 2.
   
   For this reason we need the next variable as well, to control the relationship
   between the max dbsize as taken from the user record, and the effective max dbsize
   employed when we are creating a collocation database (rather than any other type of DB)
   */
if (!isset($colloc_db_premium))
	$colloc_db_premium = 4;

/* Total size (in rows) of database (distribution, colloc, etc) tables */
/* before cached dbs are deleted: default is 100 of the biggest db possible  */
if (!isset($default_max_fullsize_dbs_in_cache))
	$default_max_fullsize_dbs_in_cache = 100;

$mysql_db_size_limit = $default_max_fullsize_dbs_in_cache * $colloc_db_premium * $default_max_dbsize;

/* same for frequency tables: defaulting to 3 gig */
if (!isset($mysql_freqtables_size_limit))
	$mysql_freqtables_size_limit = 3221225472;

/* max number of concurrent mysql processes of any one kind (big processes ie collocation, sort) */
if (!isset($default_mysql_process_limit))
	$default_mysql_process_limit = 5;

$mysql_process_limit = array(
	'colloc' => $default_mysql_process_limit,
	'freqtable' => $default_mysql_process_limit,
	'sort' => $default_mysql_process_limit,
	'dist' => 100,
	'catquery' => $default_mysql_process_limit
	);
/* plus names for if they need to be printed */
$mysql_process_name = array(
	'colloc'=> 'collocation',
	'dist' => 'distribution',
	'sort' => 'query sort',
	'freq_table' => 'frequency list' // TODO shjould this be freqtable?????????
	// TODO do we need catquery here? see where this is used.
	);




/* --------------------------------------------- */
/* VARIABLES SPECIFIC TO THIS INSTANCE OF CQPWEB */
/* --------------------------------------------- */

/* if apache (or the like) is not being used, then $username should be set by code in config.inc.php */
if (!isset($username))
	$username = ( isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] :  $superuser_username );



/* $instance_name is the unique identifier of the present run of a given script 
 * which will be used as the name of any queries/records saved by the present script.
 * 
 * It was formerly the username plus the unix time, but this raised the possibility of
 * one user seeing another's username linked to a cached query. So now it's the PHP uniqid(),
 * which is a hexadecimal version of the Unix time in microseconds. This shouldn't be 
 * possible to duplicate unless (a) we're on a computer fast enough to call uniqid() twice
 * in two different processes in the same microsecond AND (b) two users do happen to hit 
 * the server in the same microsecond. Unlikely, but id codes based on the $instance_name
 * should still be checked for uniqueness before being used in any situation where the 
 * uniqueness matters (e.g. as a database primary key).
 * 
 * For compactness, we convert to base-36.  Total length = 10 chars (for the foreseeable future!).
 */ 
$instance_name = base_convert(uniqid(), 16, 36);

if (! isset($this_script))
{
	preg_match('/\/([^\/]+)$/', $_SERVER['SCRIPT_FILENAME'], $m);
	$this_script = $m[1];
}



/* ------------ */
/* MAGIC QUOTES */
/* ------------ */

/* a simplified version of the code here: http://php.net/manual/en/security.magicquotes.disabling.php 
 * (simplified because we know that in CQPweb $_GET/$_POST is always a one-dimensional array) */

if (get_magic_quotes_gpc()) 
{
	foreach ($_POST as $k => $v) 
	{
		unset($_POST[$k]);
		$_POST[stripslashes($k)] = stripslashes($v);
	}
	unset($k, $v);
	foreach ($_GET as $k => $v) 
	{
		unset($_GET[$k]);
		$_GET[stripslashes($k)] = stripslashes($v);
	}
	unset($k, $v);
}


?>
