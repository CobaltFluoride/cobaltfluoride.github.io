<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");

//****** This should be setting the timeout to 60 minutes
ini_set("max_execution_time",3600); 

//****** Change this next folder name to what ever folder you want to import
$start_dir = "./upload/drywood/new/";
//$start_dir = "/home/adelp634/public_html/upload/drywood/new/";

//****** Change this next fields to the categories that you want - The Category Name must be exactly the same as the Category or it will be blank
$cat1 = "Matt Drywood";
$cat2 = "";
$cat3 = "";
$cat4 = "";
$cat5 = "";

//****** Change this field - used as a header for each title
$title = "";

$db1 = new clsDBAdelphosweb();
$category1_id = CCDLookup("category_id","web_categories","category_name='" . $cat1 . "'",$db1);
if ($category1_id == null) { $category1_id = 0; }
$category2_id = CCDLookup("category_id","web_categories","category_name='" . $cat2 . "'",$db1);
if ($category2_id == null) { $category2_id = 0; }
$category3_id = CCDLookup("category_id","web_categories","category_name='" . $cat3 . "'",$db1);
if ($category3_id == null) { $category3_id = 0; }
$category4_id = CCDLookup("category_id","web_categories","category_name='" . $cat4 . "'",$db1);
if ($category4_id == null) { $category4_id = 0; }
$category5_id = CCDLookup("category_id","web_categories","category_name='" . $cat5 . "'",$db1);
if ($category5_id == null) { $category5_id = 0; }

if ($handle = opendir($start_dir))
 {
    $index = 0;
		while (false !== ($OldFileName = readdir($handle)))
		{
	        if ($OldFileName != "." && $OldFileName != "..")
			{
	 			$index += 1;
				$search = array("/[[:space:]]/","/\\\\'/");
				$replace = array("_","");
				$NewFileName = preg_replace($search,$replace,$OldFileName);
				$Old = $start_dir . $OldFileName;
				$d = date("YmdHis");
				$New = "./docs/" . $d . $index . "." . $NewFileName;
				
				$rt = copy($Old,$New);
				if ($rt)
				{
					$SQL = "INSERT INTO web_docs (doc_desc_name, doc_name, category1_id, category2_id, category3_id, category4_id, category5_id, approved) VALUES('" . $title . ": " . $NewFileName . "','" . $d . $index . "." . $NewFileName . "'," . $category1_id . "," . $category2_id . "," . $category3_id . "," . $category4_id . "," . $category5_id . ",1)";
					$res = $db1->query($SQL);
					if(!$res)
					{
						echo "Query failed! Reason: "  + mysql_error();
						$db1->close();
						die();
					}
				}
				$db1->close();
			}
     	}
    	closedir($handle);
 }
 header("Location: https://www.adelphosweb.com/start.php"); /* Redirect browser */  
?>
