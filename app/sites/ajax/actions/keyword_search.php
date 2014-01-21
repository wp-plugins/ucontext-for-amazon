<?php

if (isset($_REQUEST['keyword_id']) && $_REQUEST['keyword_id'])
{
	$keyword_id_list = explode(',', $_REQUEST['keyword_id']);

	$_REQUEST['keyword_id'] = array_shift($keyword_id_list);

	require UAMAZON_APP_PATH.'/Uamazon_Keyword.php';

	$search_results = Uamazon_Keyword::getResults($_REQUEST['keyword_id'], TRUE);

	if ($search_results)
	{
		$keyword = $wpdb->get_row('SELECT * FROM '.self::$table['keyword'].' WHERE keyword_id = '.(int)$_REQUEST['keyword_id'], ARRAY_A);

		$found = false;
		foreach ($search_results as $asin => $item)
		{
			if ($keyword['aws_asin'] == $asin)
			{
				$found = true;
			}
		}

		$row = 0;

		foreach ($search_results as $asin => $item)
		{
			$row++;
			if ($row == 1 && !$found)
			{
				$keyword['aws_asin'] = $asin;
			}

			$checked = '';
			if ($keyword['aws_asin'] == $asin)
			{
				$checked = ' checked';
			}

			echo '
<table width="100%" cellspacing="0" cellpadding="0" class="uamazon_list_table">
<tr>
	<td width="1%"><input type="radio" name="aws_asin" value="'.$asin.'"'.$checked.' /></td>
	<td><a href="'.$item['url'].'" target="_blank">'.$item['title'].'</a></td>
</tr>
</table>
';
		}
	}
	else
	{
		echo '
<table width="100%" cellspacing="0" cellpadding="0" class="uamazon_list_table">
<tr>
	<td colspan="2"><br /><center><strong>No Amazon products found</strong></center><br /></td>
</tr>
</table>
';
	}
}

exit();
/*

object(SimpleXMLElement)#367 (2) {
  ["OperationRequest"]=>
  object(SimpleXMLElement)#368 (4) {
    ["HTTPHeaders"]=>
    object(SimpleXMLElement)#370 (1) {
      ["Header"]=>
      object(SimpleXMLElement)#4 (1) {
        ["@attributes"]=>
        array(2) {
          ["Name"]=>
          string(9) "UserAgent"
          ["Value"]=>
          string(43) "WordPress/3.4.1; http://www.auctionpile.net"
        }
      }
    }
    ["RequestId"]=>
    string(36) "3dce3011-def0-45a9-aa1c-7bdb718447c8"
    ["Arguments"]=>
    object(SimpleXMLElement)#371 (1) {
      ["Argument"]=>
      array(11) {
        [0]=>
        object(SimpleXMLElement)#4 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Condition"
            ["Value"]=>
            string(3) "New"
          }
        }
        [1]=>
        object(SimpleXMLElement)#383 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Operation"
            ["Value"]=>
            string(10) "ItemSearch"
          }
        }
        [2]=>
        object(SimpleXMLElement)#382 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(7) "Service"
            ["Value"]=>
            string(19) "AWSECommerceService"
          }
        }
        [3]=>
        object(SimpleXMLElement)#381 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(12) "AssociateTag"
            ["Value"]=>
            string(14) "thephpgrind-20"
          }
        }
        [4]=>
        object(SimpleXMLElement)#380 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(7) "Version"
            ["Value"]=>
            string(10) "2011-08-01"
          }
        }
        [5]=>
        object(SimpleXMLElement)#379 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(8) "Keywords"
            ["Value"]=>
            string(18) "internet marketing"
          }
        }
        [6]=>
        object(SimpleXMLElement)#378 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(11) "SearchIndex"
            ["Value"]=>
            string(3) "All"
          }
        }
        [7]=>
        object(SimpleXMLElement)#333 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Signature"
            ["Value"]=>
            string(44) "EonNeNoMJf9p9xg+eWFQSVa2Y1evmvyshQjOlTLud5U="
          }
        }
        [8]=>
        object(SimpleXMLElement)#332 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(14) "AWSAccessKeyId"
            ["Value"]=>
            string(20) "09786QDT6PYQFSRE3NG2"
          }
        }
        [9]=>
        object(SimpleXMLElement)#331 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Timestamp"
            ["Value"]=>
            string(20) "2013-03-22T22:26:57Z"
          }
        }
        [10]=>
        object(SimpleXMLElement)#330 (1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(13) "ResponseGroup"
            ["Value"]=>
            string(21) "ItemAttributes,Offers"
          }
        }
      }
    }
    ["RequestProcessingTime"]=>
    string(18) "0.0819400000000000"
  }
  ["Items"]=>
  object(SimpleXMLElement)#369 (5) {
    ["Request"]=>
    object(SimpleXMLElement)#371 (2) {
      ["IsValid"]=>
      string(4) "True"
      ["ItemSearchRequest"]=>
      object(SimpleXMLElement)#383 (4) {
        ["Condition"]=>
        string(3) "New"
        ["Keywords"]=>
        string(18) "internet marketing"
        ["ResponseGroup"]=>
        array(2) {
          [0]=>
          string(14) "ItemAttributes"
          [1]=>
          string(6) "Offers"
        }
        ["SearchIndex"]=>
        string(3) "All"
      }
    }
    ["TotalResults"]=>
    string(5) "24106"
    ["TotalPages"]=>
    string(4) "2411"
    ["MoreSearchResultsUrl"]=>
    string(257) "http://www.amazon.com/gp/redirect.html?camp=2025&creative=386001&location=http%3A%2F%2Fwww.amazon.com%2Fgp%2Fsearch%3Fkeywords%3Dinternet%2Bmarketing%26url%3Dsearch-alias%253Daws-amazon-aps&linkCode=xm2&tag=thephpgrind-20&SubscriptionId=09786QDT6PYQFSRE3NG2"
    ["Item"]=>
    array(10) {
      [0]=>
      object(SimpleXMLElement)#370 (6) {
        ["ASIN"]=>
        string(10) "0470633743"
        ["DetailPageURL"]=>
        string(208) "http://www.amazon.com/Internet-Marketing-An-Hour-Day/dp/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0470633743"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#383 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(218) "http://www.amazon.com/Internet-Marketing-An-Hour-Day/dp/tech-data/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [1]=>
            object(SimpleXMLElement)#326 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D0470633743%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [2]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D0470633743%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [3]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D0470633743%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [4]=>
            object(SimpleXMLElement)#323 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [5]=>
            object(SimpleXMLElement)#322 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
            [6]=>
            object(SimpleXMLElement)#321 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#4 (23) {
          ["Author"]=>
          string(11) "Matt Bailey"
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9780470633748"
          ["EANList"]=>
          object(SimpleXMLElement)#321 (1) {
            ["EANListElement"]=>
            string(13) "9780470633748"
          }
          ["Edition"]=>
          string(1) "1"
          ["ISBN"]=>
          string(10) "0470633743"
          ["IsEligibleForTradeIn"]=>
          string(1) "1"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#322 (4) {
            ["Height"]=>
            string(3) "921"
            ["Length"]=>
            string(3) "744"
            ["Weight"]=>
            string(3) "202"
            ["Width"]=>
            string(3) "134"
          }
          ["Label"]=>
          string(5) "Sybex"
          ["Languages"]=>
          object(SimpleXMLElement)#323 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#327 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#320 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#319 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#324 (3) {
            ["Amount"]=>
            string(4) "2999"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$29.99"
          }
          ["Manufacturer"]=>
          string(5) "Sybex"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "600"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#325 (4) {
            ["Height"]=>
            string(3) "150"
            ["Length"]=>
            string(3) "920"
            ["Weight"]=>
            string(3) "195"
            ["Width"]=>
            string(3) "740"
          }
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2011-04-05"
          ["Publisher"]=>
          string(5) "Sybex"
          ["SKU"]=>
          string(7) "7812378"
          ["Studio"]=>
          string(5) "Sybex"
          ["Title"]=>
          string(33) "Internet Marketing: An Hour a Day"
          ["TradeInValue"]=>
          object(SimpleXMLElement)#326 (3) {
            ["Amount"]=>
            string(3) "777"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$7.77"
          }
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#329 (6) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#326 (3) {
            ["Amount"]=>
            string(4) "1662"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$16.62"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#325 (3) {
            ["Amount"]=>
            string(4) "1868"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$18.68"
          }
          ["TotalNew"]=>
          string(2) "28"
          ["TotalUsed"]=>
          string(2) "14"
          ["TotalCollectible"]=>
          string(1) "0"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#328 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/0470633743%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0470633743"
          ["Offer"]=>
          object(SimpleXMLElement)#325 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#326 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#324 (7) {
              ["OfferListingId"]=>
              string(160) "wXFBbvx1s289z2BLBYqby6o6BMsBPW9xLBARJVdOwSXPEfcXX0KdHP1mhHGrU7KhlDcd1zDKY7NFxZDBSs7DFZUlPWs6%2Ffry1Nt07i1MVsUY7R2eeora9MTlaA8uGLUtghuctEEtW8J%2FSDak6pFOpw%3D%3D"
              ["Price"]=>
              object(SimpleXMLElement)#323 (3) {
                ["Amount"]=>
                string(4) "1662"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$16.62"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#322 (3) {
                ["Amount"]=>
                string(4) "1337"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$13.37"
              }
              ["PercentageSaved"]=>
              string(2) "45"
              ["Availability"]=>
              string(34) "Usually ships in 1-2 business days"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#321 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(2) "24"
                ["MaximumHours"]=>
                string(2) "48"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "0"
            }
          }
        }
      }
      [1]=>
      object(SimpleXMLElement)#330 (4) {
        ["ASIN"]=>
        string(10) "B008OAFN7I"
        ["DetailPageURL"]=>
        string(216) "http://www.amazon.com/Effective-E-Marketing-Strategies-ebook/dp/B008OAFN7I%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB008OAFN7I"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#328 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(226) "http://www.amazon.com/Effective-E-Marketing-Strategies-ebook/dp/tech-data/B008OAFN7I%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [1]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3DB008OAFN7I%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [2]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3DB008OAFN7I%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [3]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3DB008OAFN7I%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [4]=>
            object(SimpleXMLElement)#326 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/B008OAFN7I%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [5]=>
            object(SimpleXMLElement)#321 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/B008OAFN7I%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
            [6]=>
            object(SimpleXMLElement)#322 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/B008OAFN7I%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB008OAFN7I"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#329 (16) {
          ["Author"]=>
          string(17) "Curtis Carmichael"
          ["Binding"]=>
          string(14) "Kindle Edition"
          ["Format"]=>
          string(12) "Kindle eBook"
          ["IsAdultProduct"]=>
          string(1) "0"
          ["Label"]=>
          string(16) "HyperFusion, LLC"
          ["Languages"]=>
          object(SimpleXMLElement)#322 (1) {
            ["Language"]=>
            object(SimpleXMLElement)#321 (2) {
              ["Name"]=>
              string(7) "English"
              ["Type"]=>
              string(9) "Published"
            }
          }
          ["Manufacturer"]=>
          string(16) "HyperFusion, LLC"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "117"
          ["ProductGroup"]=>
          string(6) "eBooks"
          ["ProductTypeName"]=>
          string(11) "ABIS_EBOOKS"
          ["PublicationDate"]=>
          string(10) "2012-07-22"
          ["Publisher"]=>
          string(16) "HyperFusion, LLC"
          ["ReleaseDate"]=>
          string(10) "2012-07-22"
          ["Studio"]=>
          string(16) "HyperFusion, LLC"
          ["Title"]=>
          string(32) "Effective E-Marketing Strategies"
        }
      }
      [2]=>
      object(SimpleXMLElement)#331 (6) {
        ["ASIN"]=>
        string(10) "1118026985"
        ["DetailPageURL"]=>
        string(214) "http://www.amazon.com/The-New-Rules-Marketing-Applications/dp/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D1118026985"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#329 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#326 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(224) "http://www.amazon.com/The-New-Rules-Marketing-Applications/dp/tech-data/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [1]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D1118026985%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [2]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D1118026985%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [3]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D1118026985%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [4]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [5]=>
            object(SimpleXMLElement)#323 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
            [6]=>
            object(SimpleXMLElement)#319 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#328 (23) {
          ["Author"]=>
          string(19) "David Meerman Scott"
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9781118026984"
          ["EANList"]=>
          object(SimpleXMLElement)#319 (1) {
            ["EANListElement"]=>
            string(13) "9781118026984"
          }
          ["Edition"]=>
          string(1) "3"
          ["ISBN"]=>
          string(10) "1118026985"
          ["IsEligibleForTradeIn"]=>
          string(1) "1"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#323 (4) {
            ["Height"]=>
            string(3) "902"
            ["Length"]=>
            string(3) "638"
            ["Weight"]=>
            string(3) "107"
            ["Width"]=>
            string(3) "106"
          }
          ["Label"]=>
          string(5) "Wiley"
          ["Languages"]=>
          object(SimpleXMLElement)#4 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#326 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#320 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#327 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#383 (3) {
            ["Amount"]=>
            string(4) "1995"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$19.95"
          }
          ["Manufacturer"]=>
          string(5) "Wiley"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "366"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#325 (4) {
            ["Height"]=>
            string(3) "120"
            ["Length"]=>
            string(3) "920"
            ["Weight"]=>
            string(3) "145"
            ["Width"]=>
            string(3) "620"
          }
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2011-08-30"
          ["Publisher"]=>
          string(5) "Wiley"
          ["SKU"]=>
          string(24) "291554997783001769710639"
          ["Studio"]=>
          string(5) "Wiley"
          ["Title"]=>
          string(159) "The New Rules of Marketing & PR: How to Use Social Media, Online Video, Mobile Applications, Blogs, News Releases, and Viral Marketing to Reach Buyers Directly"
          ["TradeInValue"]=>
          object(SimpleXMLElement)#324 (3) {
            ["Amount"]=>
            string(3) "200"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$2.00"
          }
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#322 (6) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#324 (3) {
            ["Amount"]=>
            string(3) "999"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$9.99"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#325 (3) {
            ["Amount"]=>
            string(3) "650"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$6.50"
          }
          ["TotalNew"]=>
          string(2) "73"
          ["TotalUsed"]=>
          string(2) "43"
          ["TotalCollectible"]=>
          string(1) "0"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#321 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/1118026985%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1118026985"
          ["Offer"]=>
          object(SimpleXMLElement)#325 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#324 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#383 (7) {
              ["OfferListingId"]=>
              string(166) "bk06xhpWQ7Z01YZKxJLWM0U2LcLS4g3AY3rUrMBQvDpM84BCsAixWFo8L4edWQ3Y2q8M1qp3YErv4uwN5ySsIiWjKBKcdkQD%2BXHEduC%2BZj7alpSVL0y1f6osieky0FRdxgbFS%2BOPzeRZYcVHWrLV1dJcQMcsxgKO"
              ["Price"]=>
              object(SimpleXMLElement)#4 (3) {
                ["Amount"]=>
                string(4) "1000"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$10.00"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#323 (3) {
                ["Amount"]=>
                string(3) "995"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(5) "$9.95"
              }
              ["PercentageSaved"]=>
              string(2) "50"
              ["Availability"]=>
              string(34) "Usually ships in 1-2 business days"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#319 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(2) "24"
                ["MaximumHours"]=>
                string(2) "48"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "0"
            }
          }
        }
      }
      [3]=>
      object(SimpleXMLElement)#332 (4) {
        ["ASIN"]=>
        string(10) "B00986MVO0"
        ["DetailPageURL"]=>
        string(221) "http://www.amazon.com/Internet-Marketing-Ultimate-Practical-ebook/dp/B00986MVO0%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB00986MVO0"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#321 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(231) "http://www.amazon.com/Internet-Marketing-Ultimate-Practical-ebook/dp/tech-data/B00986MVO0%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [1]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3DB00986MVO0%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [2]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3DB00986MVO0%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [3]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3DB00986MVO0%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [4]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/B00986MVO0%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [5]=>
            object(SimpleXMLElement)#319 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/B00986MVO0%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
            [6]=>
            object(SimpleXMLElement)#323 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/B00986MVO0%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00986MVO0"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#322 (12) {
          ["Author"]=>
          string(14) "Samuel Ze-Anni"
          ["Binding"]=>
          string(14) "Kindle Edition"
          ["Format"]=>
          string(12) "Kindle eBook"
          ["IsAdultProduct"]=>
          string(1) "0"
          ["Languages"]=>
          object(SimpleXMLElement)#323 (1) {
            ["Language"]=>
            object(SimpleXMLElement)#319 (2) {
              ["Name"]=>
              string(7) "English"
              ["Type"]=>
              string(9) "Published"
            }
          }
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(2) "51"
          ["ProductGroup"]=>
          string(6) "eBooks"
          ["ProductTypeName"]=>
          string(11) "ABIS_EBOOKS"
          ["PublicationDate"]=>
          string(10) "2012-09-08"
          ["ReleaseDate"]=>
          string(10) "2012-09-08"
          ["Title"]=>
          string(82) "Your Internet Marketing Ultimate Swiss Army Knife (The Practical Marketing series)"
        }
      }
      [4]=>
      object(SimpleXMLElement)#333 (6) {
        ["ASIN"]=>
        string(10) "0071743863"
        ["DetailPageURL"]=>
        string(218) "http://www.amazon.com/The-McGraw-Hill-36-Hour-Course-Marketing/dp/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0071743863"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#322 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(228) "http://www.amazon.com/The-McGraw-Hill-36-Hour-Course-Marketing/dp/tech-data/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [1]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D0071743863%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [2]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D0071743863%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [3]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D0071743863%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [4]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [5]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
            [6]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#321 (22) {
          ["Author"]=>
          string(13) "Lorrie Thomas"
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9780071743860"
          ["EANList"]=>
          object(SimpleXMLElement)#327 (1) {
            ["EANListElement"]=>
            string(13) "9780071743860"
          }
          ["Edition"]=>
          string(1) "1"
          ["ISBN"]=>
          string(10) "0071743863"
          ["IsEligibleForTradeIn"]=>
          string(1) "1"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#4 (4) {
            ["Height"]=>
            string(3) "898"
            ["Length"]=>
            string(3) "598"
            ["Weight"]=>
            string(2) "78"
            ["Width"]=>
            string(2) "59"
          }
          ["Label"]=>
          string(11) "McGraw-Hill"
          ["Languages"]=>
          object(SimpleXMLElement)#328 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#383 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#324 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#320 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#329 (3) {
            ["Amount"]=>
            string(4) "2000"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$20.00"
          }
          ["Manufacturer"]=>
          string(11) "McGraw-Hill"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "272"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#325 (4) {
            ["Height"]=>
            string(2) "60"
            ["Length"]=>
            string(3) "900"
            ["Weight"]=>
            string(2) "80"
            ["Width"]=>
            string(3) "600"
          }
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2010-12-28"
          ["Publisher"]=>
          string(11) "McGraw-Hill"
          ["SKU"]=>
          string(9) "ZG4-00760"
          ["Studio"]=>
          string(11) "McGraw-Hill"
          ["Title"]=>
          string(78) "The McGraw-Hill 36-Hour Course: Online Marketing (McGraw-Hill 36-Hour Courses)"
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#323 (7) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#325 (3) {
            ["Amount"]=>
            string(3) "939"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$9.39"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#329 (3) {
            ["Amount"]=>
            string(3) "650"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$6.50"
          }
          ["LowestCollectiblePrice"]=>
          object(SimpleXMLElement)#328 (3) {
            ["Amount"]=>
            string(4) "2599"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$25.99"
          }
          ["TotalNew"]=>
          string(2) "31"
          ["TotalUsed"]=>
          string(2) "34"
          ["TotalCollectible"]=>
          string(1) "1"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#319 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/0071743863%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071743863"
          ["Offer"]=>
          object(SimpleXMLElement)#328 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#329 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#325 (7) {
              ["OfferListingId"]=>
              string(180) "xMeiQi%2BjNqMyoe1e%2FHo3xB%2Bkh1tgxoYlZHw%2Fr3Fslf8%2Fdd5FFu83c7QGApLSHQ2lgnD%2FkI%2FilFmLgz0h2eGAKpivCn4LI%2FxjgjbA3sWMDqkfDUQCO1A%2FtGFcO%2BG4Nwm0rkhh1iLwRs7leGAn5qscBfxGBT37oxOT"
              ["Price"]=>
              object(SimpleXMLElement)#4 (3) {
                ["Amount"]=>
                string(3) "939"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(5) "$9.39"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#327 (3) {
                ["Amount"]=>
                string(4) "1061"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$10.61"
              }
              ["PercentageSaved"]=>
              string(2) "53"
              ["Availability"]=>
              string(34) "Usually ships in 1-2 business days"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#320 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(2) "24"
                ["MaximumHours"]=>
                string(2) "48"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "0"
            }
          }
        }
      }
      [5]=>
      object(SimpleXMLElement)#378 (4) {
        ["ASIN"]=>
        string(10) "B007IJLGUY"
        ["DetailPageURL"]=>
        string(217) "http://www.amazon.com/Social-Media-Marketing-Publishers-ebook/dp/B007IJLGUY%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB007IJLGUY"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#319 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#321 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(227) "http://www.amazon.com/Social-Media-Marketing-Publishers-ebook/dp/tech-data/B007IJLGUY%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [1]=>
            object(SimpleXMLElement)#322 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3DB007IJLGUY%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [2]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3DB007IJLGUY%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [3]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3DB007IJLGUY%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [4]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/B007IJLGUY%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [5]=>
            object(SimpleXMLElement)#320 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/B007IJLGUY%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
            [6]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/B007IJLGUY%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB007IJLGUY"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#323 (16) {
          ["Author"]=>
          string(10) "Liz Murray"
          ["Binding"]=>
          string(14) "Kindle Edition"
          ["Format"]=>
          string(12) "Kindle eBook"
          ["IsAdultProduct"]=>
          string(1) "0"
          ["Label"]=>
          string(17) "LJinteractive.com"
          ["Languages"]=>
          object(SimpleXMLElement)#327 (1) {
            ["Language"]=>
            object(SimpleXMLElement)#320 (2) {
              ["Name"]=>
              string(7) "English"
              ["Type"]=>
              string(9) "Published"
            }
          }
          ["Manufacturer"]=>
          string(17) "LJinteractive.com"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(2) "56"
          ["ProductGroup"]=>
          string(6) "eBooks"
          ["ProductTypeName"]=>
          string(11) "ABIS_EBOOKS"
          ["PublicationDate"]=>
          string(10) "2012-03-07"
          ["Publisher"]=>
          string(17) "LJinteractive.com"
          ["ReleaseDate"]=>
          string(10) "2012-03-07"
          ["Studio"]=>
          string(17) "LJinteractive.com"
          ["Title"]=>
          string(37) "Social Media Marketing for Publishers"
        }
      }
      [6]=>
      object(SimpleXMLElement)#379 (4) {
        ["ASIN"]=>
        string(10) "B00BRYYBIU"
        ["DetailPageURL"]=>
        string(224) "http://www.amazon.com/Principles-Marketing-Achieving-Lifestyle-ebook/dp/B00BRYYBIU%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB00BRYYBIU"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#323 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(234) "http://www.amazon.com/Principles-Marketing-Achieving-Lifestyle-ebook/dp/tech-data/B00BRYYBIU%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [1]=>
            object(SimpleXMLElement)#320 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3DB00BRYYBIU%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [2]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3DB00BRYYBIU%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [3]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3DB00BRYYBIU%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [4]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/B00BRYYBIU%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [5]=>
            object(SimpleXMLElement)#322 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/B00BRYYBIU%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
            [6]=>
            object(SimpleXMLElement)#321 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/B00BRYYBIU%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3DB00BRYYBIU"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#319 (17) {
          ["Author"]=>
          string(14) "Hildred Berman"
          ["Binding"]=>
          string(14) "Kindle Edition"
          ["Edition"]=>
          string(1) "1"
          ["Format"]=>
          string(12) "Kindle eBook"
          ["IsAdultProduct"]=>
          string(1) "0"
          ["Label"]=>
          string(18) "Up-Chi Enterprises"
          ["Languages"]=>
          object(SimpleXMLElement)#321 (1) {
            ["Language"]=>
            object(SimpleXMLElement)#322 (2) {
              ["Name"]=>
              string(7) "English"
              ["Type"]=>
              string(9) "Published"
            }
          }
          ["Manufacturer"]=>
          string(18) "Up-Chi Enterprises"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(2) "21"
          ["ProductGroup"]=>
          string(6) "eBooks"
          ["ProductTypeName"]=>
          string(11) "ABIS_EBOOKS"
          ["PublicationDate"]=>
          string(10) "2013-03-09"
          ["Publisher"]=>
          string(18) "Up-Chi Enterprises"
          ["ReleaseDate"]=>
          string(10) "2013-03-09"
          ["Studio"]=>
          string(18) "Up-Chi Enterprises"
          ["Title"]=>
          string(136) "13 Principles for Success in Your Internet Marketing Online Business (Work From Home Secrets for Achieving the Internet Lifestyle Dream)"
        }
      }
      [7]=>
      object(SimpleXMLElement)#380 (6) {
        ["ASIN"]=>
        string(10) "0071762345"
        ["DetailPageURL"]=>
        string(222) "http://www.amazon.com/Likeable-Social-Media-Customers-Irresistible/dp/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0071762345"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#319 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(232) "http://www.amazon.com/Likeable-Social-Media-Customers-Irresistible/dp/tech-data/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [1]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D0071762345%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [2]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D0071762345%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [3]=>
            object(SimpleXMLElement)#320 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D0071762345%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [4]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [5]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
            [6]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#323 (23) {
          ["Author"]=>
          string(11) "Dave Kerpen"
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9780071762342"
          ["EANList"]=>
          object(SimpleXMLElement)#324 (1) {
            ["EANListElement"]=>
            string(13) "9780071762342"
          }
          ["Edition"]=>
          string(1) "1"
          ["ISBN"]=>
          string(10) "0071762345"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#4 (4) {
            ["Height"]=>
            string(3) "898"
            ["Length"]=>
            string(3) "618"
            ["Weight"]=>
            string(2) "83"
            ["Width"]=>
            string(2) "67"
          }
          ["Label"]=>
          string(11) "McGraw-Hill"
          ["Languages"]=>
          object(SimpleXMLElement)#327 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#325 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#328 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#383 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#320 (3) {
            ["Amount"]=>
            string(4) "2200"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$22.00"
          }
          ["Manufacturer"]=>
          string(11) "McGraw-Hill"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "272"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#329 (4) {
            ["Height"]=>
            string(2) "79"
            ["Length"]=>
            string(3) "890"
            ["Weight"]=>
            string(2) "88"
            ["Width"]=>
            string(3) "598"
          }
          ["PackageQuantity"]=>
          string(1) "1"
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2011-05-17"
          ["Publisher"]=>
          string(11) "McGraw-Hill"
          ["ReleaseDate"]=>
          string(10) "2011-06-07"
          ["SKU"]=>
          string(15) "HS9780071762342"
          ["Studio"]=>
          string(11) "McGraw-Hill"
          ["Title"]=>
          string(148) "Likeable Social Media: How to Delight Your Customers, Create an Irresistible Brand, and Be Generally Amazing on Facebook (And Other Social Networks)"
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#321 (6) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#329 (3) {
            ["Amount"]=>
            string(3) "999"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$9.99"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#320 (3) {
            ["Amount"]=>
            string(3) "733"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$7.33"
          }
          ["TotalNew"]=>
          string(2) "67"
          ["TotalUsed"]=>
          string(2) "46"
          ["TotalCollectible"]=>
          string(1) "0"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#322 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/0071762345%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D0071762345"
          ["Offer"]=>
          object(SimpleXMLElement)#320 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#329 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#327 (7) {
              ["OfferListingId"]=>
              string(164) "WHVgfjbGZ1tw8h0C7bR%2FBIqVskm94vf4kJ%2BdUeunstpcyy8t8QBH7yLITLOYd%2FCyV70rcDP4l9MIerbr7CzoqmEnesYqxhvbmhqy8YCgOvIrm6iQEs%2FZAVba03cZGXCcvjGAf5O7iKf6ZyWaCVaeWw%3D%3D"
              ["Price"]=>
              object(SimpleXMLElement)#4 (3) {
                ["Amount"]=>
                string(3) "999"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(5) "$9.99"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#324 (3) {
                ["Amount"]=>
                string(4) "1201"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$12.01"
              }
              ["PercentageSaved"]=>
              string(2) "55"
              ["Availability"]=>
              string(34) "Usually ships in 1-2 business days"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#383 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(2) "24"
                ["MaximumHours"]=>
                string(2) "48"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "0"
            }
          }
        }
      }
      [8]=>
      object(SimpleXMLElement)#381 (6) {
        ["ASIN"]=>
        string(10) "1600374700"
        ["DetailPageURL"]=>
        string(209) "http://www.amazon.com/How-Made-First-Million-Internet/dp/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D1600374700"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#322 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#320 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(219) "http://www.amazon.com/How-Made-First-Million-Internet/dp/tech-data/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [1]=>
            object(SimpleXMLElement)#327 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D1600374700%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [2]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D1600374700%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [3]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D1600374700%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [4]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [5]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
            [6]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#321 (20) {
          ["Author"]=>
          string(9) "Ewen Chia"
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9781600374708"
          ["EANList"]=>
          object(SimpleXMLElement)#328 (1) {
            ["EANListElement"]=>
            string(13) "9781600374708"
          }
          ["ISBN"]=>
          string(10) "1600374700"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#4 (4) {
            ["Height"]=>
            string(2) "99"
            ["Length"]=>
            string(3) "911"
            ["Weight"]=>
            string(3) "125"
            ["Width"]=>
            string(3) "603"
          }
          ["Label"]=>
          string(23) "Morgan James Publishing"
          ["Languages"]=>
          object(SimpleXMLElement)#324 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#327 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#320 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#325 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#383 (3) {
            ["Amount"]=>
            string(4) "1895"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$18.95"
          }
          ["Manufacturer"]=>
          string(23) "Morgan James Publishing"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "380"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#329 (4) {
            ["Height"]=>
            string(3) "100"
            ["Length"]=>
            string(3) "890"
            ["Weight"]=>
            string(3) "120"
            ["Width"]=>
            string(3) "600"
          }
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2009-01-01"
          ["Publisher"]=>
          string(23) "Morgan James Publishing"
          ["SKU"]=>
          string(36) "ACOMMP2x63901_usedlikenew_1600374700"
          ["Studio"]=>
          string(23) "Morgan James Publishing"
          ["Title"]=>
          string(141) "How I Made My First Million on the Internet and How You Can Too!: The Complete Insider's Guide to Making Millions with Your Internet Business"
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#323 (6) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#329 (3) {
            ["Amount"]=>
            string(3) "603"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$6.03"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#383 (3) {
            ["Amount"]=>
            string(3) "552"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(5) "$5.52"
          }
          ["TotalNew"]=>
          string(2) "43"
          ["TotalUsed"]=>
          string(2) "44"
          ["TotalCollectible"]=>
          string(1) "0"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#319 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/1600374700%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1600374700"
          ["Offer"]=>
          object(SimpleXMLElement)#383 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#329 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#324 (7) {
              ["OfferListingId"]=>
              string(174) "iO24hEISQR1NJdksrYHNAnooJ6eL3Jj4WVaWpbV1FG%2BsGREyT%2FoAQlQrfCDDhlc%2FkXytBH1hA%2FfjTKU56%2FsWYH%2B3jAKabrQypSxUXB89Hj5%2BovvfyxAwld%2F5f7nEte8Nrmlxl48VUR%2BMIpJYkfqRwg%3D%3D"
              ["Price"]=>
              object(SimpleXMLElement)#4 (3) {
                ["Amount"]=>
                string(3) "603"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(5) "$6.03"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#328 (3) {
                ["Amount"]=>
                string(4) "1292"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$12.92"
              }
              ["PercentageSaved"]=>
              string(2) "68"
              ["Availability"]=>
              string(34) "Usually ships in 1-2 business days"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#325 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(2) "24"
                ["MaximumHours"]=>
                string(2) "48"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "0"
            }
          }
        }
      }
      [9]=>
      object(SimpleXMLElement)#382 (6) {
        ["ASIN"]=>
        string(10) "1133625908"
        ["DetailPageURL"]=>
        string(227) "http://www.amazon.com/Internet-Marketing-Integrating-Offline-Strategies/dp/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D1133625908"
        ["ItemLinks"]=>
        object(SimpleXMLElement)#319 (1) {
          ["ItemLink"]=>
          array(7) {
            [0]=>
            object(SimpleXMLElement)#383 (2) {
              ["Description"]=>
              string(17) "Technical Details"
              ["URL"]=>
              string(237) "http://www.amazon.com/Internet-Marketing-Integrating-Offline-Strategies/dp/tech-data/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [1]=>
            object(SimpleXMLElement)#324 (2) {
              ["Description"]=>
              string(20) "Add To Baby Registry"
              ["URL"]=>
              string(216) "http://www.amazon.com/gp/registry/baby/add-item.html%3Fasin.0%3D1133625908%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [2]=>
            object(SimpleXMLElement)#329 (2) {
              ["Description"]=>
              string(23) "Add To Wedding Registry"
              ["URL"]=>
              string(219) "http://www.amazon.com/gp/registry/wedding/add-item.html%3Fasin.0%3D1133625908%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [3]=>
            object(SimpleXMLElement)#325 (2) {
              ["Description"]=>
              string(15) "Add To Wishlist"
              ["URL"]=>
              string(220) "http://www.amazon.com/gp/registry/wishlist/add-item.html%3Fasin.0%3D1133625908%26SubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [4]=>
            object(SimpleXMLElement)#328 (2) {
              ["Description"]=>
              string(13) "Tell A Friend"
              ["URL"]=>
              string(185) "http://www.amazon.com/gp/pdp/taf/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [5]=>
            object(SimpleXMLElement)#4 (2) {
              ["Description"]=>
              string(20) "All Customer Reviews"
              ["URL"]=>
              string(189) "http://www.amazon.com/review/product/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
            [6]=>
            object(SimpleXMLElement)#320 (2) {
              ["Description"]=>
              string(10) "All Offers"
              ["URL"]=>
              string(191) "http://www.amazon.com/gp/offer-listing/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
            }
          }
        }
        ["ItemAttributes"]=>
        object(SimpleXMLElement)#323 (24) {
          ["Author"]=>
          array(2) {
            [0]=>
            string(16) "Mary Lou Roberts"
            [1]=>
            string(11) "Debra Zahay"
          }
          ["Binding"]=>
          string(9) "Paperback"
          ["EAN"]=>
          string(13) "9781133625902"
          ["EANList"]=>
          object(SimpleXMLElement)#320 (1) {
            ["EANListElement"]=>
            string(13) "9781133625902"
          }
          ["Edition"]=>
          string(1) "3"
          ["Feature"]=>
          array(4) {
            [0]=>
            string(256) "Information Technology concepts easy to grasp: Students must understand the basics of the underlying technology that supports Internet marketing. This text makes rather complex IT concepts understandable to the student who has only the required MIS basics."
            [1]=>
            string(193) "Internet marketing is presented throughout as a global phenomenon: The Internet is a world without walls. Global material and examples are used throughout the text integrated by subject matter."
            [2]=>
            string(142) "Internet Exercises give students an opportunity to explore the topics and discussions in the chapter in the real-life setting of the Internet."
            [3]=>
            string(119) "Numerous screen captures from the Internet showcase real-world, and timely relative examples of concepts from the text."
          }
          ["ISBN"]=>
          string(10) "1133625908"
          ["IsEligibleForTradeIn"]=>
          string(1) "1"
          ["ItemDimensions"]=>
          object(SimpleXMLElement)#4 (4) {
            ["Height"]=>
            string(4) "1071"
            ["Length"]=>
            string(3) "831"
            ["Weight"]=>
            string(3) "224"
            ["Width"]=>
            string(2) "91"
          }
          ["Label"]=>
          string(25) "South-Western College Pub"
          ["Languages"]=>
          object(SimpleXMLElement)#328 (1) {
            ["Language"]=>
            array(3) {
              [0]=>
              object(SimpleXMLElement)#383 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(7) "Unknown"
              }
              [1]=>
              object(SimpleXMLElement)#327 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(17) "Original Language"
              }
              [2]=>
              object(SimpleXMLElement)#326 (2) {
                ["Name"]=>
                string(7) "English"
                ["Type"]=>
                string(9) "Published"
              }
            }
          }
          ["ListPrice"]=>
          object(SimpleXMLElement)#325 (3) {
            ["Amount"]=>
            string(5) "10095"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(7) "$100.95"
          }
          ["Manufacturer"]=>
          string(25) "South-Western College Pub"
          ["NumberOfItems"]=>
          string(1) "1"
          ["NumberOfPages"]=>
          string(3) "512"
          ["PackageDimensions"]=>
          object(SimpleXMLElement)#329 (4) {
            ["Height"]=>
            string(2) "90"
            ["Length"]=>
            string(4) "1070"
            ["Weight"]=>
            string(3) "215"
            ["Width"]=>
            string(3) "850"
          }
          ["ProductGroup"]=>
          string(4) "Book"
          ["ProductTypeName"]=>
          string(9) "ABIS_BOOK"
          ["PublicationDate"]=>
          string(10) "2012-03-28"
          ["Publisher"]=>
          string(25) "South-Western College Pub"
          ["SKU"]=>
          string(7) "O_14191"
          ["Studio"]=>
          string(25) "South-Western College Pub"
          ["Title"]=>
          string(61) "Internet Marketing: Integrating Online and Offline Strategies"
          ["TradeInValue"]=>
          object(SimpleXMLElement)#324 (3) {
            ["Amount"]=>
            string(4) "5011"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$50.11"
          }
        }
        ["OfferSummary"]=>
        object(SimpleXMLElement)#321 (6) {
          ["LowestNewPrice"]=>
          object(SimpleXMLElement)#324 (3) {
            ["Amount"]=>
            string(4) "7500"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$75.00"
          }
          ["LowestUsedPrice"]=>
          object(SimpleXMLElement)#329 (3) {
            ["Amount"]=>
            string(4) "6770"
            ["CurrencyCode"]=>
            string(3) "USD"
            ["FormattedPrice"]=>
            string(6) "$67.70"
          }
          ["TotalNew"]=>
          string(2) "23"
          ["TotalUsed"]=>
          string(2) "28"
          ["TotalCollectible"]=>
          string(1) "0"
          ["TotalRefurbished"]=>
          string(1) "0"
        }
        ["Offers"]=>
        object(SimpleXMLElement)#322 (4) {
          ["TotalOffers"]=>
          string(1) "1"
          ["TotalOfferPages"]=>
          string(1) "1"
          ["MoreOffersUrl"]=>
          string(191) "http://www.amazon.com/gp/offer-listing/1133625908%3FSubscriptionId%3D09786QDT6PYQFSRE3NG2%26tag%3Dthephpgrind-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D386001%26creativeASIN%3D1133625908"
          ["Offer"]=>
          object(SimpleXMLElement)#329 (2) {
            ["OfferAttributes"]=>
            object(SimpleXMLElement)#324 (1) {
              ["Condition"]=>
              string(3) "New"
            }
            ["OfferListing"]=>
            object(SimpleXMLElement)#325 (7) {
              ["OfferListingId"]=>
              string(130) "s1jAhdvhELFMWAFUclVWfolyWIH8S3uIob4RFTudE%2Bu0uW1%2BwV8BIg0dyAXlbEf11q9PE6HHRFdqKqhMMtkD1dLRhunXJ%2Bmb49QLDga6dL4HoGBdilCYyg%3D%3D"
              ["Price"]=>
              object(SimpleXMLElement)#328 (3) {
                ["Amount"]=>
                string(4) "8149"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$81.49"
              }
              ["AmountSaved"]=>
              object(SimpleXMLElement)#4 (3) {
                ["Amount"]=>
                string(4) "1946"
                ["CurrencyCode"]=>
                string(3) "USD"
                ["FormattedPrice"]=>
                string(6) "$19.46"
              }
              ["PercentageSaved"]=>
              string(2) "19"
              ["Availability"]=>
              string(25) "Usually ships in 24 hours"
              ["AvailabilityAttributes"]=>
              object(SimpleXMLElement)#320 (3) {
                ["AvailabilityType"]=>
                string(3) "now"
                ["MinimumHours"]=>
                string(1) "0"
                ["MaximumHours"]=>
                string(1) "0"
              }
              ["IsEligibleForSuperSaverShipping"]=>
              string(1) "1"
            }
          }
        }
      }
    }
  }
}

*/