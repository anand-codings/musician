<?php foreach($results as $result) { ?>
    <div class="youtube_search_listing p-2" data-id="<?=$result->id->videoId?>">
        <h6 class="px-2"><strong><?=$result->snippet->title?></strong> <p><?=$result->snippet->channelTitle?></p></h6>
      
        <img src="<?=$result->snippet->thumbnails->default->url?>" />
    </div>
<?php } ?>