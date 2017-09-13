<?php
require  APPPATH .'third_party/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\Common\Aws;


class S3_model extends CI_Model
{ 
	//public $path_to_config= APPPATH.'third_party/config.php';
	public function __construct()
	{

	parent::__construct();
	$this->load->database();

	}
	public function create_bucket($bucket_name)
	{
		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');
		$client->createBucket(array('Bucket' => $bucket_name));
	}  

	public function listObjects($bucket_name)
	{
		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');
		$iterator = $client->getIterator('ListObjects', array(
		'Bucket' => $bucket_name
			));

		foreach ($iterator as $object) 
		{
			echo $object['Key'] . "\n";
		}
	}  

	public function create_object($bucket_name,$directory_name,$file_name,$file,$type)
	{
		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');
		try{
		$result = $client->putObject(array(
		'Bucket' => $bucket_name,
		'Key'    => $directory_name.'/'.$file_name,//Object name
		'SourceFile' => $file, //'/var/www/redriver/upload/default.jpg',
		'ACL'=> 'public-read',
		'ContentType' => $type
		));   

		}
		catch(Exception $e){
			echo $e;
		}
		// Access parts of the result object
		/*echo $result['Expiration'] . "a"."\n";
		echo $result['ServerSideEncryption'] ."b". "\n";
		echo $result['ETag'] . "c"."\n";
		echo $result['VersionId'] ."d". "\n";
		echo $result['RequestId'] . "e"."\n";

		*/// Get the URL the object can be downloaded from
		return $result['ObjectURL'] ;
	}

	public function delete_object()
	{

		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');

		$result = $client->deleteObject(array(
		// Bucket is required
		'Bucket' => 'bucket_name',
		// Key is required
		'Key' => 'object_name',
		));
	}
 

	public function if_object_exists($bucket_name,$key_name) 
	{
		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');		      
		try
		{
		  // Get the object
		  $result = $client->doesObjectExist($bucket_name,$key_name);
		  // Display the object in the browser
		 // header("Content-Type: {$result['ContentType']}");
		  return $result;

		} 
		catch (S3Exception $e) 
		{
			echo $e->getMessage() . "\n";
		}
	}


	public function get_object($bucket_name,$key_name) 
	{
		$aws = Aws::factory(APPPATH.'third_party/config1.php');
		$client = $aws->get('S3');		      
		try 
		{
		  // Get the object
		  $result = $client->getObject(array(
		      'Bucket' => $bucket_name,
		      'Key'    => $key_name
		  ));
		  // Display the object in the browser

		 	
		  header("Content-Type: {$result['ContentType']}");
		  echo $result['Body'];

		} 
		catch (S3Exception $e) 
		{
			echo $e->getMessage() . "\n";
		}
	}

}
?>
