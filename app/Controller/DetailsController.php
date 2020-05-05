<?php namespace App\Controller;

use Core\Controller;
use App\Model\DetailModel as Detail;
use App\Model\HistoryModel as History;

class DetailsController extends Controller
{
    private $detail;

    public function store()
    {
        $response = [];
        $data = $_POST;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (strpos($key, Detail::PREFIX_NOTES) !== false) {
                    $history_id = substr($key, strpos($key, "-") + 1); 
                    $this->detail = new Detail();
                    $this->detail->setcontact_id($data['contact']);
                    $this->detail->setHistory_creator_id($history_id);
                    if (isset($data['sent' . '-' .$history_id]) && $data['sent' . '-' .$history_id] == '1') {
                        $sent = 1;
                    }else{
                        $sent = 0;
                    } 
                    $this->detail->setSent($sent);
                    if (isset($data['response' . '-' .$history_id]) && $data['response' . '-' .$history_id] == '1') {
                        $response_detail = 1;
                    }else{
                        $response_detail = 0;
                    }
                    $this->detail->setResponse($response_detail);
                    $this->detail->setNotes($data['notes' . '-' .$history_id]);
                    $is_an_update = $history_id . '-' .Detail::PREFIX_UPDATE;
                    if (isset($data[$is_an_update]) !== false) {
                        $this->detail->save($data[$is_an_update]);

                    }else{
                        $this->detail->save(); 

                    }    
                }
            }
            $response['success'] = Detail::UPDATED;
            echo json_encode($response);
        }else{
            $response['fail'] = 'Update could not be complete, please refresh the page';
        }    
    }
}