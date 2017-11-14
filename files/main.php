<?php
/* File_Find
Folders/File Finding
INPUT: Folder, List of extensions
OUTPUT: 4D Table
*/
function File_Find($folderlist, $ext) {
	$filelist = array();

	//Variables de la boucle
	$i = 0;
	$scanning=true;


	while($scanning==true)
	{
		if(empty($folderlist[$i])||!isset($folderlist[$i]))
		{
			$scanning=false;
		}
		else
		{
		$scan = scandir($folderlist[$i]);

			if(!empty($scan[0]))
			{
				$filelist[$i] = array();

				for($j=0;$j<(count($scan));$j++)
				{
					$words = explode(".",$scan[$j]);

					if(empty($words[1])) //Then it's a folder ( no extension )
					{
						if($scan[$j]==".."||$scan[$j]=="."||$scan[$j]=="") {
						//Don't add it !!
						}
						else {
							array_push($folderlist,$folderlist[$i].'/'.$scan[$j]); // Add new folders to list
						}
					}
					elseif(array_search($words[count($words)-1],$ext)!==false) { // Then it's an searched file.
						array_push($filelist[$i],$scan[$j]);
					}
				}
				if(!isset($filelist[$i][0])||empty($filelist[$i][0])) { //Delete folder if there's no searched file in
					array_splice($folderlist, $i, 1);
					array_splice($filelist, $i, 1);
					$i--;
				}

			}
		}

		$i++;
	}

	$result = array();

	$result['files'] = $filelist;
	$result['folder'] = $folderlist;

	return $result;
}