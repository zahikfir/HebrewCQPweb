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






/* index.inc.php --- this file contains the code that renders 
 * various search screens and other front-page stuff (basically
 * everything you access from the mainpage side-menu).
 */

/* The main paramater for forms that access this script:
 *
 * thisQ - specify the type of query you want to pop up
 * 
 * Each different thisQ effectively runs a separate interface.
 * Some of the forms etc. that are created lead to other parts of 
 * CQPweb; some, if they're easy to process, are dealt with here.
 */


/* ------------ */
/* BEGIN SCRIPT */
/* ------------ */



/* initialise variables from settings files  */

require_once ("settings.inc.php");
require_once("../lib/defaults.inc.php");


/* include function library files */
require_once("../lib/library.inc.php");
require_once("../lib/user-settings.inc.php");
require_once("../lib/exiterror.inc.php");
require_once("../lib/cache.inc.php");
require_once("../lib/subcorpus.inc.php");
require_once("../lib/db.inc.php");
require_once("../lib/ceql.inc.php");
require_once("../lib/freqtable.inc.php");
require_once("../lib/metadata.inc.php");
require_once("../lib/concordance-lib.inc.php");
require_once("../lib/colloc-lib.inc.php");

/* this is probably _too_ paranoid. but hey */
if (user_is_superuser($username))
{
	require_once('../lib/apache.inc.php');
	require_once('../lib/admin-lib.inc.php');
	require_once('../lib/corpus-settings.inc.php');
	require_once('../lib/xml.inc.php');		// move to main section if users need XML functions
}


/* especially, include the functions for each type of query */
require_once("../lib/indexforms-queries.inc.php");
require_once("../lib/indexforms-saved.inc.php");
require_once("../lib/indexforms-admin.inc.php");
require_once("../lib/indexforms-subcorpus.inc.php");
require_once("../lib/indexforms-others.inc.php");






/* initialise variables from $_GET */

/* in the case of index.php, we can allow there not to be any arguments, and supply a default;
 * so don't check for presence of uT=y */

/* thisQ: the query whose interface page is to be displayed on the right-hand-side. */
$thisQ = ( isset($_GET["thisQ"]) ? $_GET["thisQ"] : 'search' );
	
/* NOTE: some particular printquery_.* functions will demand other $_GET variables */





/* connect to mySQL */
connect_global_mysql();

/* before anything else */
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo '<title>' . $corpus_title . ' -- CQPweb</title>';
echo '<link href=\'http://fonts.googleapis.com/css?family=Arvo\' rel=\'stylesheet\' type=\'text/css\'>';
echo '<link rel="stylesheet" type="text/css" href="' . $css_path . '" />';
?>
<script type="text/javascript" src="../lib/javascript/cqpweb-clientside.js"></script> 
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><?php  echo $homepage_welcome_message; ?></h1>
				<p><?php echo $corpus_title . $searchpage_corpus_name_suffix; ?></p>
			</div>
		</div>
	</div>
	<!-- End of the header-wrapper -->
	<?php print_Menu(false /*IsMainHome*/);?>
	<div id="Page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
						<?php
				
						/* ********************************** */
						/* PRINT MAIN SEARCH FUNCTION CONTENT */
						/* ********************************** */
				
						switch($thisQ)
						{
						case 'search':
							printquery_search();
								require("../ourExtensions/ComputeQueryGui.php");
							display_system_messages();
							break;
						
						case 'restrict':
							printquery_restricted();
							break;
						
						case 'lookup':
							printquery_lookup();
							break;
						
						case 'freqList':
							printquery_freqlist();
							break;
						
						case 'keywords':
							printquery_keywords();
							break;
						
						case 'userSettings':
							printquery_usersettings();
							printquery_usermacros();
							break;
						
						case 'history':
							printquery_history();
							break;
						
						case 'savedQs':
							printquery_savedqueries();
							break;
							
						case 'categorisedQs':
							printquery_catqueries();
							break;
						
						case 'uploadQ':
							printquery_uploadquery();
							break;
							
						case 'subcorpus':
							printquery_subcorpus();
							break;
						
						case 'corpusMetadata':
							printquery_corpusmetadata();
							break;
						
						case 'corpusSettings':
							printquery_corpusoptions();
							break;
						
						case 'userAccess':
							printquery_manageaccess();
							break;
						
						case 'manageMetadata':
							printquery_managemeta();
							break;
						
						case 'manageCategories':
							printquery_managecategories();
							break;
						
						case 'manageAnnotation':
							printquery_manageannotation();
							break;
						
						case 'manageVisualisation':
							printquery_visualisation();
							printquery_xmlvisualisation();
							break;
						
						case 'cachedQueries':
							printquery_showcache();
							break;
						
						case 'cachedDatabases':
							printquery_showdbs();
							break;
						
						case 'cachedFrequencyLists':
							printquery_showfreqtables();
							break;
						
						case 'who_the_hell':
							printquery_who();
							break;
							
						case 'latest':
							printquery_latest();
							break;
						
						case 'bugs':
							printquery_bugs();
							break;
						
						
						
						default:
							?>
							<p class="errormessage">&nbsp;<br/>
								&nbsp; <br/>
								We are sorry, but that is not a valid menu option.
							</p>
							<?php
							break;
						}	
					/* finish off the page */
					?>

				<div style="clear: both;">&nbsp;</div>	
				</div>
				
				<!--  End of content div -->
				<div id="sidebar">
					<?php
					
					/* ******************* */
					/* PRINT SIDE BAR MENU */
					/* ******************* */
					?>
					<ul>
						<li>
							<h1>Menu</h1>
						</li>
						<li>
							<h2>Corpus queries</h2>
							<ul>
								<?php
								echo print_menurow_index('search', 'Standard query');
								echo print_menurow_index('freqList', 'Frequency lists');
								echo print_menurow_index('keywords', 'Keywords');
								?>
							</ul>
						</li>
						<li>
							<h2> User controls </h2>
							<ul>
								<?php
								echo print_menurow_index('history', 'Query history');
								echo print_menurow_index('savedQs', 'Saved queries');
								echo print_menurow_index('subcorpus', 'Create/edit subcorpora');
								?>
							</ul>
						</li>
						<li>
							<h2>Corpus info</h2>
							<ul>
								<?php
									/* note that most of this section is links-out, so we can't use the print-row function */
									
									/* SHOW CORPUS METADATA */
									echo "<li><a class=\"menuItem\" " 
											. "href=\"index.php?thisQ=corpusMetadata&uT=y\" "
											. "onmouseover=\"return escape('View CQPweb\'s database of information about this corpus')\">";
									echo "View corpus metadata</a></li>";
									
									
									/* print a link to a corpus manual, if there is one */
									$sql_query = "select external_url from corpus_metadata_fixed "
										. "where corpus = '$corpus_sql_name' and external_url IS NOT NULL";
									$result = do_mysql_query($sql_query);
									if (mysql_num_rows($result) < 1)
										echo '<li><a class="menuCurrentItem">Corpus documentation</a></li>';
									else
									{
										$row = mysql_fetch_row($result);
										echo '<li><a target="_blank" class="menuItem" href="'
											. $row[0] . '" onmouseover="return escape(\'Info on ' . addcslashes($corpus_title, '\'')
											. ' on the web\')">' . 'Corpus documentation</a></li>';
									}
									unset($result);
									unset($row);
									
									
									/* print a link to each tagset for which an external_url is declared in metadata */
									$sql_query = "select description, tagset, external_url from annotation_metadata "
										. "where corpus = '$corpus_sql_name' and external_url IS NOT NULL";
									$result = do_mysql_query($sql_query);
									
									while (($row = mysql_fetch_assoc($result)) != false)
									{
										if ($row['external_url'] != '')
											echo '<li><a target="_blank" class="menuItem" href="'
												. $row['external_url'] . '" onmouseover="return escape(\'' . $row['description']
												. ': view documentation\')">' . $row['tagset'] . '</a></li>';
									}
									unset($result);
									unset($row);
									
									
									
									/* these are the super-user options */
									if (user_is_superuser($username))
									{
										?>
							</ul>
						</li>
						<li>
							<ul>
								<h2>Admin tools</h2>
								<ul>
									<li><a class="menuItem" href="../adm">Admin control panel</a></li>
									<?php
									
									echo print_menurow_index('corpusSettings', 'Corpus settings');
									echo print_menurow_index('manageMetadata', 'Manage metadata');
									echo print_menurow_index('cachedQueries', 'Cached queries');
									echo print_menurow_index('cachedDatabases', 'Cached databases');
									echo print_menurow_index('cachedFrequencyLists', 'Cached frequency lists');
									
								} /* end of "if user is a superuser" */
								
								?>
								</ul>
							</ul>
						</li>
						<li>
							<ul>
								<h2>About CQPweb</h2>
								<ul>
									<li><a class="menuItem" href="../"
										onmouseover="return escape('Go to a list of all corpora on the CQPweb system')">
										CQPweb main menu
									</a></li>
									<li><a class="menuItem" target="_blank" href="../doc/CQPweb-man.pdf"
										onmouseover="return escape('CQPweb manual')">
										CQPweb manual
									</a></li>
									<?php
									echo print_menurow_index('who_the_hell', 'Who did it?');
									echo print_menurow_index('latest', 'Latest news');
									echo print_menurow_index('bugs', 'Report bugs');
									?>
								</ul>
							</ul>
						</li>
					</ul>
				</div>
				<!-- End of sidebar div -->
				<div style="clear: both;">&nbsp;</div>
			</div>
			<!--  End of page-bgbtm div -->
		</div>
		<!--  End of pagt-bgtop div -->
	</div>
	<!-- End of page div -->
</div>
<!--  End of the wrapper -->

<div id="footer">
<?php

print_footer();

cqpweb_shutdown_environment();


?>
