	// globals
	$post_id = get_the_ID();
	$metadata_fields = array(
		"book_title",
		"book_title_orig",
		"book_author",
		"book_translator",
		"book_genre_backend",
		"book_publisher",
		"book_pub_date",
		"book_pages",
		"book_source_lang",
		"book_target_lang"
	);


 
	// only display block if the item is a post
	if (in_array(get_post_type($post_id), array('post'))) {
		// retrieve book metadata	
		foreach ($metadata_fields as $field) {
			${$field} = get_post_meta($post_id, $field, true);
		}
		
		// conditional lines 		
		$display_none = "style=\"display:none;\"";
		$orig_title_switch = "$display_none";
		$lang_info_switch = "$display_none";
		$publish_info_switch = "$display_none";
		

		
		if (!empty($book_title_orig)) {
			$orig_title_switch = "";
		}
		
		if (!empty($book_source_lang)) {
			$lang_info_switch = "";
			if (!empty($book_target_lang) && !empty($book_translator)) {
				$lang_info = "Vertaald uit het $book_source_lang door $book_translator";	
			} else {
				$lang_info = "$book_source_lang";	
			}
		}
		
		if (!empty($book_publisher) && !empty($book_pub_date) && !empty($book_pages)) {
				$publish_info_switch = "";
				$publish_info = "$book_publisher ($book_pub_date), $book_pages blz.";	
		}

				
		// create metadata block
		$metadata_block = <<<EOD
<div class="card">
	<div class="card-body">
		<h6 class="card-title">$book_author, <em>$book_title</em></h6>
		<ul class="card-list">
			<li class="card-list-item" $orig_title_switch ><em>$book_title_orig</em></li>
			<li class="card-list-item" $lang_info_switch >$lang_info</li>
			<li class="card-list-item" $publish_info_switch>$publish_info</li>
		</ul>
	</div>
</div>
EOD;
		
		// output metadata block
		echo $metadata_block;
	}

