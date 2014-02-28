Class GrandTheftRating
{	
	public static function getBookInfo($url)
	{
		$userInfo=array();

		if(!($file = @file_get_html($url))){
	        throw new Exception('Cannot download file ' . $url);
	    }
	    $ratingBar = $file->find('#rating_bar');
		$ratingBar = reset($ratingBar);
		$ratingValue=$ratingBar->find('div[itemprop="ratingValue"]');
		$reviewCount=$ratingBar->find('div[itemprop="reviewCount"]');
		$allTags=$file->find('#detail_tags div.bMyTag span.bMyTag a');
		$ratingValue=reset($ratingValue);
		$reviewCount=reset($reviewCount);
		$allTags=reset($allTags);
		foreach($allTags as $tag) {
			$userInfo['tags'][]=$tag->title;
		}

	    $userInfo['ratingValue']=($ratingValue?$ratingValue->innerText():0);
	    $userInfo['reviewCount']=($reviewCount?$reviewCount->innerText():0);

	    echo json_encode($userInfo);
	}
}
