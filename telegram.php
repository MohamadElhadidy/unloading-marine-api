<?php


    // unloading  "-1001799028920"
    // ceo  "-1001530156095"

                require "encrypt.php";

    function send($vessel_id, $message, $receiver,$url){

              $apiToken = '5573963807:AAFLiZ39CvpwXvRDYq06GcWAzSaDPyj1UsA';
                
                require "config.php";


                $result1 = mysqli_query($con,"SELECT *  FROM vessels_log   where vessel_id = '$vessel_id' AND done = 0 ");
                $row = mysqli_fetch_assoc($result1);
                $vessel_name = $row['name']; 
                $vessel_client = $row['client']; 
                $vessel_type = $row['type']; 
                $vessel_qnt = $row['qnt']; 
                $vessel_quay = $row['quay']; 
                $token = $row['token']; 

                $vessel_phones = $row['phones']; 

                if($receiver == 'unloading') $chat_id =   "-1001799028920";
                if($receiver == 'ceo') $chat_id =   "-1001530156095";

                if($url == false){
                      $message.= "\r\n";
                      $message.= 'اسم الباخرة: *'.$vessel_name.'*';
                      if($receiver  != 'unloading'){
                        $message.= "\r\n";
                        $message.= ' العميل : *'.$vessel_client.'*';
                      }
	                    $message.= "\r\n";
	                    $message.= ' الصنف : *'.$vessel_type.'*';
	                    $message.= "\r\n";
	                    $message.= ' الكمية : '.$vessel_qnt;
	                    $message.= "\r\n";
	                    $message.= ' الرصيف : '.$vessel_quay;
                }elseif ($receiver  != 'client') {
                       $message.= 'http://marine-co.live/tu/?'.$token;
                }
                if($receiver  == 'client'){
                  echo '1';
                    // if($vessel_phones != ''){
                    //     $phones = explode(',', urldecode($vessel_phones));
                    //     // $message.= "\r\n";
                    //     // $message.= 'http://marine-co.live/wa/unloading/client/?'.$idencode;
                    //     for($i=0;$i<count($phones);$i++){
                    //     $data = [
	                  //         "phone" => $phones[$i],
                    //         "body" => $message
                    //         ];
                    //     $json = json_encode($data); 
                    //     $url = 'https://api.chat-api.com/'.$instance.'/message?token='.$token;
                    //     $options = stream_context_create(['http' => [
                    //         'method'  => 'POST',
                    //         'header'  => 'Content-type: application/json',
                    //         'content' => $json
                    //         ]
                    //     ]);
                    //     file_get_contents($url, false, $options);
                    //     }
                    //   }
                }else {
                    $data = [
	                      "chat_id" => $chat_id,
                          'text' => $message, 
                          'parse_mode' => 'markdown'
                    ];

                    file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
                }            
    }

      
          
            
?>