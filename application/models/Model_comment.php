<?php

class Model_comment extends CI_Model{

    //コメントを登録する
    public function registComment($projectID, $comment, $commentedUserID){
        $array = array(
            'projectID' => $projectID,
            'tmpPro' => $projectID,
            'comment' => $comment,
            'commentedUserID' => $commentedUserID
        );

        $this->db->insert('comment', $array);
    }

    //コメントを削除する
    public function deleteComment($commentID){
        $array = array(
            'commentID' => $commentID
        );

        $this->db->delete('comment', $array);
    }

    //コメントを取得する
    //projectIDに紐づけられた全てのコメントを結果として返す
    public function getComment($projectID){
        $query = $this->db->get_where('comment', array('projectID' => $projectID));
        return $query->result();
    }
}
