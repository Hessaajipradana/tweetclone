<?php

namespace App\Controllers;

use \App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {        
        return view('auth_login');
    }

    public function register()
    {
        return view('auth_register');
    }

    public function addUser()
    {
        $userModel = new UserModel();

        if($this->validate($userModel->rules)){
            $result = $userModel->addUser($this->request->getPost());
            $sess = session();
            $sess->set('currentuser', ['username' => $result[0], 'userid'   => $result[1]]);
            return redirect()->to('/');
        } else {
            $data['validation'] = $this->validator;
            $data['input'] = $this->request->getPost();
            return view('auth_register', $data);
        }
    }

    public function login()
    {   
        $sess = session();
        $userMdl = new UserModel();
        
        if($this->validate($userMdl->loginRules)){
            $result = $userMdl->login(
                    $this->request->getPost('username'), 
                    $this->request->getPost('password')
                );
            if($result){
                $sess->set('currentuser', 
                    ['username' => $result[0], 'userid' => $result[1]]);
                return redirect()->to('/');
            } else {
                $sess->setFlashdata('login_error', 
                    'Kombinasi Username &amp; Password tidak ditemukan');
                return redirect()->to('/auth');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('auth_login', $data);
        }
    }


    //reset password
    public function resetPassword()
{
    $sess = session();
    $currentUser = $sess->get('currentuser');
    if (!$currentUser) {
        // Jika pengguna belum login, redirect ke halaman login atau halaman lain yang sesuai
        return redirect()->to('/auth/login');
    }

    // Mengambil data pengguna dari database berdasarkan ID pengguna
    $userId = $currentUser['userid'];
    $userModel = new UserModel();
    $userData = $userModel->find($userId); // Menggunakan fungsi find() untuk mengambil data pengguna

    if (!$userData) {
        // Jika data pengguna tidak ditemukan, lakukan penanganan sesuai kebutuhan Anda
        return redirect()->to('/auth/login');
    }

    if ($this->request->getMethod() === 'post') {
        // Jika form di-submit, lakukan validasi data yang diinput
        if ($this->validate([
            'password' => 'required|min_length[8]'
        ])) {
            // Jika validasi berhasil, perbarui data pengguna
            $newPassword = $this->request->getPost('password');

            if (!is_string($newPassword)) {
                // Jika tipe data bukan string, mungkin ada masalah dengan data yang diterima.
                // Tambahkan pesan kesalahan atau lakukan penanganan sesuai kebutuhan.
                return redirect()->to('/resetPassword')->with('error', 'Password tidak valid.');
            }
            
            // Hash password baru
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updatedData = [
                'password' => $hashedPassword
            ];

            $userModel->update($userId, $updatedData); // Menggunakan fungsi update() untuk memperbarui data pengguna

            // Redirect ke halaman profil dengan pesan sukses atau lakukan penanganan lain yang sesuai kebutuhan
            return redirect()->to('/editProfile')->with('success', 'Password berhasil diubah.');
        } else {
            // Jika validasi gagal, tampilkan pesan error dan kembalikan form dengan data yang telah diinput
            $data['validation'] = $this->validator;
            $data['user'] = $userData;
            return view('resetPassword', $data);
        }
    }

    // Memuat halaman profil dengan data pengguna
    $data['user'] = $userData;
    return view('resetPassword', $data);
}


    public function logout()
    {
        $sess = session();
        $sess->remove('currentuser');
        $sess->setFlashdata('logout', 'success');
        return redirect()->to('/auth');
    }

    // Kontroler profile edit
    public function profile()
    {
        // Memastikan pengguna telah login
        $sess = session();
        $currentUser = $sess->get('currentuser');
        if (!$currentUser) {
            // Jika pengguna belum login, redirect ke halaman login atau halaman lain yang sesuai
            return redirect()->to('/auth/login');
        }

        // Mengambil data pengguna dari database berdasarkan ID pengguna
        $userId = $currentUser['userid'];
        $userModel = new UserModel();
        $userData = $userModel->find($userId); // Menggunakan fungsi find() untuk mengambil data pengguna

        if (!$userData) {
            // Jika data pengguna tidak ditemukan, lakukan penanganan sesuai kebutuhan Anda
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            // Jika form di-submit, lakukan validasi data yang diinput
            $validationRules = [];

            $newEmail = $this->request->getPost('email');
            if ($newEmail !== $userData->email) {
                $validationRules['email'] = 'valid_email';
            }

            $newUsername = $this->request->getPost('username');
            if ($newUsername !== $userData->username) {
                $validationRules['username'] = 'min_length[5]';
            }

            $newFullname = $this->request->getPost('fullname');
            if ($newFullname !== $userData->fullname) {
                $validationRules['fullname'] = 'min_length[5]';
            }

            $profileImage = $this->request->getFile('profile_image');
            if ($profileImage->isValid()) {
                $validationRules['profile_image'] = 'uploaded[profile_image]|max_size[profile_image,1024]|mime_in[profile_image,image/png,image/jpeg,image/gif]';
            }

            if ($this->validate($validationRules)) {
                // Jika validasi berhasil, perbarui data pengguna
                $updatedData = [];

                if (isset($validationRules['email'])) {
                    $updatedData['email'] = $newEmail;
                }

                if (isset($validationRules['username'])) {
                    $updatedData['username'] = $newUsername;
                }

                if (isset($validationRules['fullname'])) {
                    $updatedData['fullname'] = $newFullname;
                }

                if (isset($validationRules['profile_image']) && $profileImage->isValid() && !$profileImage->hasMoved()) {
                    $newFileName = $profileImage->getRandomName();
                    $profileImage->move('images', $newFileName);

                    // Hapus gambar lama jika ada
                    if ($userData->profile_image && file_exists('images/' . $userData->profile_image)) {
                        unlink('images/' . $userData->profile_image);
                    }

                    $updatedData['profile_image'] = $newFileName;
                }

                $userModel->update($userId, $updatedData); // Menggunakan fungsi update() untuk memperbarui data pengguna

                // Menentukan pesan sukses berdasarkan perubahan yang dilakukan
                $successMessage = '';
                if (isset($validationRules['email'])) {
                    $successMessage = 'Email berhasil diperbarui.';
                } elseif (isset($validationRules['username'])) {
                    $successMessage = 'Username berhasil diperbarui.';
                } elseif (isset($validationRules['fullname'])) {
                    $successMessage = 'Nama lengkap berhasil diperbarui.';
                } elseif (isset($validationRules['profile_image'])) {
                    $successMessage = 'Foto profil berhasil diperbarui.';
                }

                // Redirect ke halaman profil dengan pesan sukses atau lakukan penanganan lain yang sesuai kebutuhan
                return redirect()->to('/editProfile')->with('success', $successMessage);
            } else {
                // Jika validasi gagal, tampilkan pesan error dan kembalikan form dengan data yang telah diinput
                $data['validation'] = $this->validator;
                $data['user'] = $userData;
                return view('editProfile', $data);
            }
        }

        // Jika tidak ada data yang diubah, tampilkan halaman profil tanpa pesan
        $data['user'] = $userData;
        return view('editProfile', $data);
    }

    
    public function profileHome()
    {
        // Memastikan pengguna telah login
        $sess = session();
        $currentUser = $sess->get('currentuser');
        if (!$currentUser) {
            // Jika pengguna belum login, redirect ke halaman login atau halaman lain yang sesuai
            return redirect()->to('/auth/login');
        }
    
        // Mengambil data pengguna dari database berdasarkan ID pengguna
        $userId = $currentUser['userid'];
        $userModel = new UserModel();
        $userData = $userModel->find($userId); // Menggunakan fungsi find() untuk mengambil data pengguna
    
        if (!$userData) {
            // Jika data pengguna tidak ditemukan, lakukan penanganan sesuai kebutuhan Anda
            return redirect()->to('/auth/login');
        }
    
        if ($this->request->getMethod() === 'post') {
            // Jika form di-submit, lakukan validasi data yang diinput
            if ($this->validate([
                'username' => 'required|min_length[5]|is_unique[users.username]',
                'fullname' => 'required|min_length[5]'
            ])) {
                // Jika validasi berhasil, perbarui data pengguna
                $newUsername = $this->request->getPost('username');
                $newFullname = $this->request->getPost('fullname');
    
                $updatedData = [
                    'username' => $newUsername,
                    'fullname' => $newFullname
                ];
    
                $userModel->update($userId, $updatedData); // Menggunakan fungsi update() untuk memperbarui data pengguna
    
                // Redirect ke halaman profil dengan pesan sukses atau lakukan penanganan lain yang sesuai kebutuhan
                return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
            } else {
                // Jika validasi gagal, tampilkan pesan error dan kembalikan form dengan data yang telah diinput
                $data['validation'] = $this->validator;
                $data['user'] = $userData;
                return view('profileHome', $data);
            }
        }
    
        // Memuat halaman profil dengan data pengguna
        $data['user'] = $userData;
        return view('profileHome', $data);
    }
    


    
    // public function profilepost()
    // {
    //     // Memastikan pengguna telah login
    //     $sess = session();
    //     $currentUser = $sess->get('currentuser');
    //     if (!$currentUser) {
    //         // Jika pengguna belum login, redirect ke halaman login atau halaman lain yang sesuai
    //         return redirect()->to('/auth/login');
    //     }

    //     // Mengambil data pengguna dari database berdasarkan ID pengguna
    //     $userId = $currentUser['userid'];
    //     $userModel = new UserModel();
    //     $userData = $userModel->find($userId); // Menggunakan fungsi find() untuk mengambil data pengguna

    //     if (!$userData) {
    //         // Jika data pengguna tidak ditemukan, lakukan penanganan sesuai kebutuhan Anda
    //         return redirect()->to('/auth/login');
    //     }

    //     // Validasi input yang diterima dari form
    //     $validationRules = [
    //         'username' => 'required|min_length[4]|max_length[20]',
    //         'fullname' => 'required|min_length[2]|max_length[100]',
    //     ];
    //     if (!$this->validate($validationRules)) {
    //         // Jika validasi gagal, kembalikan ke halaman profil dengan pesan kesalahan dan input yang diisi sebelumnya
    //         $data['validation'] = $this->validator;
    //         $data['user'] = $userData;
    //         return view('editProfile', $data);
    //     }

    //     // Perubahan profil berhasil, lakukan pembaruan data pengguna di database
    //     $newUsername = $this->request->getPost('username');
    //     $newFullname = $this->request->getPost('fullname');
    //     $userModel->update($userId, [
    //         'username' => $newUsername,
    //         'fullname' => $newFullname,
    //     ]);

    //     // Set flash data untuk menampilkan notifikasi perubahan profil berhasil
    //     $sess->setFlashdata('success', 'Profil berhasil diperbarui.');

    //     // Redirect ke halaman profil
    //     return redirect()->to('editProfile');
    // }

    // public function resetPassword(){
        
    // }

}
