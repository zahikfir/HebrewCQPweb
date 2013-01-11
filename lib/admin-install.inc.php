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

/**
 * @file
 * 
 * This file contains functions used in the installation of CQPweb
 * corpora (not including textmetadata installation!)
 * 
 * It should generally not be included into scripts unless the user
 * is a sysadmin.
 */




/**
 * Just a little object to hold info on the install corpus parsed from GET;
 * NOT an independent module in any way, shape or form, just a way to simplify
 * variable parsing.
 */
class corpus_install_info
{
	public $corpus_mysql_name;
	public $corpus_cwb_name;
	
	public $already_cwb_indexed;
	
	public $script_is_r2l;

	public $corpus_metadata_fixed_mysql_insert;
	
	public $css_url;
	public $description;
	
	public $p_attributes;
	public $p_attributes_mysql_insert;
	public $primary_p_attribute;
	public $s_attributes;
	public $file_list;
	
	
	/* constructor is sole public function */
	function __construct()
	{
		/* first thing: establish which mode we are dealing with */
		$this->already_cwb_indexed = ($_GET['admFunction'] === 'installCorpusIndexed'); 
		
		/* get each thing from GET */
		/* *********************** */
		
		/* mysql name */
		$this->corpus_mysql_name = $_GET['corpus_mysql_name'];
		if (! cqpweb_handle_check($this->corpus_mysql_name))
			exiterror_fullpage("That corpus name is invalid." 
				. "You must specify a corpus name using only letters, numbers and underscore");
		/* check for reserved words */
		global $cqpweb_reserved_subdirs;
		if (in_array($this->corpus_mysql_name, $cqpweb_reserved_subdirs))
			exiterror_fullpage("The following corpus names are not allowed: " . implode(' ', $cqpweb_reserved_subdirs));
		
		/* cwb name */
		$this->corpus_cwb_name = strtolower($_GET['corpus_cwb_name']);
		if (! cqpweb_handle_check($this->corpus_cwb_name))
			exiterror_fullpage("That corpus name is invalid." 
				. "You must specify a corpus name using only letters, numbers and underscore");		
		if (substr($this->corpus_cwb_name, -6) == '__freq')
			exiterror_fullpage('Error: Corpus CWB names cannot end in __freq!!');
		
		/* other basic parameters */
		$this->script_is_r2l = ( $_GET['corpus_scriptIsR2L'] === '1' );
		$this->encode_charset = ( $_GET['corpus_encodeIsLatin1'] === '1' ? 'latin1' : 'utf8' );
		$this->description = addcslashes($_GET['corpus_description'], "'");
		
		
		/* ***************** */
		
		if ($this->already_cwb_indexed)
		{
			global $cwb_registry;
			/* check that the corpus registry file exists, that the corpus datadir exists,
			 * in the process, getting the "override" directories, if they exist */
			
			$use_normal_regdir = (bool)$_GET['corpus_useDefaultRegistry'];
			$registry_file = "/$cwb_registry/{$this->corpus_cwb_name}";
			
			if ( ! $use_normal_regdir)
			{
				$orig_registry_file = 
					'/' 
					. trim(trim($_GET['corpus_cwb_registry_folder']), '/')
					. '/' 
					. $this->corpus_cwb_name;
				if (is_file($registry_file))
					exiterror_fullpage("A corpus by that name already exists in the CQPweb registry!");					
				if (!is_file($orig_registry_file))
					exiterror_fullpage("The specified CWB registry file does not seem to exist in that location.");
				
				/* we have established that the registry file does not exist and the original does
				 * so we can now import the registry file into CQPweb's registry */	
				copy($orig_registry_file, $registry_file);
			}
			else
			{
				if (!is_file($registry_file))
					exiterror_fullpage("The specified CWB corpus does not seem to exist in CQPweb's registry.");
			}
			
			$regdata = file_get_contents($registry_file);
			
			if (preg_match("/\bHOME\s+(\/[^\n\r]+)\s/", $regdata, $m) < 1)
			{
				unlink($registry_file);
				exiterror_fullpage("A data-directory path could not be found in the registry file for "
					. "the CWB corpus you specified.\n\nEither the data-directory is unspecified, or it is "
					. "specified with a relative path (an absolute path is needed).");
			}
			$test_datadir = $m[1];
			
			if (!is_dir($test_datadir))
				exiterror_fullpage("The data directory specified in the registry file [$test_datadir] could not be found.");
			
			/* check that <text> and <text_id> are s-attributes */
			if (preg_match('/\bSTRUCTURE\s+text\b/', $regdata) < 1 
				|| preg_match('/\bSTRUCTURE\s+text_id\b/', $regdata) < 1)
				exiterror_fullpage("Pre-indexed corpora require s-attributes text and text_id!!");
		}
		else /* ie if this is NOT an already indexed corpus */
		{
			global $cqpweb_uploaddir;
			
			preg_match_all('/includeFile=([^&]*)&/', $_SERVER['QUERY_STRING'], $m, PREG_PATTERN_ORDER);
			
			$this->file_list = array();
			
			foreach($m[1] as $file)
			{
				$path = "/$cqpweb_uploaddir/$file";
				if (is_file($path))
					$this->file_list[] = $path;
				else
					exiterror_fullpage("One of the files you selected seems to have been deleted.");
			}
			
			if (empty($this->file_list))
				exiterror_fullpage("You must specify at least one file to include in the corpus!");		
		}

		

		/* ******************* */
		
		/* p-attributes */
		if ($this->already_cwb_indexed)
		{
			preg_match_all("/ATTRIBUTE\s+(\w+)\s*[#\n]/", $regdata, $m, PREG_PATTERN_ORDER);
			foreach($m[1] as $p)
			{
				if ($p == 'word')
					continue;
				$this->p_attributes[] = $p;
				$this->p_attributes_mysql_insert[] = $this->get_p_att_mysql_insert($p, '', '', '');
				
				/* note that no "primary" annotation is created if we are loading in an existing corpus; 
				 * instead, the primary annotation can be set later.
				 * note also that cwb_external applies EVEN IF the indexed corpus was already in this directory
				 * (its sole use is to prevent deletion of data that CQPweb did not create)
				 */
				$this->corpus_metadata_fixed_mysql_insert =
					"insert into corpus_metadata_fixed (corpus, primary_annotation, cwb_external) 
					values ('{$this->corpus_mysql_name}', NULL, 1)";
			}
		}
		else
			$this->load_p_atts_based_on_get();


		/* ******************* */

		
		/* s-attributes */
		
		/* if text is declared through the interface, don't add */
		$text_attribute_explicit = false;
		
		if ($_GET['withDefaultSs'] === '1')
		{
			//HebrewCQPChange: HaimS = Changed the default structural attributes
			$this->s_attributes[] = 'a';
			$this->s_attributes[] = 'p';
			$this->s_attributes[] = 's';
		}
		else
		{
			for ( $q = 1 ; !empty($_GET["customS$q"]) ; $q++ )
			{
				if (preg_match('/^\w+(:0)?(\+\w+)+$/', $_GET["customS$q"]) > 0)
					$cand = $_GET["customS$q"];
				else
					$cand = cqpweb_handle_enforce($_GET["customS$q"]);

				if (($test_cand = substr($cand, 0, 5)) == 'text:' || $test_cand == 'text+')
				{
					/* this is a declaration of 'text', so enforce id */
					$text_attribute_explicit = true;
					if (! in_array('id', explode('+', $cand)))
						$cand .= '+id';
				}

				if ($cand === ''|| $cand == 'text')
					continue;
				else
					$this->s_attributes[] = $cand;
			}
		}
		/* have to have this one! */
		if (!$text_attribute_explicit)
			$this->s_attributes[] = 'text:0+id';

		
		/* ******************* */

		if ($_GET['cssCustom'] == 1)
		{
			/* escape single quotes in the address because it will be embedded in a single-quoted string */ 
			$this->css_url = addcslashes($_GET['cssCustomUrl'], "'");
			/* only a silly URL would have ' in it anyway, so this is for safety */
			// TODO poss XSS vulnerability - as this URL is sent back to the client eventually. 
			// Is there *any* way to make this safe? (Assuming an attacker has gained access to this form)
			// Probably not. Might be better to make external-url-for-css something that can only be done
			// by manual editing of the settings file. 
		}
		else
		{
			/* we assume no single quotes in names of builtin CSS files */ 
			$this->css_url = "../css/{$_GET['cssBuiltIn']}";
			if (! is_file($this->css_url))
				$this->css_url = '';
		}
		
		/* ******************* */
		
		
		
		
	} /* end constructor */
	
	
	// TODO currently the code here WILL NOT allow feature sets
	private function load_p_atts_based_on_get()
	{
		if ($_GET['withDefaultPs'] === '1')
		{
			//HebrewCQPChange : Haims - Change the default -P attributes
			$this->p_attributes[] = 'prefix1';
			$this->p_attributes_mysql_insert[] 
			= $this->get_p_att_mysql_insert('prefix1', '', '', '');
			$this->p_attributes[] = 'prefix2';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('prefix2', '', '', '');
			$this->p_attributes[] = 'prefix3';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('prefix3', '', '', '');
			$this->p_attributes[] = 'prefix4';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('prefix4', '', '', '');
			$this->p_attributes[] = 'prefix5';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('prefix5', '', '', '');
			$this->p_attributes[] = 'prefix6';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('prefix6', '', '', '');
			$this->p_attributes[] = 'lexiconitem';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('lexiconitem', '', '', '');
			$this->p_attributes[] = 'base';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('base', '', '', '');
			$this->p_attributes[] = 'expansion';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('expansion', '', '', '');
			$this->p_attributes[] = 'function';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('function', '', '', '');
			$this->p_attributes[] = 'root';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('root', '', '', '');
			$this->p_attributes[] = 'subcoordinating';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('subcoordinating', '', '', '');
			$this->p_attributes[] = 'mood';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('mood', '', '', '');
			$this->p_attributes[] = 'value';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('value', '', '', '');
			$this->p_attributes[] = 'id';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('id', '', '', '');
			$this->p_attributes[] = 'pos';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('pos', '', '', '');
			$this->p_attributes[] = 'consecutive';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('consecutive', '', '', '');
			$this->p_attributes[] = 'multiword';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('multiword', '', '', '');
			$this->p_attributes[] = 'type';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('type', '', '', '');
			$this->p_attributes[] = 'suffix';
			$this->p_attributes_mysql_insert[]
			= $this->get_p_att_mysql_insert('suffix', '', '', '');
			
			$this->primary_p_attribute = NULL;
			
			$this->corpus_metadata_fixed_mysql_insert =
			"insert into corpus_metadata_fixed (corpus, primary_annotation)
			values ('{$this->corpus_mysql_name}', NULL)";			
		}
		else
		{
			for ( $q = 1 ; isset($_GET["customPHandle$q"]) ; $q++ )
			{
				$cand = preg_replace('/\W/', '', $_GET["customPHandle$q"]);
				if ($cand === '')
					continue;
				else
				{
					//TODO need to add / to cwb-encode command line input string if it's a featureset.
					$this->p_attributes[] = $cand;
	
					$this->p_attributes_mysql_insert[] = $this->get_p_att_mysql_insert(
						$cand, 
						mysql_real_escape_string($_GET["customPDesc$q"]), 
						mysql_real_escape_string($_GET["customPTagset$q"]), 
						mysql_real_escape_string($_GET["customPurl$q"]));
				}
			}
			
			if (isset($_GET['customPPrimary']))
				$this->primary_p_attribute = 
					preg_replace('/\W/', '', $_GET["customPHandle{$_GET['customPPrimary']}"]);
			else
				$this->primary_p_attribute = NULL;
			
			
			if (isset ($this->primary_p_attribute))
				$this->corpus_metadata_fixed_mysql_insert =
					"insert into corpus_metadata_fixed (corpus, primary_annotation) 
					values ('{$this->corpus_mysql_name}', '{$this->primary_p_attribute}')";
			else
				$this->corpus_metadata_fixed_mysql_insert =
					"insert into corpus_metadata_fixed (corpus, primary_annotation) 
					values ('{$this->corpus_mysql_name}', NULL)";
		}
	
	} /* end of function */


	
	private function get_p_att_mysql_insert($tag_handle, $description, $tagset, $url)
	{
		/* assumes everything alreadey made safe with mysql_real_escape_string or equiv */
		return
			"insert into annotation_metadata (corpus, handle, description, tagset, external_url) values 
			('{$this->corpus_mysql_name}', '$tag_handle', '$description', '$tagset', '$url')";
	}

}/* end class (corpus_install_info) */





function install_new_corpus()
{
	global $path_to_cwb;
	global $cqpweb_accessdir;
	global $cqpweb_tempdir;
	global $cwb_datadir;
	global $cwb_registry;
	
	$info = new corpus_install_info;
	/* we need both case versions here */
	$corpus = $info->corpus_cwb_name;
	$CORPUS = strtoupper($corpus);


	/* check whether corpus already exists */
	$existing_corpora = list_corpora();
	if ( in_array($info->corpus_mysql_name, $existing_corpora) )
		exiterror_fullpage("Corpus `$corpus' already exists on the system." 
			. "Please specify a different SQL name for your new corpus.");

	/* ======================================================
	 * create web folder and its settings.inc.php file FIRST, 
	 * so that if indexing fails, deletion should still work 
	 * ====================================================== */

	/* make a web dir and set up with superuser access */
	$newdir = realpath("..") . '/' . $info->corpus_mysql_name;
	
	if (file_exists($newdir))
	{
		if (is_dir($newdir))
			recursive_delete_directory($newdir);
		else
			unlink($newdir);
	}

	mkdir($newdir, 0775);
	
	$settings = new apache_htaccess($newdir);
	$settings->set_AuthName('CQPweb');
	$settings->set_path_to_password_file("/$cqpweb_accessdir/.htpasswd");
	$settings->set_path_to_groups_file("/$cqpweb_accessdir/.htgroup");
	$settings->allow_group('superusers');
	$settings->save();
	chmod("$newdir/.htaccess", 0664);
	 
	/* create the script files in that folder */
	install_create_corpus_script_files($newdir);


	/* write a settings.inc.php file */
	install_create_settings_file("$newdir/settings.inc.php", $info);

	

	/* mysql table inserts */
	if (! empty($info->p_attributes_mysql_insert))
	{
		foreach ($info->p_attributes_mysql_insert as &$s)
			do_mysql_query($s);
	}
	do_mysql_query($info->corpus_metadata_fixed_mysql_insert);


	/* cwb setup comes last; if it fails, deletion should still work */
	if ($info->already_cwb_indexed)
		;
	else
	{
		/* cwb-create the file */
		$datadir = "/$cwb_datadir/$corpus";	
		if (is_dir($datadir))
			recursive_delete_directory($datadir);
		mkdir($datadir, 0775);
	
		/* run the commands one by one */
		
		$encode_command =  "/$path_to_cwb/cwb-encode -xsB -c {$info->encode_charset} -d $datadir -f "
			. implode(' -f ', $info->file_list)
			. " -R /$cwb_registry/$corpus "
			. ( empty($info->p_attributes) ? '' : (' -P ' . implode(' -P ', $info->p_attributes)) )
			. ' -S ' . implode(' -S ', $info->s_attributes)
			. ' 2>&1';
			/* NB don't need possibility of no S-atts because there is always text:0+id */
			/* NB the 2>&1 works on BOTH Win32 AND Unix */

		$exit_status_from_cwb = 0;
		/* NB this array collects both the commands used and the output sent back (via stderr, stdout) */
		$output_lines_from_cwb = array($encode_command);

		exec($encode_command, $output_lines_from_cwb, $exit_status_from_cwb);
		if ($exit_status_from_cwb != 0)
			exiterror_fullpage("cwb-encode reported an error! Corpus indexing aborted. <pre>"
				. implode("\n", $output_lines_from_cwb) . '</pre>'
				, __FILE__, __LINE__);

		chmod("/$cwb_registry/$corpus", 0664);

		$output_lines_from_cwb[] = $makeall_command = "/$path_to_cwb/cwb-makeall -r /$cwb_registry -V $CORPUS 2>&1";
		exec($makeall_command, $output_lines_from_cwb, $exit_status_from_cwb);
		if ($exit_status_from_cwb != 0)
			exiterror_fullpage("cwb-makeall reported an error! Corpus indexing aborted. <pre>"
				. implode("\n", $output_lines_from_cwb) . '</pre>'
				, __FILE__, __LINE__);

		/* use a separate array for the compression utilities (merged into main output block later) */
		$compression_output = array();
		$compression_output[] = $huffcode_command = "/$path_to_cwb/cwb-huffcode -r /$cwb_registry -A $CORPUS 2>&1";
		exec($huffcode_command, $compression_output, $exit_status_from_cwb);
		if ($exit_status_from_cwb != 0)
			exiterror_fullpage("cwb-huffcode reported an error! Corpus indexing aborted. <pre>"
				. implode("\n", array_merge($output_lines_from_cwb,$compression_output)) . '</pre>'
				, __FILE__, __LINE__);

		$compression_output[] = $compress_rdx_command = "/$path_to_cwb/cwb-compress-rdx -r /$cwb_registry -A $CORPUS 2>&1";
		exec($compress_rdx_command, $compression_output, $exit_status_from_cwb);
		if ($exit_status_from_cwb != 0)
			exiterror_fullpage("cwb-compress-rdx reported an error! Corpus indexing aborted. <pre>"
				. implode("\n", array_merge($output_lines_from_cwb,$compression_output)) . '</pre>'
				, __FILE__, __LINE__);

		foreach($compression_output as $line)
		{
			$output_lines_from_cwb[] = $line;
			if (0 < preg_match('/!! You can delete the file <(.*)> now/', $line, $m))
				if (is_file($m[1]))
					unlink($m[1]);
		}

		
		/*
		 TODO save the entire output blob in a mysql table that preserves its contents for a day 
		 (clean out on next update).
		 Then, the "finished" screen can have an extra link:Javascript function to display the
		 output from CWB.
		 This will allow you to see, f'rinstance, any dodgy messages about XML elements that were droppped
		 or encoded as literals.
		 */ 
	}
	
		
	/* make sure execute.php takes us to a nice results screen */
	$_GET['locationAfter'] 
		= "index.php?thisF=installCorpusDone&newlyInstalledCorpus={$info->corpus_mysql_name}&uT=y";

}



function install_create_settings_file($filepath, $info)
{
	$data = "<?php\n\n"
		. "\$corpus_title = '{$info->description}';\n"
		. "\$corpus_sql_name = '{$info->corpus_mysql_name}';\n"
		. "\$corpus_cqp_name = '" . strtoupper($info->corpus_cwb_name) . "';\n"
		. "\$css_path = '{$info->css_url}';\n"
		. ($info->script_is_r2l ? "\$corpus_main_script_is_r2l = true;\n" : '')
		. '?>';
	file_put_contents($filepath, $data);
	chmod($filepath, 0664);
}


function install_create_corpus_script_files($in_dir)
{
	global $cqpweb_script_files;
	foreach ($cqpweb_script_files as $c)
	{
		file_put_contents("$in_dir/$c.php", "<?php require('../lib/$c.inc.php'); ?>");
		chmod("$in_dir/$c.php", 0664);
	}		
}



?>
