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


/* Very first thing: Let's work in a subdirectory so that we can use the same subdirectory references! */
chdir('bin');


include ("../lib/defaults.inc.php");
include ("../lib/library.inc.php");
include ("../lib/metadata.inc.php");
include ("../lib/exiterror.inc.php");

/* connect to mySQL */
connect_global_mysql();



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



header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>

<title>CQPweb Main Page</title>

<link rel="stylesheet" type="text/css" href="css/<?php echo $css_path_for_homepage;?>" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>

<table class="concordtable" width="100%">

	<tr>
		<th colspan="3" class="concordtable">
			<?php mainpage_print_logos(); echo $homepage_welcome_message; ?>
			<br/>
			<em>Please select a corpus from the list below to enter.</em>
		</th>
	</tr>

<?php


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
	


	if ($use_corpus_categories_on_homepage)
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
			<td class=\"$celltype\" width=\"33%\" align=\"center\">
				&nbsp;<br/>
				<a href=\"{$c->corpus}/\">$corpus_title</a>
				<br/>&nbsp;
			</td>";
		
		$celltype = ($celltype=='concordgrey'?'concordgeneral':'concordgrey');
		
		if ($i == 2)
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
	
	if ($i == 1)
	{
		echo "<td class=\"$celltype\" width=\"33%\" align=\"center\">&nbsp;</td>";
		$i++;
		$celltype = ($celltype=='concordgrey'?'concordgeneral':'concordgrey');
	}
	if ($i == 2)
		echo "<td class=\"$celltype\" width=\"33%\" align=\"center\">&nbsp;</td>";
}

?>

			
</table>

<?php

display_system_messages();

print_footer('admin');

/* disconnect mysql */
disconnect_global_mysql();


/* END OF SCRIPT */

/* this is in a function to keep all the if clauses out of the way of the main HTML */
function mainpage_print_logos()
{
	foreach ( array('left', 'right') as $side)
	{
		$addresses = 'homepage_logo_'.$side;
		global $$addresses;
		if (!isset($$addresses))
			continue;
		if (false !== strpos($$addresses, "\t"))
			list ($img_url, $link_url) = explode("\t", $$addresses, 2);	
		else
		{
			$img_url = $$addresses;
			$link_url = false;
		}
		echo "<div style=\"float: $side;\">";
		if ($link_url) echo "<a href=\"$link_url\">";
		echo "<img src=\"$img_url\" height=\"80\"  border=\"0\" >";
		if ($link_url) echo '</a>';
		echo '</div>      ';
	}
} 
?>