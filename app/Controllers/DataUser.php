<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\GroupModel;
use App\Models\GroupsUsersModel;

class DataUser extends BaseController
{
    protected $userModel;
    protected $groupModel;
    protected $groupsUsersModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->groupsUsersModel = new GroupsUsersModel();
    }

    public function index()
    {
         $db = \Config\Database::connect();

        // Ambil semua user JOIN ke auth_groups_users
        $builder = $db->table('users')
            ->select('users.*, agu.group_id, ag.name as role')
            ->join('auth_groups_users agu', 'agu.user_id = users.id', 'left')
            ->join('auth_groups ag', 'ag.id = agu.group_id', 'left')
            ->where('ag.name', 'user'); // filter hanya role user

        $users = $builder->get()->getResult();

        // Ambil data role juga untuk select option
        $roles = $db->table('auth_groups')->get()->getResultArray();

        return view('admin/kelola_user', [
            'title' => 'Kelola User',
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Hapus relasi group-user dulu (auth_groups_users)
        $db->table('auth_groups_users')->where('user_id', $id)->delete();

        // Hapus user
        $db->table('users')->where('id', $id)->delete();

        // Set flash message
        session()->setFlashdata('success', 'User berhasil dihapus.');

        return redirect()->to(base_url('/manage-user'));
    }

    public function indexAdmin()
    {
        $db = \Config\Database::connect();

        // Ambil user yang hanya role "user"
        $builder = $db->table('users')
            ->select('users.*, ag.name as role')
            ->join('auth_groups_users agu', 'agu.user_id = users.id', 'left')
            ->join('auth_groups ag', 'ag.id = agu.group_id', 'left')
            ->where('ag.name', 'admin')
            ->get();

        $users = $builder->getResult();

        // Ambil semua roles (untuk form select role)
        $roles = $db->table('auth_groups')->get()->getResultArray();

        return view('admin/kelola_user_admin', [
            'title' => 'Kelola User',
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function deleteAdmin($id)
    {
        $db = \Config\Database::connect();

        // Hapus relasi user-group
        $db->table('auth_groups_users')->where('user_id', $id)->delete();

        // Hapus user
        $db->table('users')->where('id', $id)->delete();

        // Flash message
        session()->setFlashdata('success', 'User berhasil dihapus.');

        return redirect()->to(base_url('manage-user-admin'));
    }

    public function saveAdmin()
    {
        $users = model(\Myth\Auth\Models\UserModel::class);

        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'active'   => 1,
        ];

        $user = new \Myth\Auth\Entities\User($userData);
        $user->activate(); // Kalau mau langsung aktif

        if (!$users->withGroup('admin')->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        session()->setFlashdata('success', 'Admin baru berhasil ditambahkan.');
        return redirect()->to(base_url('manage-user-admin'));
    }


    public function updateAdmin($id)
    {
        $db = \Config\Database::connect();
        $validation = \Config\Services::validation();

        // Validasi
        $rules = [
            'username' => "required|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        // Jika password diisi, validasi juga
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data yang akan diupdate
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'active'   => 1,
        ];

        // Jika password diisi, update password
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Update
        $db->table('users')->where('id', $id)->update($data);

        session()->setFlashdata('success', 'Admin berhasil diupdate.');
        return redirect()->to(base_url('manage-user-admin'));
    }


}
