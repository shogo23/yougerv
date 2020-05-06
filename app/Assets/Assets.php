<?php namespace App\Assets;

class Assets extends AssetsBase {

    //Path to profile pictures and thumbnail.
    private $pathtopicture = './img/users/pictures/';
    private $pathtothumbnail = './img/users/thumbs/';

    public function getUserId($username) {
        $builder = $this->db->table('users');
        $builder->select('id');
        $builder->where('username', $this->session->get('username'));
        $query = $builder->get();
        $id = 0;

        foreach ($query->getResult() as $user) {
            $id += $user->id;
        }

        return $id;
    }

    public function randomstr($length = 15) {
        return substr(sha1(rand()), 0, $length);
    }

    public function hasSession() {
        if ($this->session->get('username')) {
            return true;
        }

        return false;
    }

    public function getSession($str) {
        return $this->session->get($str);
    }

    public function setSession(array $str) {
        $this->session->set($str);
    }

    public function sessionDestroy() {
        $this->session->destroy();
    }

    public function getDateTime() {
        return $this->_datetime();
    }

    public function imageUploadResize($tmp, $filename, $filetype) {
        switch ($filetype) {
            case 'image/jpeg':
                list($width, $height) = getimagesize($tmp);
                $image = imagecreatetruecolor(250, 250);
                $image_src = imagecreatefromjpeg($tmp);
                imagecopyresampled($image, $image_src, 0, 0, 0, 0, 250, 250, $width, $height);
                imagejpeg($image, $this->pathtopicture . $filename);

                $thumb_image = imagecreatetruecolor(70, 70);
                $thumb_image_src = imagecreatefromjpeg($tmp);
                imagecopyresampled($thumb_image, $thumb_image_src, 0, 0, 0, 0, 70, 70, $width, $height);
                imagejpeg($thumb_image, $this->pathtothumbnail . $filename);
            break;

            case 'image/png':
                list($width, $height) = getimagesize($tmp);
                $image = imagecreatetruecolor(250, 250);
                $image_src = imagecreatefrompng($tmp);
                imagecopyresampled($image, $image_src, 0, 0, 0, 0, 250, 250, $width, $height);
                imagejpeg($image, $this->pathtopicture . $filename);

                $thumb_image = imagecreatetruecolor(70, 70);
                $thumb_image_src = imagecreatefrompng($tmp);
                imagecopyresampled($thumb_image, $thumb_image_src, 0, 0, 0, 0, 70, 70, $width, $height);
                imagejpeg($thumb_image, $this->pathtothumbnail . $filename);
            break;
        }

        $user_id = $this->getUserId($this->session->get('username'));
        $picture = '';

        /*
        *   Check if userpicture is already exists.
        */
        $builder = $this->db->table('users');
        $builder->select('picture');
        $builder->where('id', $user_id);
        $query = $builder->get();

        foreach ($query->getResult() as $user) {
            $picture = $user->picture;
        }

        //Delete Picture file if exists.
        if ($picture !== NULL && $picture !== '') {
            $this->removeImage($this->pathtopicture . $picture);
            $this->removeImage($this->pathtothumbnail . $picture);
        }

        //Update User's Record.
        $builder = $this->db->table('users');
        $builder->set([
            'picture' => $filename,
            'updated_at' => $this->_datetime()
        ]);
        $builder->where('id', $user_id);
        $builder->update();

        return $filename;
    }

    public function deletePictures($user_id) {
        //Get User's Picture filename.
        $builder = $this->db->table('users');
        $builder->select('picture');
        $builder->where('id', $user_id);
        $query = $builder->get();
        $picture = '';

        foreach ($query->getResult() as $user) {
            $picture = $user->picture;
        }

        //Delete Picture Files.
        $this->removeImage($this->pathtopicture . $picture);
        $this->removeImage($this->pathtothumbnail . $picture);

        //Update database record.
        $builder = $this->db->table('users');
        $builder->set('picture', NULL);
        $builder->where('id', $user_id);
        $builder->update();

        return true;
    }
}