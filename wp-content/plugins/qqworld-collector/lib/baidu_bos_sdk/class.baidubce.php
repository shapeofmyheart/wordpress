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
	/* --- Stream流管理 --- */
	// 查询特定Domain下的特定Stream
	public function getStream($doamin, $app, $stream) {
		return $this->LssClient->getStream($doamin, $app, $stream);
	}

	// 查询特定Domain下的所有Stream
	public function listStreams($doamin) {
		return $this->LssClient->listStreams($domain);
	}

	// 封禁特定Domain下的特定stream
	public function pauseStream($doamin, $app, $stream) {
		return $this->LssClient->pauseStream($doamin, $app, $stream);
	}

	// 解禁特定Domain下的特定Stream
	public function resumeStream($doamin, $app, $stream) {
		return $this->LssClient->resumeStream($doamin, $app, $stream);
	}

	/* --- 统计 --- */
	// 解禁特定Domain下的特定Stream
	/*
	$params = array(
		"startTime" => "2016-09-20T08:00:00Z",
		"endTime" => "2016-09-21T08:00:00Z",
	);
	*/
	public function getDomainSummaryStatistics($params) {
		return $this->LssClient->getDomainSummaryStatistics($params);
	}

	// 查询特定Domain下特定Stream的统计数据
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
	// 查询特定Domain下所有Stream的统计数据
	/*
	public function getStreamStatistics($doamin, $params) {
		return $this->LssClient->getStreamStatistics($doamin, $params);
	}
	*/

	// 查询所有Domain的总流量
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

	// 查询特定Domain的流量
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

	// 查询所有Domain的总带宽
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

	// 查询特定Domain的带宽
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

	// 查询所有Domain的总请求数
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

	// 查询所有Domain的总请求数
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

	//开启/关闭录制
	//如果用户创建会话时配置了录制模板，那么会话直播过程中会自动进行录制。
	//下述代码示例用于关闭会话录制：
	public function stopRecording($sessionId) {
		$this->LssClient->stopRecording($sessionId);
	}

	//如果会话没有配置录制模板，那么可以参考下述代码开启会话录制：
	// 指定Session ID 和 录制模板
	public function startRecording($sessionId, $recording) {
		$this->LssClient->startRecording($sessionId, $recording);
	}

	//查询会话实时直播源信息
	//处于直播中streamingStatus = STREAMING的会话，可以参考下述代码实时获取会话直播源信息：
	public function getSessionSourceInfo($sessionId) {
		$sourceInfo = $this->LssClient->getSessionSourceInfo($sessionId);
		return $sourceInfo;
	}

	// 获取录制模板
	public function getRecording($name) {
		$response = $this->LssClient->getRecording($name);
		return $response;
	}

	// 获取录制模板
	public function listRecordings() {
		$response = $this->LssClient->listRecordings();
		return $response->recordings;
	}

	/************************ for bos ************************/
	//创建bucket
	public function createBucket($bucketName) {
		if(!$this->doesBucketExist($bucketName)){
			$this->BosClient->createBucket($bucketName);
		}
	}

	//检测bucket是否存在
	public function doesBucketExist($bucketName) {
		return $this->BosClient->doesBucketExist($bucketName);
	}

	//查看bucket列表
	public function listObjects($bucketName, $options=array()) {
		$response = $this->BosClient->listObjects($bucketName, $options);
		return $response;
	}

	//删除bucket
	public function deleteBucket($bucketName) {
		$this->BosClient->deleteBucket($bucketName);
	}

	// 获取object, 返回文件流
	public function getObjectAsString($bucketName, $objectKey) {
		$response = $this->BosClient->getObjectAsString($bucketName, $objectKey);
		return $response;
	}

	// 直接下载object
	public function getObjectToFile($bucketName, $objectKey, $fileName) {
		$response = $this->BosClient->getObjectToFile($bucketName, $objectKey, $fileName);
		return $response;
	}

	// 获取Object的Meta信息
	public function getObjectMetadata($bucketName, $objectKey) {
		$response = $this->BosClient->getObjectMetadata($bucketName, $objectKey);
		return $response;
	}

	//删除bucket下的指定资源
	public function deleteObject($bucketName, $key) {
		$this->BosClient->deleteObject($bucketName, $key);
	}

	//设置bucket的访问权限
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

	//查看bucket的权限
	public function getBucketAcl($bucketName) {
		$response = $this->BosClient->getBucketAcl($bucketName);
		return $response;
	}

	//查看bucket所属区域
	public function getBucketLocation($bucketName) {
		$response = $this->BosClient->getBucketLocation($bucketName);
		return $response;
	}

	/* 上传对象
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $data		流对象
	 */
	public function putObject($bucketName, $objectKey, $data, $meta=null) {
		if ($meta) $response = $this->BosClient->putObject($bucketName, $objectKey, $data, $meta);
		else $response = $this->BosClient->putObject($bucketName, $objectKey, $data);
		return $response;
	}

	/* 通过文件上传对象
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $filename	'./live.apk'
	 */
	public function putObjectFromFile($bucketName, $objectKey, $filename) {
		$response = $this->BosClient->putObjectFromFile($bucketName, $objectKey, $filename);
		return $response;
	}

	/* 通过字符串上传对象，即上传低频BOS
	 *
	 *	$bucketName	'live-siruiyun-app'
	 *  $objectKey	'/1.0/live.apk'
	 *  $string		'lkaskdjfkas f5saf6sa5f4sa64f9a8sd7f9as4fa6s4df65sadfk...'
	 */
	public function putObjectFromString($bucketName, $objectKey, $string) {
		$response = $this->BosClient->putObjectFromString($bucketName, $objectKey, $string);
		return $response;
	}

	// 获取objecturl
	public function generatePreSignedUrl($bucketName, $objectKey, $signOptions) {
		$response = $this->BosClient->generatePreSignedUrl($bucketName, $objectKey, $signOptions);
		return $response;
	}
	
	// 拷贝Object
	public function copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey) {
		$response = $this->BosClient->copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey);
		return $response;
	}

	/************************ for vod ************************/
	// 从文件创建资源
	public function createMediaFromFile($filepath, $title, $description) {
		$createMediaFromFileResult = $this->vodClient->createMediaFromFile($filepath, $title, $description);
		return $createMediaFromFileResult;
	}

	// 从BOS中导入资源
	public function createMediaFromBosObject($bucket, $boskey, $title, $description) {
		$createMediaFromBosObjectResult = $vodClient->createMediaFromBosObject($bucket, $boskey, $title, $description);
		$createMediaFromBosObjectResult;
	}

	// 查询媒体资源
	public function getMedia($mediaId) {
		$response = $vodClient->getMedia($mediaId);
		return $response;
	}
}