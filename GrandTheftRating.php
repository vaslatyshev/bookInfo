<?php 

namespace vaslatyshev\bookinfo;

Class GrandTheftRating
{	
	public static function getBookInfo($url)
	{
		$userInfo=array();

		if(!($file = @file_get_html($url))){
	        throw new \Exception('Cannot download file ' . $url);
	    }
	    
	    $bookInfoResult=new BookInfoResult;
	    if (!method_exists($file,'find'))
	    	return $bookInfoResult;
	    	
	    	$ratingBar = $file->find('#rating_bar');
		$ratingBar = reset($ratingBar);
		$ratingValue=$ratingBar->find('div[itemprop="ratingValue"]');
		$reviewCount=$ratingBar->find('div[itemprop="reviewCount"]');
		$allTags=$file->find('#detail_tags .make-checkin-form .pseudo-href li span');
		$ratingValue=reset($ratingValue);
		$reviewCount=reset($reviewCount);
		$i=0;
		if (count($allTags)>0)
			foreach($allTags as $tag) {
				$bookInfoResult->tags[]=mb_convert_encoding($tag->innerText(), 'utf8','windows-1251');
				if (++$i>$bookInfoResult->cntTags)
					break;
			}

	    $bookInfoResult->ratingValue=($ratingValue?$ratingValue->innerText():0);
	    $bookInfoResult->reviewCount=($reviewCount?$reviewCount->innerText():0);

	    return $bookInfoResult;
	}
}
