<?php
session_start();
include_once("../db.inc.php");
$Sections = getAllSpliceSections();
$SecNameArr = array();
foreach($Sections AS $SectionID => $SecRec)
{
	$SecNameArr[strtolower($SecRec['section_name'])] = $SectionID;
}
$completeurl = "DFALRPJoints.kml";
// $completeurl = "Section_18.kml";
$xml = simplexml_load_file($completeurl);
$retArr = array();
$TopFolder = $xml->Document->Folder;
for ($i = 0; $i < sizeof($TopFolder); $i++)
{
	$SecondFolder = $TopFolder[$i]->Folder;
	for ($j = 0; $j < sizeof($SecondFolder); $j++)
	{
		$Lvl2 = (string)$SecondFolder[$j]->name;
		$SecID = (isset($SecNameArr[strtolower($Lvl2)])) ? $SecNameArr[strtolower($Lvl2)] : 0;
		if($SecID > 0)
		{
			if(!isset($retArr[$SecID]))
				$retArr[$SecID] = array();
			$ThirdFolder = $SecondFolder[$j]->Folder;
			for ($k = 0; $k < sizeof($ThirdFolder); $k++)
			{
				$Placemark = $ThirdFolder[$k]->Placemark;
				for ($l = 0; $l < sizeof($Placemark); $l++)
				{
					if($Placemark[$l]->Point->coordinates != '')
					{
						$Lvl3 = (string)$Placemark[$l]->name;
						$retArr[$SecID][$Lvl3] = (string)$Placemark[$l]->Point->coordinates;
					}
				}
			}
		}
	}
}
foreach($retArr AS $SecID => $SecRec)
{
	echo $SecID . "<br>\n";
	foreach($SecRec AS $Join => $Coords)
	{
		echo " - " . $Join . " : " . $Coords . "<Br>\n";
	}
}
?>