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







function printquery_corpusoptions()
{
	global $corpus_sql_name;
	
	if (isset($_GET['settingsUpdateURL']))
		update_corpus_metadata('external_url',$_GET['settingsUpdateURL']);
	if (isset($_GET['settingsUpdatePrimaryClassification']))
		update_corpus_metadata('primary_classification_field', $_GET['settingsUpdatePrimaryClassification']);
	if (isset($_GET['settingsUpdateContextScope']))
	{
		if ($_GET['settingsUpdateContextUnit'] == '*words*')
			$_GET['settingsUpdateContextUnit'] = NULL;
		update_corpus_context_scope($_GET['settingsUpdateContextScope'], $_GET['settingsUpdateContextUnit']);
	}


	$classifications = metadata_list_classifications();
	$class_options = '';
	
	$primary = get_corpus_metadata('primary_classification_field');
	
	foreach ($classifications as &$class)
	{
		$class_options .= "<option value=\"{$class['handle']}\"";
		$class_options .= ($class['handle'] === $primary ? 'selected="selected"' : '');
		$class_options .= '>' . $class['description'] . '</option>';
	}
	
	/* object containing the core settings */
	$settings = new CQPwebSettings('..');
	$settings->load($corpus_sql_name);
	$r2l = $settings->get_r2l();
	$needInverse = $settings->get_inverseNumbers();
	$case_sensitive = $settings->get_case_sens();



	?>
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable">Corpus options</th>
		</tr>
	</table>
	
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable" colspan="3">Core corpus settings</th>
		</tr>
		<form action="execute.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					Corpus title:
				</td>
				<td class="concordgeneral" align="center">
					<input type="text" name="args" value="<?php echo $settings->get_corpus_title(); ?>" />
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="locationAfter" value="index.php?thisQ=corpusSettings&uT=y" />
			<input type="hidden" name="function" value="update_corpus_title" />
			<input type="hidden" name="uT" value="y" />
		</form>
		<form action="execute.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					Directionality of main corpus script:
				</td>
				<td class="concordgeneral" align="center">
					<select name="args">
						<!-- note, false = left-to-right -->
						<option value="0" <?php echo ($r2l ? '' : 'selected="selected"'); ?>>Left-to-right</option>
						<option value="1" <?php echo ($r2l ? 'selected="selected"' : ''); ?>>Right-to-left</option>
					</select>
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="locationAfter" value="index.php?thisQ=corpusSettings&uT=y" />
			<input type="hidden" name="function" value="update_corpus_main_script_is_r2l" />
			<input type="hidden" name="uT" value="y" />
		</form>
		<form action="execute.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					Reverse Numbers:
				</td>
				<td class="concordgeneral" align="center">
					<select name="args">
						<option value="0" <?php echo ($needInverse ? '' : 'selected="selected"'); ?>>No</option>
						<option value="1" <?php echo ($needInverse ? 'selected="selected"' : ''); ?>>Yes</option>
					</select>
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="locationAfter" value="index.php?thisQ=corpusSettings&uT=y" />
			<input type="hidden" name="function" value="update_corpus_inverse_numbers" />
			<input type="hidden" name="uT" value="y" />
		</form>
		<form action="execute.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					Corpus requires case-sensitive collation for string comparison and searches
					<br/>&nbsp;<br/>
					<em>
						(note: the default, and recommended, value is &ldquo;No&rdquo;; if you change this  
						<br/>
						setting, you must delete and recreate all frequency lists and delete cached databases)
					</em> 
				</td>
				<td class="concordgeneral" align="center">
					<select name="args">
						<!-- note, 0 (false) = set to false -->
						<option value="0" <?php echo ($case_sensitive ? '' : 'selected="selected"'); ?>>No</option>
						<option value="1" <?php echo ($case_sensitive ? 'selected="selected"' : ''); ?>>Yes</option>
					</select>
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="locationAfter" value="index.php?thisQ=corpusSettings&uT=y" />
			<input type="hidden" name="function" value="update_corpus_uses_case_sensitivity" />
			<input type="hidden" name="uT" value="y" />
		</form>
		
		

		<!-- ***************************************************************************** -->

		<tr>
			<th class="concordtable" colspan="3">Display settings</th>
		</tr>
		<form action="execute.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					Stylesheet address
					(<a href="<?php echo $settings->get_css_path(); ?>">click here to view</a>):
				</td>
				<td class="concordgeneral" align="center">
					<input type="text" name="args" value="<?php echo $settings->get_css_path(); ?>" />
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="locationAfter" value="index.php?thisQ=corpusSettings&uT=y" />
			<input type="hidden" name="function" value="update_css_path" />
			<input type="hidden" name="uT" value="y" />
		</form>
		<form action="index.php" method="get">
			<tr>
				<td class="concordgrey" align="center">
					How many words/elements of context should be shown in concordances?
					<br/>&nbsp;<br/>
					<em>Note: context of a hit is counted <strong>each way</strong>.
				</td>
				<td class="concordgeneral" align="center">
					show
					<input type="text" name="settingsUpdateContextScope" size="3"
						value="<?php echo $settings->get_context_scope(); ?>" />
					of
					<select name="settingsUpdateContextUnit">
						<?php

						$current_scope_unit = $settings->get_context_s_attribute();

						echo '<option value="*words*"' 
							. ( is_null($current_scope_unit) ? ' selected="selected"' : '' ) 
							. '>words</option>';

						$all_elements = array_diff(get_xml_all(), get_xml_annotations(), array('text'));
						foreach ($all_elements as $element)
							echo "<option value=\"$element\""
								. ($element == $current_scope_unit ? ' selected="selected"' : '')
								. ">XML element: $element</option>";

						?>
						
					</select>
				</td>
				<td class="concordgeneral" align="center">
					<input type="submit" value="Update" />
				</td>
			</tr>
			<input type="hidden" name="thisQ" value="corpusSettings" />
			<input type="hidden" name="uT" value="y" />
		</form>

	</table>
	<?php
}





function printquery_manageaccess()
{
	global $corpus_sql_name;
	global $cqpweb_uses_apache;
	
	if ($cqpweb_uses_apache)
	{	
		$access = get_apache_object(realpath('.'));
		$access->load();
		
		$all_groups = $access->list_groups();
		$allowed_groups = $access->get_allowed_groups();
		$disallowed_groups = array();
		foreach($all_groups as &$g)
			if (! in_array($g, $allowed_groups))
				$disallowed_groups[] = $g;
	
		$options_groups_to_add = '';
		foreach($disallowed_groups as &$dg)
			$options_groups_to_add .= "\n\t\t<option>$dg</option>";
			
		$options_groups_to_remove = '';
		foreach($allowed_groups as &$ag)
		{
			if ($ag == 'superusers')
				continue;
			$options_groups_to_remove .= "\n\t\t<option>$ag</option>";
		}
			
		?>
		<table class="concordtable" width="100%">
			<tr>
				<th class="concordtable" colspan="2">Corpus access control panel</th>
			</tr>
			<tr>
				<td class="concordgrey" align="center" colspan="2">
					&nbsp;<br/>
					The following user groups have access to this corpus:
					<br/>&nbsp;
				</td>
			</tr>
			<tr>
				<th class="concordtable" width="50%">Group</th>
				<th class="concordtable">Members</th>
			</tr>
			
			<?php
			foreach ($allowed_groups as &$group)
			{
				echo "\n<tr>\n<td class=\"concordgeneral\" align=\"center\"><strong>$group</strong></td>\n";
				$member_list = $access->list_users_in_group($group);
				sort($member_list);
				echo "\n<td class=\"concordgeneral\">";
				$i = 0;
				foreach ($member_list as &$member)
				{
					echo $member . ' ';
					$i++;
					if ($i == 5)
					{
						echo "<br/>\n";
						$i = 0;
					}
				}
				echo '</td>';
			}
			?>
			
			<tr>
				<th class="concordtable">Add group</th>
				<th class="concordtable">Remove group</th>
			</tr>
			<tr>
				<td class="concordgeneral" align="center">
					<form action="../adm/index.php" method="get">
						<br/>
						<select name="groupToAdd">
							<?php echo $options_groups_to_add ?>
						</select>
						&nbsp;
						<input type="submit" value="Go!" />
						<br/>
						<input type="hidden" name="corpus" value="<?php echo $corpus_sql_name ?>"/>
						<input type="hidden" name="admFunction" value="accessAddGroup"/>
						<input type="hidden" name="uT" value="y"/>
					</form>
				</td>
				<td class="concordgeneral" align="center">
					<form action="../adm/index.php" method="get">
						<br/>
						<select name="groupToRemove">
							<?php echo $options_groups_to_remove ?>
						</select>
						&nbsp;
						<input type="submit" value="Go!" />
						<br/>
						<input type="hidden" name="corpus" value="<?php echo $corpus_sql_name ?>"/>
						<input type="hidden" name="admFunction" value="accessRemoveGroup"/>
						<input type="hidden" name="uT" value="y"/>
					</form>
				</td>
			</tr>
			<tr>
				<td class="concordgrey" align="center" colspan="2">
					&nbsp;<br/>
					You can manage group membership via the 
					<a href="../adm/index.php?thisF=groupAdmin&uT=y">Sysadmin Control Panel</a>.
					<br/>&nbsp;
				</th>
			</tr>
		</table>
		
		<?php
	} /* endif $cqpweb_uses_apache */
	else
	{
		?>
		<table class="concordtable" width="100%">
			<tr>
				<th class="concordtable">Corpus access control panel</th>
			</tr>
			<tr>
				<td class="concordgrey" align="center">
					&nbsp;<br/>
					CQPweb internal corpus access management is not available 
					(requires Apache web server).
					<br/>&nbsp;
				</td>
			</tr>
		</table>
		<?php
	}
}



function printquery_managemeta()
{	
	global $cqpweb_uploaddir;
	global $corpus_sql_name;
	
	
	?>
	<table class="concordtable" width="100%">
	
		<tr>
			<th class="concordtable">Admin tools for managing corpus metadata</th>
		</tr>
	
	<?php
	
	if (! text_metadata_table_exists())
	{
		/* we need to create a text metadata table for this corpus */
	
		?>

		<table class="concordtable" width="100%">
		
		
			<!-- minimalist metadata -->
		
			<tr>
				<form action="execute.php" method="get">
					<td class="concordgeneral" align="center">
						&nbsp;<br/>
						
						You Should create Metadata table to use this corpus.
						
						<br/>
						&nbsp;<br/>
						
						<input type="submit" value="Create minimalist metadata table"/>
						
						<br/>&nbsp;
					</td>
					<input type="hidden" name="function" value="create_text_metadata_for_minimalist"/>
					<input type="hidden" name="locationAfter" value="index.php?thisQ=manageMetadata&uT=y" />
					<input type="hidden" name="uT" value="y"/>
				</form>				
			</tr>
		</table>

		<?php
		/* endif text metadata table does not already exist */
	}
	else
	{
		/* table exists, so allow other actions */
		
		global $corpus_title;
		?>
		</table>

		<table class="concordtable" width="100%">
			<tr>
				<th colspan="2" class="concordtable">Reset the metadata table for this corpus</th>
			</tr>
			<tr>
				<td colspan="2" class="concordgrey" align="center">
					Are you sure you want to do this?
				</td>
			</tr>
			<form action="../adm/index.php" method="get">
				<tr>
					<td class="concordgeneral" align="center">
						<input type="checkbox" name="clearMetadataAreYouReallySure" value="yesYesYes"/>
						Yes, I'm really sure and I know I can't undo it.
					</td>
					<td class="concordgeneral" align="center">
						<input type="submit" value="Delete metadata table for this corpus" />
					</td>
					<input type="hidden" name="admFunction" value="clearMetadataTable" />
					<input type="hidden" name="corpus" value="<?php echo $corpus_sql_name; ?>" />
					<input type="hidden" name="uT" value="y" />
				</tr>
			</form>
		</table>



		<!-- ****************************************************************************** -->



		<table class="concordtable" width="100%">
			<tr>
				<th class="concordtable" colspan="2">Other metadata controls</th>
			</tr>

			<?php
			
			list($n) = mysql_fetch_row(
							do_mysql_query("select count(*) from text_metadata_for_$corpus_sql_name where words > 0")
						);
			if ($n > 0)
			{
				$message = 'The text metadata table <strong>has already been populated</strong> 
									with begin/end offset positions. Use the button below to refresh 
									this data.';
				$button_label = 'Update CWB text-position records';
			}
			else
			{
				$message = 'The text metadata table <strong>has not yet been populated</strong> 
									with begin/end offset positions. Use the button below to generate 
									this data.';
				$button_label = 'Generate CWB text-position records';
			}
		
			?>
			<tr>
				<td class="concordgrey" width="20%" valign="center">Text begin/end positions</td>
				<td class="concordgeneral" align="center">
					&nbsp;<br/>
					<?php echo $message; ?>
					<br/>&nbsp;
					<form action="execute.php" method="get">
						<input type="submit" value="<?php echo $button_label; ?>"/>
						<br/>
						<input type="hidden" name="function" value="populate_corpus_cqp_positions" />
						<input type="hidden" name="locationAfter" value="index.php?thisQ=manageMetadata&uT=y" />
						<input type="hidden" name="uT" value="y" />
					</form>
				</td>
			</tr>
			

			<?php
			
			$n = mysql_num_rows(
					do_mysql_query("select handle from text_metadata_fields 
						where corpus = '$corpus_sql_name' and is_classification = 1")
					);
			
			?>
			
			
			
			<?php
			
			global $cwb_registry;
			global $corpus_cqp_name;
			$corpus_cqp_name_lower = strtolower($corpus_cqp_name);
			
			if (file_exists("/$cwb_registry/{$corpus_cqp_name_lower}__freq"))
			{
				$message = 'The text-by-text list for this corpus <strong>has already been created</strong>. Use
								the button below to delete and recreate it.';
				$button_label = 'Recreate CWB frequency table';
			}
			else
			{
				$message = 'The text-by-text list for this corpus <strong>has not yet been created</strong>. Use
								the button below to generate it.';
				$button_label = 'Create CWB frequency table';
			}
			
			?>
			<tr>
				<td class="concordgrey" width="20%" valign="center">Text-by-text freq-lists</td>
				<td class="concordgeneral" align="center">
					&nbsp;<br/>
					CWB text-by-text frequency lists are used to generate subcorpus frequency lists
					(important for keywords, collocations etc.)
					<br/>&nbsp;<br/>
					<?php echo $message; ?>
					<br/>&nbsp;
					<form action="execute.php" method="get">
						<input type="submit" value="<?php echo $button_label; ?>"/>
						<br/>
						<input type="hidden" name="function" value="make_cwb_freq_index" />
						<input type="hidden" name="locationAfter" value="index.php?thisQ=manageMetadata&uT=y" />
						<input type="hidden" name="uT" value="y" />
					</form>
				</td>
			</tr>

			<?php
			
			if (mysql_num_rows(do_mysql_query("show tables like 'freq_corpus_{$corpus_sql_name}_word'")) > 0)
			{
				$message = 'Word and annotation frequency tables for this corpus <strong>have already been created</strong>. 
								Use the button below to delete and recreate them.';
				$button_label = 'Recreate frequency tables';
			}
			else
			{
				$message = 'Word and annotation frequency tables for this corpus <strong>have not yet been created</strong>. 
								Use the button below to generate them.';
				$button_label = 'Create frequency tables';
			}
			?>			
			
			

			<tr>
				<td class="concordgrey" width="20%" valign="center">Frequency tables</td>
				<td class="concordgeneral" align="center">
					&nbsp;<br/>
					<?php echo $message; ?>
					<br/>&nbsp;<br/>
					<form action="execute.php" method="get">
						<input type="submit" value="<?php echo $button_label; ?>"/>
						<br/>
						<input type="hidden" name="function" value="corpus_make_freqtables" />
						<input type="hidden" name="locationAfter" value="index.php?thisQ=manageMetadata&uT=y" />
						<input type="hidden" name="uT" value="y" />
					</form>
				</td>
			</tr>

		</table>
		<?php
	}
}


function printquery_managecategories()
{
	global $corpus_sql_name;
	
	$classification_list = metadata_list_classifications();

	?>
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable">Insert or update text category descriptions</th>
		</tr>
		<?php

		if (empty($classification_list))
			echo '<tr><td class="concordgrey" align="center">&nbsp;<br/>
				No text classification schemes exist for this corpus.
				<br/>&nbsp;</td></tr>';

		foreach ($classification_list as $scheme)
		{
			?>
			<tr>
				<td class="concordgrey" align="center">
					Categories in classification scheme <em><?php echo $scheme['handle'];?><em>
				</td>
			</tr>
			<tr>
				<td class="concordgeneral" align="center">
					<form action="../adm/index.php" method="get">
						<table>
							<tr>
								<td class="basicbox" align="center"><strong>Scheme = Category</strong></td>
								<td class="basicbox" align="center"><strong>Category description</strong></td>
							</tr>
							<?php
							
							$category_list = metadata_category_listdescs($scheme['handle']);
				
							foreach ($category_list as $handle => $description)
							{
								echo '<tr><td class="basicbox">' . "{$scheme['handle']} = $handle" . '</td>';
								echo '<td class="basicbox">
									<input type="text" name="' . "desc-{$scheme['handle']}-$handle"
									. '" value="' . $description . '"/>
									</td>
								</tr>';
							}
							
							?>
							<tr>
								<td class="basicbox" align="center" colspan="2">
									<input type="submit" value="Update category descriptions" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="corpus" value="<?php echo $corpus_sql_name; ?>" />
						<input type="hidden" name="admFunction" value="updateCategoryDescriptions" />
						<input type="hidden" name="uT" value="y" />
					</form>
				</td>
			</tr>
			<?php
		}
	echo '</table>';
}


function printquery_manageannotation()
{
	global $corpus_sql_name;
	
	if (isset($_GET['updateMe']))
	{
		if ( $_GET['updateMe'] == 'CEQL')
		{
			/* we have incoming values from the CEQL table to update */
			$new_primary = mysql_real_escape_string($_GET['setPrimaryAnnotation']);
			$new_primary = ($new_primary == '__UNSET__' ? 'NULL' : "'$new_primary'");
			$new_secondary = mysql_real_escape_string($_GET['setSecondaryAnnotation']);
			$new_secondary = ($new_secondary == '__UNSET__' ? 'NULL' : "'$new_secondary'");
			$new_tertiary = mysql_real_escape_string($_GET['setTertiaryAnnotation']);
			$new_tertiary = ($new_tertiary == '__UNSET__' ? 'NULL' : "'$new_tertiary'");
			$new_combo = mysql_real_escape_string($_GET['setComboAnnotation']);
			$new_combo = ($new_combo == '__UNSET__' ? 'NULL' : "'$new_combo'");
			$new_maptable = mysql_real_escape_string($_GET['setMaptable']);
			$new_maptable = ($new_maptable == '__UNSET__' ? 'NULL' : "'$new_maptable'");
			
			$sql_query = "update corpus_metadata_fixed set
				primary_annotation = $new_primary,
				secondary_annotation = $new_secondary,
				tertiary_annotation = $new_tertiary,
				combo_annotation = $new_combo,
				tertiary_annotation_tablehandle = $new_maptable
				where corpus = '$corpus_sql_name'";
			$result = do_mysql_query($sql_query);
		}
		else if ($_GET['updateMe'] == 'annotation_metadata')
		{
			/* we have incoming annotation metadata to update */
			if (! check_is_real_corpus_annotation($handle_to_change=mysql_real_escape_string($_GET['annotationHandle'])))
				exiterror_general("Couldn't update $handle_to_change - not a real annotation!",
					__FILE__, __LINE__);
			$new_desc = ( empty($_GET['annotationDescription']) ? 'NULL'
							: '\''.mysql_real_escape_string($_GET['annotationDescription']).'\'');
			$new_tagset = ( empty($_GET['annotationTagset']) ? 'NULL' 
							: '\''.mysql_real_escape_string($_GET['annotationTagset']).'\'');
			$new_url = ( empty($_GET['annotationURL']) ? 'NULL'
							: '\''.mysql_real_escape_string($_GET['annotationURL']).'\'');
	
			$sql_query = "update annotation_metadata set
				description = $new_desc,
				tagset = $new_tagset,
				external_url = $new_url
				where corpus = '$corpus_sql_name' and handle = '$handle_to_change'";
			$result = do_mysql_query($sql_query);
		}
	}


	$sql_query = "select * from corpus_metadata_fixed where corpus='$corpus_sql_name'";
	$result = do_mysql_query($sql_query);
	$data = mysql_fetch_object($result);
	
	$annotation_list = get_corpus_annotations();

	/* set variables */
	
	$select_for_primary = '<select name="setPrimaryAnnotation">';
	$selector = ($data->primary_annotation === NULL ? 'selected="selected"' : '');
	$select_for_primary .= '<option value="__UNSET__"' . $selector . '>Not in use in this corpus</option>';
	foreach ($annotation_list as $handle=>$desc)
	{
		$selector = ($data->primary_annotation === $handle ? 'selected="selected"' : '');
		$select_for_primary .= "<option value=\"$handle\" $selector>$desc</option>";
	}
	$select_for_primary .= "\n</select>";

	$select_for_secondary = '<select name="setSecondaryAnnotation">';
	$selector = ($data->secondary_annotation === NULL ? 'selected="selected"' : '');
	$select_for_secondary .= '<option value="__UNSET__"' . $selector . '>Not in use in this corpus</option>';
	foreach ($annotation_list as $handle=>$desc)
	{
		$selector = ($data->secondary_annotation === $handle ? 'selected="selected"' : '');
		$select_for_secondary .= "<option value=\"$handle\" $selector>$desc</option>";
	}
	$select_for_secondary .= "\n</select>";

	$select_for_tertiary = '<select name="setTertiaryAnnotation">';
	$selector = ($data->tertiary_annotation === NULL ? 'selected="selected"' : '');
	$select_for_tertiary .= '<option value="__UNSET__"' . $selector . '>Not in use in this corpus</option>';
	foreach ($annotation_list as $handle=>$desc)
	{
		$selector = ($data->tertiary_annotation === $handle ? 'selected="selected"' : '');
		$select_for_tertiary .= "<option value=\"$handle\" $selector>$desc</option>";
	}
	$select_for_tertiary .= "\n</select>";

	$select_for_combo = '<select name="setComboAnnotation">';
	$selector = ($data->combo_annotation === NULL ? 'selected="selected"' : '');
	$select_for_combo .= '<option value="__UNSET__"' . $selector . '>Not in use in this corpus</option>';
	foreach ($annotation_list as $handle=>$desc)
	{
		$selector = ($data->combo_annotation === $handle ? 'selected="selected"' : '');
		$select_for_combo .= "<option value=\"$handle\" $selector>$desc</option>";
	}
	$select_for_combo .= "\n</select>";


	/* and the mapping table */
	
	$mapping_table_list = get_list_of_tertiary_mapping_tables();
	$select_for_maptable = '<select name="setMaptable">';
	$selector = ($data->tertiary_annotation_tablehandle === NULL ? 'selected="selected"' : '');
	$select_for_maptable .= '<option value="__UNSET__"' . $selector . '>Not in use in this corpus</option>';
	foreach ($mapping_table_list as $handle=>$desc)
	{
		$selector = ($data->tertiary_annotation_tablehandle === $handle ? 'selected="selected"' : '');
		$select_for_maptable .= "<option value=\"$handle\" $selector>$desc</option>";
	}
	$select_for_maptable .= "\n</select>";


	?>
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable">
				Manage annotation
			</th>
		</tr>
	</table>
	<table class="concordtable" width="100%">
		<tr>
			<th colspan="2" class="concordtable">
				Annotation setup for CEQL queries for <?php echo $corpus_sql_name;?>
			</th>
		</tr>
		<form action="index.php" method="get">
			<tr>
				<td class="concordgrey">
					<b>Primary annotation</b>
					- used for tags given after the underscore character (typically POS)
				</td>
				<td class="concordgeneral">
					<?php echo $select_for_primary;?>
				</td>
			<tr>
				<td class="concordgrey">
					<b>Secondary annotation</b>
					- used for searches like <em>{...}</em> (typically lemma)	
				</td>
				<td class="concordgeneral">
					<?php echo $select_for_secondary;?>
				</td>
			<tr>
				<td class="concordgrey">
					<b>Tertiary annotation</b>
					- used for searches like <em>_{...}</em> (typically simplified POS tag)	
				</td>
				<td class="concordgeneral">
					<?php echo $select_for_tertiary;?>
				</td>
			<tr>
				<td class="concordgrey">
					<b>Tertiary annotation mapping table</b>
					- handle for the list of aliases used in the tertiary annotation
				</td>
				<td class="concordgeneral">
					<?php echo $select_for_maptable;?>
				</td>
			<tr>
				<td class="concordgrey">
					<b>Combination annotation</b>
					- typically lemma_simpletag, used for searches in the form <em>{.../...}</em>
				</td>
				<td class="concordgeneral">
					<?php echo $select_for_combo;?>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="concordgeneral" align="center">
					&nbsp;<br/>
					<input type="submit" value="Update annotation settings"/>
					<br/>&nbsp;
				</td>
			<input type="hidden" name="updateMe" value="CEQL"/>
			<input type="hidden" name="thisQ" value="manageAnnotation"/>
			<input type="hidden" name="uT" value="y"/>
		</form>
	</table>

	<table class="concordtable" width="100%">
		<tr>
			<th colspan="5" class="concordtable">
				Annotation metadata
			</th>
		</tr>
		<tr>
			<th class="concordtable">Handle</th>
			<th class="concordtable">Description</th>
			<th class="concordtable">Tagset name</th>
			<th class="concordtable">External URL</th>
			<th class="concordtable">Update?</th>
		</tr>
		
		<?php
		
		$result = do_mysql_query("select * from annotation_metadata where corpus='$corpus_sql_name'");
		if (mysql_num_rows($result) < 1)
			echo '<tr><td colspan="5" class="concordgrey" align="center">&nbsp;<br/>
				This corpus has no annotation.<br/>&nbsp;</td></tr>';
		
		while( ($tag = mysql_fetch_object($result)) !== false)
		{
			echo '<form action="index.php" method= "get"><tr>';
			
			echo '<td class="concordgrey"><strong>' . $tag->handle . '</strong></td>'; 
			echo '<td class="concordgeneral" align="center">
				<input name="annotationDescription" maxlength="230" type="text" value="'
				. $tag->description	. '"/></td>
				'; 
			echo '<td class="concordgeneral" align="center">
				<input name="annotationTagset" maxlength="230" type="text" value="'
				. $tag->tagset	. '"/></td>
				'; 
			echo '<td class="concordgeneral" align="center">
				<input name="annotationURL" maxlength="230" type="text" value="'
				. $tag->external_url	. '"/></td>
				';
			?>
					<td class="concordgeneral" align="center">
						<input type="submit" value="Go!" />			
					</td>
				</tr>
				<input type="hidden" name="annotationHandle" value="<?php echo $tag->handle; ?>" />
				<input type="hidden" name="updateMe" value="annotation_metadata" />
				<input type="hidden" name="thisQ" value="manageAnnotation" />
				<input type="hidden" name="uT" value="y" />
			</form>
			
			<?php
		}
	
		?>
		<tr>
			<td colspan="5" class="concordgeneral">&nbsp;<br/>&nbsp;</td>
		</tr> 
	</table>
	
	
	<?php

}




function printquery_visualisation()
{
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="2" class="concordtable">
				Query result and context-view visualisation
			</th>
		</tr>
	</table>
	<?php

	/* FIRST SECTION --- GLOSS VISUALIASATION */
	/* process incoming */
	
	global $visualise_gloss_in_concordance;
	global $visualise_gloss_in_context;
	global $visualise_gloss_annotation;
	$annotations = get_corpus_annotations();
	
	if (isset($_GET['settingsUpdateGlossAnnotation']))
	{
		switch($_GET['settingsUpdateGlossShowWhere'])
		{
		case 'both':
			$visualise_gloss_in_context = true;
			$visualise_gloss_in_concordance = true;
			break;
		case 'concord':
			$visualise_gloss_in_context = false;
			$visualise_gloss_in_concordance = true;
			break;
		case 'context':
			$visualise_gloss_in_context = true;
			$visualise_gloss_in_concordance = false;
			break;
		default:
			$visualise_gloss_in_context = false;
			$visualise_gloss_in_concordance = false;
			break;			
		}
		if ($_GET['settingsUpdateGlossAnnotation'] == '~~none~~')
			$_GET['settingsUpdateGlossAnnotation'] = NULL;
		if (array_key_exists($_GET['settingsUpdateGlossAnnotation'], $annotations) 
				|| $_GET['settingsUpdateGlossAnnotation'] == NULL)
		{
			$visualise_gloss_annotation = $_GET['settingsUpdateGlossAnnotation'];
			update_corpus_visualisation_gloss($visualise_gloss_in_concordance, $visualise_gloss_in_context, 
												$visualise_gloss_annotation);
		}
		else
			exiterror_parameter("A non-existent annotation was specified to be used for glossing.");
	}
	
	/* set up option strings for first form  */
	
	$opts = array(	'neither'=>'Don\'t show anywhere', 
					'concord'=>'Concordance only', 
					'context'=>'Context only', 
					'both'=>'Both concordance and context'
					);
	if ($visualise_gloss_in_concordance)
		if ($visualise_gloss_in_context)
			$show_gloss_curr_opt = 'both';
		else
			$show_gloss_curr_opt = 'concord';
	else
		if ($visualise_gloss_in_context)
			$show_gloss_curr_opt = 'context';
		else
			$show_gloss_curr_opt = 'neither';
	
	$show_gloss_options = '';
	foreach ($opts as $o => $d)
		$show_gloss_options .= "\t\t\t\t\t\t<option value=\"$o\""
							. ($o == $show_gloss_curr_opt ? ' selected="selected"' : '')
							. ">$d</option>\n";

	$gloss_annotaton_options = "\t\t\t\t\t\t<option value=\"~~none~~\""
								. (isset($visualise_gloss_annotation) ? '' : ' selected="selected"')
								. ">No annotation selected</option>";		
	foreach($annotations as $h => $d)
		$gloss_annotaton_options .= "\t\t\t\t\t\t<option value=\"$h\""
							. ($h == $visualise_gloss_annotation ? ' selected="selected"' : '')
							. ">$d</option>\n";
		
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="2" class="concordtable">
				(1) Interlinear gloss
			</th>
		</tr>
		<tr>
			<td  colspan="2" class="concordgrey">
				&nbsp;<br/>
				You can select an annotation to be treated as the "gloss" and displayed in
				query results and/or extended context display.
				<br/>&nbsp;
			</td>
		</tr>
		<form id="formSetGlossOptions" action="index.php" method="get">
			<tr>
				<td class="concordgrey">Use annotation:</td>
				<td class="concordgeneral">
					<select name="settingsUpdateGlossAnnotation">
						<?php echo $gloss_annotaton_options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<!-- at some point, it might be nice to allow users to set this for themselves. -->
				<td class="concordgrey">Show gloss in:</td>
				<td class="concordgeneral">
					<select name="settingsUpdateGlossShowWhere">
						<?php echo $show_gloss_options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="concordgeneral">
					<input type="submit" value="Update settings" />
					<input type="hidden" name="thisQ" value="manageVisualisation" />
					<input type="hidden" name="uT" value="y" />
				</td>
			</tr>
		</form>
	</table>
	
	<?php
	/* SECOND SECTION --- TRANSLATION VISUALIASATION */
	/* process incoming */
	
	global $visualise_translate_in_concordance;
	global $visualise_translate_in_context;
	global $visualise_translate_s_att;
	$s_attributes = get_xml_annotations();
	
	if (isset($_GET['settingsUpdateTranslateXML']))
	{	
		switch($_GET['settingsUpdateTranslateShowWhere'])
		{
		case 'both':
			$visualise_translate_in_context = true;
			$visualise_translate_in_concordance = true;
			break;
		case 'concord':
			$visualise_translate_in_context = false;
			$visualise_translate_in_concordance = true;
			break;
		case 'context':
			$visualise_translate_in_context = true;
			$visualise_translate_in_concordance = false;
			break;
		default:
			$visualise_translate_in_context = false;
			$visualise_translate_in_concordance = false;
			break;			
		}
		if ($_GET['settingsUpdateTranslateXML'] == '~~none~~')
			$_GET['settingsUpdateTranslateXML'] = NULL;
		if (in_array($_GET['settingsUpdateTranslateXML'], $s_attributes) 
				|| $_GET['settingsUpdateTranslateXML'] == NULL)
		{
			$visualise_translate_s_att = $_GET['settingsUpdateTranslateXML'];
			update_corpus_visualisation_translate($visualise_translate_in_concordance, $visualise_translate_in_context, 
												  $visualise_translate_s_att);
		}
		else
			exiterror_parameter("A non-existent s-attribute was specified to be used for translation.");
	}
	
	/* set up option string for second form */

	/* note that $opts array already exists */
	if ($visualise_translate_in_concordance)
		if ($visualise_translate_in_context)
			$show_translate_curr_opt = 'both';
		else
			$show_translate_curr_opt = 'concord';
	else
		if ($visualise_translate_in_context)
			$show_translate_curr_opt = 'context';
		else
			$show_translate_curr_opt = 'neither';
	
	$show_translate_options = '';
	foreach ($opts as $o => $d)
		$show_translate_options .= "\t\t\t\t\t\t<option value=\"$o\""
							. ($o == $show_translate_curr_opt ? ' selected="selected"' : '')
							. ">$d</option>\n";
	$translate_XML_options = "\t\t\t\t\t\t<option value=\"~~none~~\""
								. (isset($visualise_translate_s_att) ? '' : ' selected="selected"')
								. ">No XML element-attribute selected</option>";		
	foreach($s_attributes as $s)
		$translate_XML_options .= "\t\t\t\t\t\t<option value=\"$s\""
							. ($s == $visualise_translate_s_att ? ' selected="selected"' : '')
							. ">$s</option>\n";
	
	?>

	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="2" class="concordtable">
				(2) Free translation
			</th>
		</tr>
		<tr>
			<td  colspan="2" class="concordgrey">
				&nbsp;<br/>
				You can select an XML element/attribute to be used to provide whole-sentence or
				whole-utterance translation.
				<br/>&nbsp;<br/>
				Note that if this setting is enabled, it <b>overrides</b> the context setting.
				The context is automatically set to "one of whatever XML attribute you are using".
				<br/>&nbsp;
			</td>
		</tr>
		<form id="formSetTranslateOptions" action="index.php" method="get">
			<tr>
				<td class="concordgrey">Select XML element/attribute to get the translation from:</td>
				<td class="concordgeneral">
					<select name="settingsUpdateTranslateXML">
						<?php echo $translate_XML_options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<!-- at some point, it might be nice to allow users to set this for themselves. -->
				<td class="concordgrey">Show free translation in:</td>
				<td class="concordgeneral">
					<select name="settingsUpdateTranslateShowWhere">
						<?php echo $show_translate_options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="concordgeneral">
					<input type="submit" value="Update settings" />
					<input type="hidden" name="thisQ" value="manageVisualisation" />
					<input type="hidden" name="uT" value="y" />
				</td>
			</tr>
		</form>
	</table>

	<?php

	/* THIRD SECTION --- POSITION LABELS */
	/* process incoming */
	
	/* these don't really need to be improted from global namespace, but let's be consistent */
	global $visualise_position_labels;
	global $visualise_position_label_attribute;
	/* and we can re-use $s_attributes from above */

	if (isset($_GET['settingsUpdatePositionLabelAttribute']))
	{
		$visualise_position_labels = true;
		$visualise_position_label_attribute = $_GET['settingsUpdatePositionLabelAttribute'];
		
		if ($visualise_position_label_attribute == '~~none~~')
		{
			$visualise_position_labels = false;
			$visualise_position_label_attribute = NULL;
		}
		else if ( ! in_array($visualise_position_label_attribute, $s_attributes) )
		{
			exiterror_parameter("A non-existent s-attribute was specified for position labels.");
		}
		/* so we know at this point that $visualise_position_label_attribute contains an OK s-att */ 
		update_corpus_visualisation_position_labels($visualise_position_labels, $visualise_position_label_attribute);
	}
	
	$position_label_options = "\t\t\t\t\t\t<option value=\"~~none~~\""
								. ($visualise_position_labels ? '' : ' selected="selected"')
								. ">No position labels will be shown in the concordance</option>";		
	foreach($s_attributes as $s)
		$position_label_options .= "\t\t\t\t\t\t<option value=\"$s\""
							. ($s == $visualise_position_label_attribute ? ' selected="selected"' : '')
							. ">$s will used for position labels</option>\n";

	?>
	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="2" class="concordtable">
				(4) Position labels
			</th>
		</tr>
		<tr>
			<td  colspan="2" class="concordgrey">
				&nbsp;<br/>
				You can select an XML element/attribute to be used to indicate the position <em>within</em> its text
				where each concordance result appears. A typical choice for this would be sentence or utterance number.
				<br/>&nbsp;<br/>
				<strong>Warning</strong>: If you select an element/attribute pair that does not cover the entire corpus, no
				position label will be shown next to a result at a corpus position with no value for the selected attribute!
				<br/>&nbsp;
			</td>
		</tr>
		<form id="formSetPositionLabelAttribute" action="index.php" method="get">
			<tr>
				<td class="concordgrey">Select XML element/attribute to use for position labels:</td>
				<td class="concordgeneral">
					<select name="settingsUpdatePositionLabelAttribute">
						<?php echo $position_label_options; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="concordgeneral">
					<input type="submit" value="Update setting" />
					<input type="hidden" name="thisQ" value="manageVisualisation" />
					<input type="hidden" name="uT" value="y" />
				</td>
			</tr>
		</form>
	</table>
	

	<!-- 
	
	
	
	TODO from here on down.....
	
	
	note, way down the road, it would be nice if auto-transliteration
	could affect database-derived tables as well
	- and, of course, be configurable on a per-user basis.
	
	
	
	-->
	
	<?php
	
	// for now, don't display
	return;
	
	/* FOURTH SECTION --- TRANSLITERATION VISUALIASATION */
	/* process incoming */

	
	
	?>

	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="2" class="concordtable">
				(3) Transliteration    [NOT WORKING YET!!]
			</th>
		</tr>
		<tr>
			<td  colspan="2" class="concordgrey">
				&nbsp;<br/>
				You can have the "word" attribute automatically transliterated into the Latin
				alphabet, as long as you have added an appropriate transliterator plugin to CQPweb
				(or are happy to use the default).
				<br/>&nbsp;
			</td>
		</tr>
		<form action="" method="get">
			<tr>
				<td class="concordgrey">Select transliterator:</td>
				<td class="concordgeneral">
					
				</td>
			</tr>
			<tr>
				<!-- at some point, it might be nice to allow users to set this for themselves. -->
				<td class="concordgrey">Autotransliterate in:</td>
				<td class="concordgeneral">
					<select>
						<option>Concordance only</option>
						<option>Context only</option>
						<option>Both concordance and context</option>
					</select>
				</td>
			</tr>
			<tr>
				<!-- at some point, it might be nice to allow users to set this for themselves. -->
				<td class="concordgrey">Show:</td>
				<td class="concordgeneral">
					<select>
						<option>Original script only</option>
						<option>Autotransliterated text only</option>
						<option>Original and autotransliterated text</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="concordgeneral">
					<input type="submit" value="Update settings" />
					<input type="hidden" name="uT" value="y" />
				</td>
			</tr>
		</form>
	</table>

	<?php

}





function printquery_xmlvisualisation()
{
	global $corpus_sql_name;
	
	/* PROCESS INCOMING */
	
	/* process incoming NEW or UPDATE */
	if (isset($_GET['xmlTheElement']))
	{
		/* change the update form's "select" to the two-value pair of variables used in the create form... */
		if (isset($_GET['xmlUseInSelector']))
		{
			$_GET['xmlUseInConc']    = ( $_GET['xmlUseInSelector'] == 'in_conc'    || $_GET['xmlUseInSelector'] == 'both' );
			$_GET['xmlUseInContext'] = ( $_GET['xmlUseInSelector'] == 'in_context' || $_GET['xmlUseInSelector'] == 'both' );
		}
		xml_visualisation_create(	$corpus_sql_name, 
									$_GET['xmlTheElement'], 
									$_GET['xmlVisCode'],
									$_GET['xmlCondAttribute'],
									$_GET['xmlCondRegex'],
									(bool) $_GET['xmlIsStartTag'], 
									(bool) $_GET['xmlUseInConc'], 
									(bool) $_GET['xmlUseInContext'] );
	}
	/* process incoming DELETE */
	if (isset($_GET['xmlDeleteVisualisation']))
		xml_visualisation_delete(	$corpus_sql_name, 
									$_GET['xmlDeleteVisualisation'],
									$_GET['xmlCondAttribute'],
									$_GET['xmlCondRegex'] );
	
	/* 
	 * OK, now the processing is done, let's render the form 
	 */
	
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th  colspan="6" class="concordtable">
				(5) XML visualisation
			</th>
		</tr>
		<tr>
			<td  colspan="6" class="concordgrey">
				&nbsp;<br/>
				XML visualisations are commands stored in the database which describe how an indexed
				XML element (or, in CWB terms, an &ldquo;s-attribute&rdquo;) is to appear in the concordance.
				<br/>&nbsp;<br/>
				By default, all XML elements are invisible. You must create and enable a visualisation for
				each XML element in each corpus that you wish to display to the user.  
				<br/>&nbsp;<br/>
				An XML visualisation can be unconditional, in which case it will always apply. Or, it can have
				a condition attached to it - a regular expresion that will be matched against an attribute on
				the XML tag, with the visualisation only displayed if the regular expression matches. This allows
				you to have different visualisations for &lt;element type="A"&gt; and &lt;element type="B"&gt;.
				<br/>&nbsp;<br/>
				You can define an unconditional visualisation for the same element as one or more conditional
				visualisations, in which case, the unconditional visualisation applies in any cases where none of the 
				conditional visualisations apply. In addition, note that conditions are only possible on start tags, 
				not end tags.
				<br/>&nbsp;<br/>
				You can use the forms below to manage your visualisations.
				<br/>&nbsp;
			</td>
		</tr>
		
		
		<!-- display current visualisations for this corpus -->
		<!-- note we use the SAME FORM for updates as for creates -->
		<tr>
			<th colspan="6" class="concordtable">
				Existing XML visualisation commands
			</th>
		</tr>
		<tr>
			<th class="concordtable">Applies to ... </th>
			<th class="concordtable">Visualisation code</th>
			<th class="concordtable">Show</th>
			<th class="concordtable">Used where?</th>
			<th class="concordtable" colspan="2">Actions</th>
		</tr>
		
		<?php
		
		/* show each existing visualisation for this corpus */
		
		$where_values = array(
			'in_conc' => "In concordance displays only",
			'in_context' => "In extended context displays only",
			'both' => "In concordance AND context displays",
			'neither' => "Nowhere (visualisation disabled)"
			);

		$result = do_mysql_query("select * from xml_visualisations where corpus = '$corpus_sql_name'"); 
		
		if (mysql_num_rows($result) == 0)
			echo '<tr><td colspan="6" class="concordgrey" align="center">'
				. '&nbsp;<br/>There are currently no XML visualisations in the database.<br/>&nbsp;'
				. '</td></tr>';
		
		while (false !== ($v = mysql_fetch_object($result)))
		{
			echo '
				<form action="index.php" method="get">
				<tr>
				';
			
			list($tag, $startend) = explode('~', $v->element);
			$startend = ($startend=='end' ? '/' : ''); 
			$cond_regex_print = htmlspecialchars($v->cond_regex, ENT_QUOTES, 'UTF-8', true);
			
			echo '
				<td class="concordgeneral">&lt;' . $startend . $tag . '&gt;'
				. (empty($v->cond_attribute) ? '' 
					: "<br/>where <em>{$v->cond_attribute}</em> matches <em>$cond_regex_print</em>\n")  
				. '</td>
				';
			
			echo '
				<td class="concordgeneral" align="center"><textarea cols="40" rows="2" name="xmlVisCode">' 
				. $v->bb_code 
				. '</textarea></td>
				';
			
			echo '<td class="concordgeneral" align="center">'
				. '<span onmouseover="return escape(\'' 
				  /* note we need double-encoding to get the actual code to show up in a tooltip ! */
				. htmlspecialchars(htmlspecialchars($v->html_code, ENT_QUOTES, 'UTF-8', true) , ENT_QUOTES, 'UTF-8', true) 
				.'\')">[HTML]</span>'
				. '</td>
				';
			
			switch (true)
			{
				case ( $v->in_context &&  $v->in_concordance):		$checked = 'both';			break; 
				case (!$v->in_context && !$v->in_concordance):		$checked = 'neither';		break; 
				case (!$v->in_context &&  $v->in_concordance):		$checked = 'in_conc';		break; 
				case ( $v->in_context && !$v->in_concordance):		$checked = 'in_context';	break; 
			}
			$options = "\n";
			foreach ($where_values as $val=>$label)
			{
				$blob = ($checked == $val ? ' selected="selected"' : '');
				$options .= "\n\t\t\t\t\t<option value=\"$val\"$blob>$label</option>\n";
			}
			
			echo '
				<td class="concordgeneral" align="center">
				<select name="xmlUseInSelector">'
				. $options
				. '
				</select>
				</td>
				';

			echo '
				<td class="concordgeneral" align="center">'
				. '<input type="submit" value="Update" />' 
				. '</td>';
						
			echo '
				<td class="concordgeneral" align="center">'
				. '<a class="menuItem" href="index.php?thisQ=manageVisualisation&xmlDeleteVisualisation='
				. $tag . ($startend=='/' ? '~end' : '~start')
				. '&xmlCondAttribute=' . $v->cond_attribute
				. '&xmlCondRegex=' . urlencode($v->cond_regex)
				. '&uT=y">[Delete]</a>'
				. '</td>
				';
						
			echo '
				</tr>
				<input type="hidden" name="xmlTheElement" value="' . $tag . '" />
				<input type="hidden" name="xmlIsStartTag" value="' . ($startend=='/' ? '0' : '1') . '" />
				<input type="hidden" name="xmlCondAttribute" value="' . $v->cond_attribute . '" />
				<input type="hidden" name="xmlCondRegex" value="' . $v->cond_regex . '" />
				<input type="hidden" name="thisQ" value="manageVisualisation" />
				<input type="hidden" name="uT" value="y" />
				</form>
				';

		}
		?>

	</table>
	<table class="concordtable" width="100%">		
		<!-- form to create new visualisation -->
		<form action="index.php" method="get">
			<tr>
				<th colspan="2" class="concordtable">
					Create new XML visualisation command
				</th>
			</tr>
			
			<tr>
				<td class="concordgrey">
					Select one of the available XML elements:
				</td>
				<td class="concordgeneral">
					<select name="xmlTheElement">
					
						<?php
						foreach (get_xml_all() as $x)
							echo "<option>$x</option>\n\t\t\t\t\t\t";
						?>
						
					</select>					
				</td>
			</tr>
			<tr>
				<td class="concordgrey">Create visualisation for start or end tag?</td>
				<td class="concordgeneral">
					<input type="radio" checked="checked" name="xmlIsStartTag" value="1" /> Start tag
					<input type="radio" name="xmlIsStartTag" value="0" /> End tag
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2" class="concordgrey">
					<em>Note: if you choose an element start/end for which a visualisation 
					already exists, the existing visualisation will be overwritten UNLESS 
					there are different conditions.</em>
				</td>
			</tr>
			<tr>
				<td class="concordgrey">
					Enter the code for the visualisation you want to create.
					<br/>&nbsp;<br/>
					See <a target="_blank" href="../doc/CQPweb-visualisation-manual.html">this file</a> for more
					information.
				</td>
				<td class="concordgeneral">
					<textarea cols="40" rows="12" name="xmlVisCode"></textarea>
				</td>
			</tr>		
			<tr>
				<td class="concordgrey">Use this visualisation in concordances?</td>
				<td class="concordgeneral">
					<input type="radio" checked="checked" name="xmlUseInConc" value="1" /> Yes
					<input type="radio" name="xmlUseInConc" value="0" /> No
				</td>
			</tr>
			<tr>
				<td class="concordgrey">Use this visualisation in extended context display?</td>
				<td class="concordgeneral">
					<input type="radio" checked="checked" name="xmlUseInContext" value="1" /> Yes
					<input type="radio" name="xmlUseInContext" value="0" /> No
				</td>
			</tr>
			<tr>
				<td class="concordgrey">
					Specify a condition?
					<br/>&nbsp;<br/>
					<em>(Leave blank for an unconditional visualisation.)</em></td>
				<td class="concordgeneral">
					The attribute 
					<input type="text" name="xmlCondAttribute" />
					must have a value which contains
					<br/> 
					a match for the regular expression
					<input type="text" name="xmlCondRegex" />
					.
				</td>
			</tr>
			<tr>
				<td class="concordgrey">Click here to store this visualisation</td>
				<td class="concordgeneral">
					<input type="submit" value="Create XML visualisation" />
				</td>
			</tr>
			
			<input type="hidden" name="thisQ" value="manageVisualisation" />
			<input type="hidden" name="uT" value="y" />
			
		</form>
	</table>
	
	
	<?php	
}





function printquery_showcache()
{
	global $corpus_sql_name;
	global $default_history_per_page;
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th colspan="2" class="concordtable">
				Showing CQPweb cache for corpus <?php echo $corpus_sql_name;?>
			</th>
		</tr>
		<tr>
			<th colspan="2" class="concordtable">
				<i>Admin controls over query cache and query-history log</i>
			</th>
		</tr>
		<tr>
	<?php
	
	$return_to_url = urlencode('index.php?' . url_printget());

	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=delete_cache_overflow&locationAfter='
		. $return_to_url
		. '&uT=y">Delete cache overflow</a></th>';

	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=history_purge_old_queries&locationAfter='
		. $return_to_url
		. '&uT=y">Discard old query history</a></th>';

	echo '</tr> <tr>';
			
	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=clear_cache&locationAfter='
		. $return_to_url
		. '&uT=y">Clear entire cache<br/>(but keep saved queries)</a></th>';
		
	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=clear_cache&args=0&locationAfter='
		. $return_to_url
		. '&uT=y">Clear entire cache<br/>(clear all saved queries)</a></th>';
		
	echo '</td></tr></table>';


	if (isset($_GET['beginAt']))
		$begin_at = $_GET['beginAt'];
	else
		$begin_at = 1;

	if (isset($_GET['pp']))
		$per_page = $_GET['pp'];
	else
		$per_page = $default_history_per_page;

	print_cache_table($begin_at, $per_page, '__ALL', true, true);
}



function printquery_showfreqtables()
{
	global $corpus_sql_name;
	global $default_history_per_page;
	global $mysql_freqtables_size_limit;
	
	$sql_query = "select sum(ft_size) from saved_freqtables";
	$result = do_mysql_query($sql_query);
	
	list($size) = mysql_fetch_row($result);
	if (!isset($size))
		$size = 0;
	$percent = round(((float)$size / (float)$mysql_freqtables_size_limit) * 100.0, 2);
	
	unset($result);
	
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th colspan="2" class="concordtable">
				Showing frequency table cache for corpus <em><?php echo $corpus_sql_name;?></em>
			</th>
		</tr>
		<tr>
			<td colspan="2" class="concordgeneral">
				&nbsp;<br/>
				The currently saved frequency tables for all corpora have a total size of 
				<?php echo make_thousands($size) . " bytes, $percent%"; ?>
				of the maximum cache.
				<br/>&nbsp;
			</td>
		</tr>
		<tr>
			<th colspan="2" class="concordtable">
				<i>Admin controls over cached frequency tables</i>
			</th>
		</tr>
		<tr>
	<?php
	
	$return_to_url = urlencode('index.php?' . url_printget());

	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=delete_saved_freqtables&locationAfter='
		. $return_to_url
		. '&uT=y">Delete frequency table cache overflow</a></th>';


	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=clear_freqtables&locationAfter='
		. $return_to_url
		. '&uT=y">Clear entire frequency table cache</a></th>';
	
	
	
	?>
		</tr>
	</table>
	
	
	
	
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable">No.</th>
			<th class="concordtable">FT name</th>
			<th class="concordtable">User</th>
			<th class="concordtable">Size</th>
			<th class="concordtable">Restrictions</th>
			<th class="concordtable">Subcorpus</th>
			<th class="concordtable">Created</th>
			<th class="concordtable">Public?</th>
			<th class="concordtable">Delete</th>
		</tr>


	<?php
	
	$sql_query = "SELECT freqtable_name, user, ft_size, restrictions, subcorpus, create_time,
		public
		FROM saved_freqtables WHERE corpus = '$corpus_sql_name' order by create_time desc";
		
	$result = do_mysql_query($sql_query);
	

	if (isset($_GET['beginAt']))
		$begin_at = $_GET['beginAt'];
	else
		$begin_at = 1;

	if (isset($_GET['pp']))
		$per_page = $_GET['pp'];
	else
		$per_page = $default_history_per_page;


	$toplimit = $begin_at + $per_page;
	$alt_toplimit = mysql_num_rows($result);
	
	if (($alt_toplimit + 1) < $toplimit)
		$toplimit = $alt_toplimit + 1;
	
	$name_trim_factor = strlen($corpus_sql_name) + 9;

	for ( $i = 1 ; $i < $toplimit ; $i++ )
	{
		$row = mysql_fetch_assoc($result);
		if (!$row)
			break;
		if ($i < $begin_at)
			continue;
		
		echo "<tr>\n<td class='concordgeneral'><center>$i</center></td>";
		echo "<td class='concordgeneral'><center>" . substr($row['freqtable_name'], $name_trim_factor) . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['user'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['ft_size'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" 
			. ($row['restrictions'] != 'no_restriction' ? $row['restrictions'] : '-')
			. '</center></td>';
		echo "<td class='concordgeneral'><center>" 
			. ($row['subcorpus'] != 'no_subcorpus' ? $row['subcorpus'] : '-')
			. '</center></td>';
		echo "<td class='concordgeneral'><center>" . date('Y-m-d H:i:s', $row['create_time']) 
			. '</center></td>';
		
		if ( $row['subcorpus'] != 'no_subcorpus' )
		{
			if ((bool)$row['public'])
			{
				echo '<td class="concordgeneral"><center><a class="menuItem" 
					onmouseover="return escape(\'This frequency list is public on the system!\')">Yes</a>
					<a class="menuItem" href="execute.php?function=unpublicise_freqtable&args='
					. $row['freqtable_name'] . "&locationAfter=$return_to_url&uT=y"
					. '" onmouseover="return escape(\'Make this frequency list unpublic\')">[&ndash;]</a>
					</center></td>';
			}
			else
			{
				echo '<td class="concordgeneral"><center><a class="menuItem" 
					onmouseover="return escape(\'This frequency list is not publicly accessible\')">No</a>	
					<a class="menuItem" href="execute.php?function=publicise_freqtable&args='
					. $row['freqtable_name'] . "&locationAfter=$return_to_url&uT=y"
					. '" onmouseover="return escape(\'Make this frequency list public\')">[+]</a>
					</center></td>';
			}
		}
		else
			/* only freqtables from subcorpora can be made public, not freqtables from restrictions*/
			echo '<td class="concordgeneral"><center>N/A</center></td>';

		echo '<td class="concordgeneral"><center><a class="menuItem" href="execute.php?function=delete_freqtable&args='
			. $row['freqtable_name'] . "&locationAfter=$return_to_url&uT=y"
			. '" onmouseover="return escape(\'Delete this frequency table\')">[x]</a></center></td>';
	}
	$navlinks = '<table class="concordtable" width="100%"><tr><td class="basicbox" align="left';

	if ($begin_at > 1)
	{
		$new_begin_at = $begin_at - $per_page;
		if ($new_begin_at < 1)
			$new_begin_at = 1;
		$navlinks .=  '"><a href="index.php?' . url_printget(array(array('beginAt', "$new_begin_at")));
	}
	$navlinks .= '">&lt;&lt; [Newer frequency tables]';
	if ($begin_at > 1)
		$navlinks .= '</a>';
	$navlinks .= '</td><td class="basicbox" align="right';
	
	if (mysql_num_rows($result) > $i)
		$navlinks .=  '"><a href="index.php?' . url_printget(array(array('beginAt', "$i + 1")));
	$navlinks .= '">[Older frequency tables] &gt;&gt;';
	if (mysql_num_rows($result) > $i)
		$navlinks .= '</a>';
	$navlinks .= '</td></tr></table>';
	
	echo $navlinks;



}




function printquery_showdbs()
{
	global $corpus_sql_name;
	global $default_history_per_page;
	global $mysql_db_size_limit;
	
	$sql_query = "select sum(db_size) from saved_dbs";
	$result = do_mysql_query($sql_query);
	
	list($size) = mysql_fetch_row($result);
	if (!isset($size))
		$size = 0;
	$percent = round(((float)$size / (float)$mysql_db_size_limit) * 100.0, 2);
	
	unset($result);
	
	?>
	<table class="concordtable" width="100%">
		<tr>
			<th colspan="2" class="concordtable">
				Showing database cache for corpus <em><?php echo $corpus_sql_name;?></em>
			</th>
		</tr>
		<tr>
			<td colspan="2" class="concordgeneral">
				&nbsp;<br/>
				The currently saved databases for all corpora have a total size of 
				<?php echo make_thousands($size) . " bytes, $percent%"; ?>
				of the maximum cache.
				<br/>&nbsp;
			</td>
		</tr>
		<tr>
			<th colspan="2" class="concordtable">
				<i>Admin controls over cached databases</i>
			</th>
		</tr>
		<tr>
	<?php
	
	$return_to_url = urlencode('index.php?' . url_printget());

	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=delete_saved_dbs&locationAfter='
		. $return_to_url
		. '&uT=y">Delete DB cache overflow</a></th>';


	echo '<th width="50%" class="concordtable">'
		. '<a onmouseover="return escape(\'This function affects <b>all</b> corpora in the CQPweb database\')"'
		. 'href="execute.php?function=clear_dbs&locationAfter='
		. $return_to_url
		. '&uT=y">Clear entire DB cache</a></th>';
	
	
	
	?>
		</tr>
	</table>
	
	
	
	
	<table class="concordtable" width="100%">
		<tr>
			<th class="concordtable">No.</th>
			<th class="concordtable">User</th>
			<th class="concordtable">DB name</th>
			<th class="concordtable">DB type</th>
			<th class="concordtable">DB size</th>
			<th class="concordtable">Matching query...</th>
			<th class="concordtable">Restrictions</th>
			<th class="concordtable">Subcorpus</th>
			<th class="concordtable">Created</th>
			<th class="concordtable">Delete</th>	
		</tr>


	<?php
	
	$sql_query = "SELECT user, dbname, db_type, db_size, cqp_query, restrictions, subcorpus, create_time 
		FROM saved_dbs WHERE corpus = '$corpus_sql_name' order by create_time desc";
		
	$result = do_mysql_query($sql_query);

	if (isset($_GET['beginAt']))
		$begin_at = $_GET['beginAt'];
	else
		$begin_at = 1;

	if (isset($_GET['pp']))
		$per_page = $_GET['pp'];
	else
		$per_page = $default_history_per_page;


	$toplimit = $begin_at + $per_page;
	$alt_toplimit = mysql_num_rows($result);
	
	if (($alt_toplimit + 1) < $toplimit)
		$toplimit = $alt_toplimit + 1;
	

	for ( $i = 1 ; $i < $toplimit ; $i++ )
	{
		$row = mysql_fetch_assoc($result);
		if (!$row)
			break;
		if ($i < $begin_at)
			continue;
		
		echo "<tr>\n<td class='concordgeneral'><center>$i</center></td>";
		echo "<td class='concordgeneral'><center>" . $row['user'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['dbname'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['db_type'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['db_size'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" . $row['cqp_query'] . '</center></td>';
		echo "<td class='concordgeneral'><center>" 
			. ($row['restrictions'] != 'no_restriction' ? $row['restrictions'] : '-')
			. '</center></td>';
		echo "<td class='concordgeneral'><center>" 
			. ($row['subcorpus'] != 'no_subcorpus' ? $row['subcorpus'] : '-')
			. '</center></td>';
		echo "<td class='concordgeneral'><center>" . date('Y-m-d H:i:s', $row['create_time']) 
			. '</center></td>';
			
		echo '<td class="concordgeneral"><center><a class="menuItem" href="execute.php?function=delete_db&args='
			. $row['dbname'] . "&locationAfter=$return_to_url&uT=y"
			. '" onmouseover="return escape(\'Delete this table\')">[x]</a></center></td>';
	}
	$navlinks = '<table class="concordtable" width="100%"><tr><td class="basicbox" align="left';

	if ($begin_at > 1)
	{
		$new_begin_at = $begin_at - $per_page;
		if ($new_begin_at < 1)
			$new_begin_at = 1;
		$navlinks .=  '"><a href="index.php?' . url_printget(array(array('beginAt', "$new_begin_at")));
	}
	$navlinks .= '">&lt;&lt; [Newer databases]';
	if ($begin_at > 1)
		$navlinks .= '</a>';
	$navlinks .= '</td><td class="basicbox" align="right';
	
	if (mysql_num_rows($result) > $i)
		$navlinks .=  '"><a href="index.php?' . url_printget(array(array('beginAt', "$i + 1")));
	$navlinks .= '">[Older databases] &gt;&gt;';
	if (mysql_num_rows($result) > $i)
		$navlinks .= '</a>';
	$navlinks .= '</td></tr></table>';
	
	echo $navlinks;


}




?>