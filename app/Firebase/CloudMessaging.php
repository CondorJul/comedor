<?php 
namespace App\Firebase;

class CloudMessaging 
{
    public function sendGCM( $body){
		define( 'API_ACCESS_KEY', 'AAAAjZMMGdw:APA91bF7ShYknA2yW15YIoLyPltU3r21DmO9GDcqeyX3YbGQKrG9anDyRwnYxTTiIep8J69VRnanResfBocCtYAKTQ-we2OR61P634W6TGYjslOk8YulR5yowkfN258Rp-9XoeomHOO1' );

		$notification=array(
			'body' => $body , 
			'title' =>'UNDAC Comedor - Noticias',
			'sound'=>'default',
			'color'=>'#0065FF'

		);

		
		$fields = array
		(
			'to' => '/topics/all',
			'notification' => $notification
			
		
			
		);



		/*$fields = array
		(
			'to' => '/topics/all',
			'notification' => $notification,
			'android'=>[
		    	'notification'=>[
		            'sound'=>'default'
		            ]
		        ],
	        'apns'=>[
	            'payload'=>[
	                'sound'=>'default'
	            ]
	        ]
			
		);*/
		 
		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = \curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );  /*https://android.googleapis.com/gcm/send*/
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		return $result;
	}


	public function sendGCMToUser($to, $body){
		define( 'API_ACCESS_KEY', 'AAAAjZMMGdw:APA91bF7ShYknA2yW15YIoLyPltU3r21DmO9GDcqeyX3YbGQKrG9anDyRwnYxTTiIep8J69VRnanResfBocCtYAKTQ-we2OR61P634W6TGYjslOk8YulR5yowkfN258Rp-9XoeomHOO1' );

		$notification=array(
			'body' => $body , 
			'title' =>'UNDAC Comedor - Noticias',
			'sound'=>'default',
			'color'=>'#0065FF'
		);

		$fields = array
		(
			'to' => $to,
			'notification' => $notification,
		);

		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = \curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );  /*https://android.googleapis.com/gcm/send*/
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		echo $result;
		//return $result;
	}

	public function logoutUser( $body){
		define( 'API_ACCESS_KEY', 'AAAAjZMMGdw:APA91bF7ShYknA2yW15YIoLyPltU3r21DmO9GDcqeyX3YbGQKrG9anDyRwnYxTTiIep8J69VRnanResfBocCtYAKTQ-we2OR61P634W6TGYjslOk8YulR5yowkfN258Rp-9XoeomHOO1' );

		$notification=array(
			'body' => $body , 
			'title' =>'UNDAC Comedor - Noticias',
			'sound'=>'default',
			'color'=>'#0065FF'

		);

		$data=array(
			'code' =>'2545'
		);

		
		$fields = array
		(
			'to' => 'QHRLU:APA91bFhMiOog0VvbmA81YvJVpFFjBtDwSIprlgvRWZjbl3oOB4LeRmoL6fQ7oncYGSJ4yeVkMgzBkRTNjGhl55iJ6xUwXvbDVIO3uRHw6d9WSVw7RzEaxhf4xPh_nOGahQbKsW_i4TI',
			'notification' => $notification,
			'data' => $data
		);

		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = \curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );  /*https://android.googleapis.com/gcm/send*/
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		return $result;
	}
}