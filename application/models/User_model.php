<?php
class User_model extends CI_Model
{
    public $firstname;
    public $user_id;
    public $dob;

    public function getUserData($user_id=NULL)
    {
        try {
            $this->db->select('bs_user.*');
            $this->db->from('bs_user');
            if($user_id)
            {
                $this->db->where("bs_user.user_id",$user_id);
            }
            $this->db->where("bs_user.is_deleted",0);
            $this->db->where("bs_user.is_inactive",0);
            $this->db->where("bs_user.is_verified","yes");
            $response = $this->db->get();
            $result=$response->row();
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function getFriendList($user_id=NULL)
    {
        try {
            $this->db->select('bs_user.*');
            $this->db->from('bs_user');
            if($user_id)
            {
                $this->db->where("bs_user.user_id !=",$user_id);
            }
            $this->db->where("bs_user.is_deleted",0);
            $this->db->where("bs_user.is_inactive",0);
            $this->db->where("bs_user.is_verified","yes");
            $response = $this->db->get();
            $result=$response->result();
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function saveData($data,$user_id)
    {
        try {
            $this->db->where('user_id', $user_id);
            $result= $this->db->update('bs_user', $data);
            //echo $this->db->last_query();die;
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
