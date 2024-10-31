<?php

/*
Plugin Name: Random Tagline
Plugin URI: http://www.danposluns.com/wordpress/random_tagline
Description: Display a random tagline from a quotefile instead of your fixed tagline.
Author: Dan Posluns
Version: 1.2
Author URI: http://www.danposluns.com
*/ 

function random_tagline_add_pages()
{
	add_options_page('Random Tagline', 'Random Tagline', 8,  __FILE__, 'random_tagline_options');
}

$random_tagline_current_tagline = NULL;

function random_tagline_bloginfo($result = '', $show = '')
{
	if ($show == 'description')
	{
		global $random_tagline_current_tagline;
		
		if (is_null($random_tagline_current_tagline))
		{
			$quotefile = get_option('random_tagline_file');
			if (strlen($quotefile) && file_exists($quotefile))
			{
				$quotes = file($quotefile);
				$random_tagline_current_tagline = $quotes[array_rand($quotes)]; 
			}
			else
			{
				$random_tagline_current_tagline = $result;
			}
		}
		
		return $random_tagline_current_tagline;
	}

	return $result;
}

add_filter('bloginfo', 'random_tagline_bloginfo', 1, 2);
add_action('admin_menu', 'random_tagline_add_pages');

function random_tagline_options()
{

$quotefile = get_option('random_tagline_file');

?>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<div class="wrap">
<h2>Random Tagline Options</h2>
<p />
Taglines are placed in a normal text file, one line per tagline.
<p />
Path to tagline file: 
<input type="text" name="random_tagline_file" value="<?= $quotefile ?>" />
<br />
(Relative or absolute paths may be used. Paths are relative to your blog's root directory.)
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="random_tagline_file" />

<?php

$prevDir = getcwd();
chdir('../..');

if (!strlen($quotefile))
{

?>
<blockquote><font color="red">No tagline file has been specified.</font></blockquote>
<?php

}
else if (!file_exists($quotefile))
{

$dispPath = realpath($quotefile);
if (!strlen($dispPath))
{
	$dispPath = getcwd() . DIRECTORY_SEPARATOR . $quotefile;
}

?>
<blockquote><font color="red">Error: no file found at <?= $dispPath ?></font></blockquote>
<?php

}
else if (!is_readable($quotefile))
{

?>
<blockquote><font color="red">Error: insufficient permissions to access the file at <?= realpath($quotefile) ?></font></blockquote>
<?php

}
else
{
	$lines = file($quotefile);
	if ($lines === FALSE)
	{
	
?>
<blockquote><font color="red">Error: unable to read the file at <?= realpath($quotefile) ?></font></blockquote>
<?php
	
	}
	else if (count($lines) < 2)
	{
		$msg = (count($lines) == 1) ? 'only 1 line' : 'no text';
	
?>
<blockquote><font color="red">Warning: <?= $msg ?> in the file at <?= realpath($quotefile) ?></font></blockquote>
<?php
	
	
	}
	else
	{

?>
<blockquote><font color="blue">Tagline file successfully loaded. <?= count($lines) ?> taglines found.</font></blockquote>
<?php
	
	}
	
}

chdir($prevDir);

?>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>

</div>
</form>

<?php

}

?>
