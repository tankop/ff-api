<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class Index extends MasterController
{

    const API_BASE_URL = 'http://dev03.swisshalley.com';
    const API_KEY = 'beugro';

    public function __construct()
    {
        $this->load_models[] = 'Hotel';
        $this->load_models[] = 'TripadvisorData';
        $this->load_models[] = 'RoomPacks';
        parent::__construct();
    }

    public function index()
    {
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "http://dev03.swisshalley.com/api/NameSearch",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "text=asdasd&apiKey=beugro",
//            CURLOPT_HTTPHEADER => array(
//                "Content-Type: application/x-www-form-urlencoded"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
//        echo $response;
//
//        die;
        $this->build('Index');
    }

    public function getSettlements()
    {
        if ($this->isAjax()) {
            $post = $this->input->post();
            if (isset($post['settlement']) && !empty($post['settlement'])) {
                $params = [
                    'apiKey' => self::API_KEY,
                    'text' => $post['settlement']
                ];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => self::API_BASE_URL . "/api/NameSearch",
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($params),
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $json_array = json_decode($response, true);
                $json_array['csrfName'] = $this->security->get_csrf_token_name();
                $json_array['csrfHash'] = $this->security->get_csrf_hash();
                echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
                return true;
            }
        }
    }

    public function getHotels()
    {
        $csrf = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
        ];
        if ($this->isAjax()) {
            $post = $this->input->post();
            if (isset($post['search_id'])) {
                $params = [
                    'apiKey' => self::API_KEY,
                    'id' => $post['search_id'],
                    'from' => date('Y-m-d', strtotime('+1 day', time())),
                    'to' => date('Y-m-d', strtotime('+3 day', time())),
                    'lang' => 'en',
                    'client_nationality' => 'hu',
                    'roomDatas' => '[{"parentCount":2,"childCount":0,"childrenAges":[]}]'
                ];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => self::API_BASE_URL . "/api/HotelSearch",
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($params),
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/x-www-form-urlencoded"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $json_array = json_decode($response, true);
                if (isset($json_array['result']) && !empty($json_array['result'])) {
                    foreach ($json_array['result'] as $hotel_id => $source) {
                        $hotel = HotelModel::get();
                        foreach ($source as $hotel_data) {
                            $hotel_data[HotelModel::NAME_SEARCH_ID] = $post['search_id'];
                            $hotel->fromArray($hotel_data);
                            $hotel->save();
                            if (isset($hotel_data['tripadvisor']) && !empty($hotel_data['tripadvisor'])) {
                                $tripadvisor = TripadvisorDataModel::get();
                                $tripadvisor->fromArray($hotel_data['tripadvisor']);
                                $tripadvisor->save();
                            }
                            if (isset($hotel_data['roompacks']) && !empty($hotel_data['roompacks'])) {
                                foreach ($hotel_data['roompacks'] as $roompack) {
                                    $roompack_object = RoomPacksModel::get();
                                    $roompack_object->fromArray($roompack);
                                    $roompack_object->save();
                                }
                            }
                        }
                    }
                }
                $hotels = HotelModel::get()->getAll(10, 0, [HotelModel::NAME_SEARCH_ID => $post['search_id']]);
                echo json_encode($csrf + [
                        'status' => true,
                        'response_html' => $this->load->view('HotelList', ['hotels' => $hotels, 'search_id' => $post['search_id']], true)
                    ], JSON_UNESCAPED_UNICODE);
                return true;
            }
        }
        echo json_encode($csrf + ['status' => false], JSON_UNESCAPED_UNICODE);
        return true;
    }

    public function orderhotels(){
        $csrf = [
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash(),
        ];
        if ($this->isAjax()) {
            $post = $this->input->post();
            if (isset($post['search_id']) && isset($post['order'])) {
                $hotels = HotelModel::get()->getAll(10, 0, [HotelModel::NAME_SEARCH_ID => $post['search_id']],[], [$post['order'] => 'ASC']);
                echo json_encode($csrf + [
                        'status' => true,
                        'response_html' => $this->load->view('HotelList', ['hotels' => $hotels, 'search_id' => $post['search_id']], true)
                    ], JSON_UNESCAPED_UNICODE);
                return true;
            }
        }
        echo json_encode($csrf + ['status' => false], JSON_UNESCAPED_UNICODE);
        return true;
    }
}
