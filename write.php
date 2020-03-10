<?php


if($_POST[img]){

      $output_file = 'img_'.time().'.jpg';

      base64_to_jpeg($_POST[img], $output_file);
echo $output_file;
}else{


$stuff = str_replace("\"", "'", $_POST[x] );
$text = preg_replace("/\r|\n/", "", $stuff);

$content = '{"html":"'. $text.'"}';
$file = __DIR__."/files/".$_POST[id].".json";
$Saved_File = fopen($file, 'w');
fwrite($Saved_File, $content);
fclose($Saved_File);

}


function base64_to_jpeg($base64_string, $output_file) {
  // open the output file for writing
  $ifp = fopen( __DIR__."/files/".$output_file, 'wb' );

  // split the string on commas
  // $data[ 0 ] == "data:image/png;base64"
  // $data[ 1 ] == <actual base64 string>
  $data = explode( ',', $base64_string );

  // we could add validation here with ensuring count( $data ) > 1
  fwrite( $ifp, base64_decode( $data[ 1 ] ) );

  // clean up the file resource
  fclose( $ifp );

  return $output_file;
}
