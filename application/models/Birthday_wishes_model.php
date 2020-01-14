<?php 
class Birthday_wishes_model extends CI_Model{
    public $wisher_id;
    public $user_id;
    public $message;
    public $is_deleted;
    public $is_inactive;

    public function getBirthdaysWishes($user_id,$message_type)
    {
        try {
            $this->db->select("bs_birthday_wishes.message");
            $this->db->select("bs_birthday_wishes.added_on");
            $this->db->select("bs_user.firstname");
            $this->db->select("bs_user.lastname");
            $this->db->from("bs_birthday_wishes");
            $this->db->where("bs_birthday_wishes.is_deleted",0);
            $this->db->where("bs_birthday_wishes.is_inactive",0);
            if($message_type=="inbox")
            {
                $this->db->join("bs_user","bs_birthday_wishes.wisher_id=bs_user.user_id");
                $this->db->where("bs_birthday_wishes.user_id",$user_id);
            }
            if($message_type=="outbox")
            {
                $this->db->join("bs_user","bs_birthday_wishes.user_id=bs_user.user_id");
                $this->db->where("bs_birthday_wishes.wisher_id",$user_id);
            }
            $result= $this->db->get()->result();
            //echo $this->db->last_query();die;
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function saveMessage($data)
    {
        try {
        $result = $this->db->insert('bs_birthday_wishes', $data);
        return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}





















?>