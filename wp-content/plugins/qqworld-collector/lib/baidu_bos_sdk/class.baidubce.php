<?php
/*
* Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may not
* use this file except in compliance with the License. You may obtain a copy of
* the License at
*
* Http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations under
* the License.
*/

if (class_exists('Phar')) include_once __DIR__ . '/BaiduBce.phar';

use BaiduBce\Services\Lss\LssClient;
use BaiduBce\Services\Vod\VodClient;
use BaiduBce\Services\Bos\BosClient;
use BaiduBce\Services\Bos\CannedAcl;
use BaiduBce\Services\Bos\BosOptions;

use BaiduBce\BceClientConfigOptions;
use BaiduBce\Util\Time;
use BaiduBce\Util\MimeTypes;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Auth\SignOptions;


use BaiduBce\Log\LogFactory;

class BaiduBce {
	var $LssClient;
	var $VodClient;
	var $BosClient;

	public function __construct($BOS_CONFIG=null, $LSS_CONFIG=null, $VOD_CONFIG=null) {
		if ($LSS_CONFIG) $this->LssClient = new LssClient($LSS_CONFIG);
		if ($BOS_CONFIG) $this->BosClient = new BosClient($BOS_CONFIG);
		if ($VOD_CONFIG && $BOS_CONFIG) $this->VodClient = new VodClient($VOD_CONFIG, $BOS_CONFIG);
	}

	/************************ for lss ************************/
	/* --- Stream������ --- */
	// ��ѯ�ض�Domain�µ��ض�Stream
	public function getStream($doamin, $app, $stream) {
		return $this->LssClient->getStream($doamin, $app, $stream);
	}

	// ��ѯ�ض�Domain�µ�����Stream
	public function listStreams($doamin) {
		return $this->LssClient->listStreams($domain);
	}

	// ����ض�Domain�µ��ض�stream
	public function pauseStream($doamin, $app, $stream) {
		return $this->LssClient->pauseStream($doamin, $app, $stream);
	}

	// ����ض�Domain�µ��ض�Stream
	public function resumeStream($doamin, $app, $stream) {
		return $this->LssClient->resumeStream($doamin, $app, $stream);
	}

	/* --- ͳ�� --- */
	// ����ض�Domain�µ��ض�Stream
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
	);
	*/
	public function getDomainSummaryStatistics($params) {
		return $this->LssClient->getDomainSummaryStatistics($params);
	}

	// ��ѯ�ض�Domain���ض�Stream��ͳ������
	/*
	$params = array(
		"startDate" => "20160920",
		"endDate" => "20160921",
	);
	* or *
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
	);
	*/
	public function getStreamStatistics($doamin, $app, $stream='', $params='') {
		return $this->LssClient->getStreamStatistics($doamin, $app, $stream, $params);
	}
	// ��ѯ�ض�Domain������Stream��ͳ������
	/*
	public function getStreamStatistics($doamin, $params) {
		return $this->LssClient->getStreamStatistics($doamin, $params);
	}
	*/

	// ��ѯ����Domain��������
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getAllDomainTrafficStatistics($params) {
		return $this->LssClient->getAllDomainTrafficStatistics($params);
	}

	// ��ѯ�ض�Domain������
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getDomainTrafficStatistics($doamin, $params) {
		return $this->LssClient->getDomainTrafficStatistics($doamin, $params);
	}

	// ��ѯ����Domain���ܴ���
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getAllDomainBandwidthStatistics($params) {
		return $this->LssClient->getAllDomainBandwidthStatistics($params);
	}

	// ��ѯ�ض�Domain�Ĵ���
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getDomainBandwidthStatistics($doamin, $params) {
		return $this->LssClient->getDomainBandwidthStatistics($doamin, $params);
	}

	// ��ѯ����Domain����������
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getAllDomainPlayCountStatistics($params) {
		return $this->LssClient->getAllDomainPlayCountStatistics($params);
	}

	// ��ѯ����Domain����������
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
		"timeInterval" => "MID_TERM",
	);
	*/
	public function getDomainPlayCountStatistics($doamin, $params) {
		return $this->LssClient->getDomainPlayCountStatistics($doamin, $params);
	}

	//����/�ر�¼��
	//����û������Ựʱ������¼��ģ�壬��ô�Ựֱ�������л��Զ�����¼�ơ�
	//��������ʾ�����ڹرջỰ¼�ƣ�
	public function stopRecording($sessionId) {
		$this->LssClient->stopRecording($sessionId);
	}

	//����Ựû������¼��ģ�壬��ô���Բο��������뿪���Ự¼�ƣ�
	// ָ��Session ID �� ¼��ģ��
	public function startRecording($sessionId, $recording) {
		$this->LssClient->startRecording($sessionId, $recording);
	}

	//��ѯ�Ựʵʱֱ��Դ��Ϣ
	//����ֱ����streamingStatus = STREAMING�ĻỰ�����Բο���������ʵʱ��ȡ�Ựֱ��Դ��Ϣ��
	public function getSessionSourceInfo($sessionId) {
		$sourceInfo = $this->LssClient->getSessionSourceInfo($sessionId);
		return $sourceInfo;
	}

	// ��ȡ¼��ģ��
	public function getRecording($name) {
		$response = $this->LssClient->getRecording($name);
		return $response;
	}

	// ��ȡ¼��ģ��
	public function listRecordings() {
		$response = $this->LssClient->listRecordings();
		return $response->recordings;
	}

	/************************ for bos ************************/
	//����bucket
	public function createBucket($bucketName) {
		if(!$this->doesBucketExist($bucketName)){
			$this->BosClient->createBucket($bucketName);
		}
	}

	//���bucket�Ƿ����
	public function doesBucketExist($bucketName) {
		return $this->BosClient->doesBucketExist($bucketName);
	}

	//�鿴bucket�б�
	public function listObjects($bucketName, $options=array()) {
		$response = $this->BosClient->listObjects($bucketName, $options);
		return $response;
	}

	//ɾ��bucket
	public function deleteBucket($bucketName) {
		$this->BosClient->deleteBucket($bucketName);
	}

	// ��ȡobject, �����ļ���
	public function getObjectAsString($bucketName, $objectKey) {
		$response = $this->BosClient->getObjectAsString($bucketName, $objectKey);
		return $response;
	}

	// ֱ������object
	public function getObjectToFile($bucketName, $objectKey, $fileName) {
		$response = $this->BosClient->getObjectToFile($bucketName, $objectKey, $fileName);
		return $response;
	}

	// ��ȡObject��Meta��Ϣ
	public function getObjectMetadata($bucketName, $objectKey) {
		$response = $this->BosClient->getObjectMetadata($bucketName, $objectKey);
		return $response;
	}

	//ɾ��bucket�µ�ָ����Դ
	public function deleteObject($bucketName, $key) {
		$this->BosClient->deleteObject($bucketName, $key);
	}

	//����bucket�ķ���Ȩ��
	/*
	$my_acl = array(
		array(
			'grantee' => array(
				 array(
					 'id' => '7f34788d02a64a9c98f85600567d98a7',
				 ),
				 array(
					 'id' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
				 ),
			 ),
			 'permission' => array('FULL_CONTROL'),
		),
	);
	*/
	public function setBucketAcl($bucketName, $alc) {
		$this->BosClient->setBucketAcl($bucketName, $alc);
	}

	//�鿴bucket��Ȩ��
	public function getBucketAcl($bucketName) {
		$response = $this->BosClient->getBucketAcl($bucketName);
		return $response;
	}

	//�鿴bucket��������
	public function getBucketLocation($bucketName) {
		$response = $this->BosClient->getBucketLocation($bucketName);
		return $response;
	}

	/* �ϴ�����
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $data		������
	 */
	public function putObject($bucketName, $objectKey, $data, $meta=null) {
		if ($meta) $response = $this->BosClient->putObject($bucketName, $objectKey, $data, $meta);
		else $response = $this->BosClient->putObject($bucketName, $objectKey, $data);
		return $response;
	}

	/* ͨ���ļ��ϴ�����
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $filename	'./live.apk'
	 */
	public function putObjectFromFile($bucketName, $objectKey, $filename) {
		$response = $this->BosClient->putObjectFromFile($bucketName, $objectKey, $filename);
		return $response;
	}

	/* ͨ���ַ����ϴ����󣬼��ϴ���ƵBOS
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $string		'lkaskdjfkas f5saf6sa5f4sa64f9a8sd7f9as4fa6s4df65sadfk...'
	 */
	public function putObjectFromString($bucketName, $objectKey, $string) {
		$response = $this->BosClient->putObjectFromString($bucketName, $objectKey, $string);
		return $response;
	}

	// ��ȡobjecturl
	public function generatePreSignedUrl($bucketName, $objectKey, $signOptions) {
		$response = $this->BosClient->generatePreSignedUrl($bucketName, $objectKey, $signOptions);
		return $response;
	}
	
	// ����Object
	public function copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey) {
		$response = $this->BosClient->copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey);
		return $response;
	}

	/************************ for vod ************************/
	// ���ļ�������Դ
	public function createMediaFromFile($filepath, $title, $description) {
		$createMediaFromFileResult = $this->vodClient->createMediaFromFile($filepath, $title, $description);
		return $createMediaFromFileResult;
	}

	// ��BOS�е�����Դ
	public function createMediaFromBosObject($bucket, $boskey, $title, $description) {
		$createMediaFromBosObjectResult = $vodClient->createMediaFromBosObject($bucket, $boskey, $title, $description);
		$createMediaFromBosObjectResult;
	}

	// ��ѯý����Դ
	public function getMedia($mediaId) {
		$response = $vodClient->getMedia($mediaId);
		return $response;
	}
}