add_action( 'wpcf7_before_send_mail', 'friend_dynamic_attachments' );
function friend_dynamic_attachments($cf7)
{
	$propertyId = $_POST['propertyId'];
	$postData = get_post($propertyId);
	$slugPDF = $postData->post_name;
	$uploads = wp_upload_dir();
	$files = glob($uploads['basedir'].'/property_pdf_temp/*'); // get all file names
	foreach($files as $file){ // iterate files
	if(is_file($file)) {
		unlink($file); // delete file
	}
	}
     if($cf7->id==66350)
     {	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.century21-stmaarten.com/wp-admin/admin-ajax.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('propertyId' => $propertyId,'action' => 'pdfGenerator'),
		CURLOPT_HTTPHEADER => array(
		'Cookie: PHPSESSID=5630ba77960c1d4760cb5bf6dcf836dc'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$pdf_base64 = $response;
		$bin = base64_decode($pdf_base64, true);
		$pdfname = $slugPDF.'.pdf';
		file_put_contents($uploads['basedir'].'/property_pdf_temp/'.$pdfname, $bin);
		$pdfurl = $uploads['basedir'].'/property_pdf_temp/'.$pdfname;
		$mail = $cf7->prop('mail_2');
		$mail['attachments'] = str_replace('[myfieldname]', $pdfurl, $mail['attachments']);
		$form = $cf7->set_properties(array(
			"mail_2" => $mail
		));
	 	return $cf7;
     }
	 elseif($cf7->id==109)
     {	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.century21-stmaarten.com/wp-admin/admin-ajax.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('propertyId' => $propertyId,'action' => 'pdfGenerator'),
		CURLOPT_HTTPHEADER => array(
		'Cookie: PHPSESSID=5630ba77960c1d4760cb5bf6dcf836dc'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$pdf_base64 = $response;
		
		$bin = base64_decode($pdf_base64, true);
		$pdfname = $slugPDF.'.pdf';
		file_put_contents($uploads['basedir'].'/property_pdf_temp/'.$pdfname, $bin);
		$pdfurl = $uploads['basedir'].'/property_pdf_temp/'.$pdfname;
		
		$mail = $cf7->prop('mail_2');
		$mail['attachments'] = str_replace('[myfieldname]', $pdfurl, $mail['attachments']);
		$form = $cf7->set_properties(array(
			"mail_2" => $mail
		));
	 	return $cf7;
     }
}
