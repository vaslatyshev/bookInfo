<?php 

namespace vaslatyshev\bookinfo;

Class GrandTheftRating
{	
	public static function getBookInfo($url)
	{
		$userInfo=array();
		
		if(!($file = @file_get_html($url))){
	        throw new Exception('Cannot download file ' . $url);
	    }
	    
	    $bookInfoResult=new BookInfoResult;
	    
	    $ratingBar = $file->find('#rating_bar');
		$ratingBar = reset($ratingBar);
		$ratingValue=$ratingBar->find('div[itemprop="ratingValue"]');
		$reviewCount=$ratingBar->find('div[itemprop="reviewCount"]');
		$allTags=$file->find('#detail_tags div.bMyTag span.bMyTag a');
		$ratingValue=reset($ratingValue);
		$reviewCount=reset($reviewCount);
		$allTags=reset($allTags);
		foreach($allTags as $tag) {
			$bookInfoResult->tags[]=$tag->title;
		}
		
	    $bookInfoResult->ratingValue=($ratingValue?$ratingValue->innerText():0);
	    $bookInfoResult->reviewCount=($reviewCount?$reviewCount->innerText():0);
	    
	    return $bookInfoResult;
	}
}
