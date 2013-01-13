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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CQPweb Main Page</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/<?php echo $css_path_for_homepage;?>"  media="screen"/>


</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><?php mainpage_print_logos(); echo $homepage_welcome_message; ?></h1>
				<p>Please select a corpus from the list below to enter</p>
			</div>
		</div>
	</div>
	<!--  End of the header-wrapper div -->
	<div id="menu-wrapper">
		<div id="menu">
			<table class="concordtable">
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
					
				
				
					if ($use_corpus_categories_on_homepage);
						//echo '<tr><th colspan="3" class="concordtable">' . $cat . "</th></tr>\n\n";
					
					
					
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
								<a href=\"{$c->corpus}/\">$corpus_title</a>
								<br/>&nbsp;
							</td>";
						
						
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
					if ($i != 0){

					while ($i < 2)
					{
						echo '<td></td>';
					}
					echo '</tr>';
					}
					
				}
				?>			
			</table>
		</div>
		<!-- End of the menu dib -->
	</div>
	<!--  End of the menu-wrapper div -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
					<div class="post">
						<h2 class="title"><a href="#">Welcome to the Graphical User Interface for KWIC in Hebrew </a></h2>
						<div class="entry">
							<p><img src="images/1.gif" width="600" height="225" alt="" /></p>
							<p>Key Word In Context (KWIC) is an algorithm which, given a text and a keyword, presents all the occurrences of the word in the text, allowing a few context words on both sides of the keyword to be displayed. Such a tool is very useful for linguistic research.</p>
						</div>
					</div>
					<div class="post">
						<h2 class="title"><a href="http://cwb.sourceforge.net/">The full power of CQP QueryEngine</a></h2>
						<div class="entry">
							<p><img src="images/ocwb-logo.big.png" width="600" height="225" alt="" /></p>
							<p>This website uses the powerful CQP query engine created by the <a href="http://cwb.sourceforge.net/">CWB</a> group. </p>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
				<!-- end #content -->
				<div id="sidebar">
					<ul>
						<li>
							<h2>Creators</h2>
							<ul>
								<li><a href="#">Zahi Kfir</a></li>
								<li><a href="#">Haim Shalelashvili</a></li>
							</ul>
						</li>
						<li>
							<h2>Cooperation with:</h2>
							<ul>
								<li><img src="images/ocwb-logo.white.png" height="50" width="120" alt="" /></li>
								<li><img src="images/CLGDOCSUOH.png" height="50" width="120" alt="" /></li>
								<li><img src="images/logo.png" height="50" width="120"  alt="" /></li>
							</ul>
						</li>
						<li>
							<h2>About:</h2>
						</li>
						<li>
							<h2>Tutorials:</h2>
						</li>
					</ul>
				</div>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
	<!--  End of the page div -->
</div>
<!--  End of wrapper -->

<div id="footer">

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