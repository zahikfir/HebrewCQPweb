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





/* before anything else */
header('Content-Type: text/html; charset=utf-8');


/* initialise variables from settings files  */

require("settings.inc.php");
require("../lib/defaults.inc.php");


/* include function library files */
include ("../lib/library.inc.php");
include ("../lib/exiterror.inc.php");
include ("../lib/metadata.inc.php");




if (!url_string_is_valid())
	exiterror_bad_url();



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo '<title>' . $corpus_title . ': viewing text metadata -- CQPweb </title>';
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
					<p></p>
				</div>
			</div>
			<!-- End of header -->
		</div>
		<!-- End of header-wrapper -->
	</div>
	<!-- End of wrapper -->
		<div id="widepage">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="maincontent">
<?php


/* download the information */

/* connect to mySQL */
connect_global_mysql();


	
/* initialise variables from $_GET */

if (! isset($_GET["text"]) )
{
	echo "<p class='errormessage'>View text metadata: No text specified! Please reload CQPweb.
		</p></body></html>";
	exit();
}
else 
	$text_id = mysql_real_escape_string($_GET["text"]);
	

$result = do_mysql_query("SELECT * from text_metadata_for_$corpus_sql_name 
	where text_id = '$text_id'");

if (mysql_num_rows($result) < 1)
{
	// TODO use a proper exiterror_ call here, and also elsewhere in this file.
	?>
	<p class="errormessage">
		The database doesn't appear to contain any metadata for text <?php echo $text_id; ?>!
	</p></body></html> 
	<?php
	exit(1);
}


echo 
'<table class="concordtable" width="100%">
	<tr>
		<th colspan="2" class="concordtable">';
echo "Metadata for text <em>$text_id</em>
		</th>
	</tr>";


$metadata = mysql_fetch_row($result);
$n = count($metadata);

for ( $i = 0 ; $i < $n ; $i++ )
{
	$att = metadata_expand_attribute(mysql_field_name($result, $i), $metadata[$i]);
	
	/* this expansion is hardwired */
	if ($att['field'] == 'text_id')
		$att['field'] =  'Text identification label';
	/* this expansion is hardwired */
	if ($att['field'] == 'words')
		$att['field'] =  'No. words in text';
	/* don't show the CQP delimiters for the file */
	if ($att['field'] == 'cqp_begin' || $att['field'] == 'cqp_end')
		continue;

	/* don't allow empty cells */
	if ($att['value'] == '')
		$att['value'] = '&nbsp;';
	/* if the value is a URL, convert it to a link */
	if ( 0 < preg_match('#^(https?|ftp)://#', $att['value']) )
	{
		/* pipe is used as a delimiter between URL and linktext to show. */
		if (false !== strpos($att['value'], '|'))
		{
			list($url, $linktext) = explode('|', $att['value']);
			$att['value'] = '<a target="_blank" href="'.$url.'">'.$linktext.'</a>';
		}
		else
			$att['value'] = '<a target="_blank" href="'.$att['value'].'">'.$att['value'].'</a>';
	}
	
	echo '<tr><td class="concordgrey">' . $att['field']
		. '</td><td class="concordgeneral">' . $att['value'] . '</td></tr>
		';
		
	unset($att);
}

/* disconnect mysql */
disconnect_global_mysql();

echo '</table>';
?>
<div style="clear: both;">&nbsp;</div>
					</div>
					<!-- End of content -->
					<div style="clear: both;">&nbsp;</div>
				</div>
				<!-- End of page-bgbtm -->
			</div>
			<!-- End of page-bgtop -->
		</div>
		<!-- End of page -->





<div id="footer">
<?php 
print_footer();

?>
</body>
</html>