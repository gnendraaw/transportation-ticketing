<?php

class Admin extends Controller {
    public function index()
    {
        Middleware::onlyAdmin();
        $petugas = $this->model('petugas_model')->getAllPetugas();

        $data = [
            'title' => 'Admin Dashboard',
            'heading' => 'dashboard',
            'subHeading' => 'dashboard',
            'options' => 'dashboard',
            'petugas' => $petugas,
        ];

        $this->view('templates/header', $data);
        $this->view('admin/index', $data);
        $this->view('templates/footer');
    }

    public function daftarPetugas()
    {
        Middleware::onlyAdmin();

        $petugas = $this->model('petugas_model')->getAllPetugas();
        $level = $this->model('level_model')->getAllLevel();

        $data = [
            'title' => 'Daftar Petugas',
            'heading' => 'admin',
            'subHeading' => 'petugas',
            'options' => 'daftarPetugas',
            'petugas' => $petugas,
            'level' => $level,
        ];

        $this->view('templates/header', $data);
        $this->view('admin/petugas/index', $data);
        $this->view('templates/footer');
    }

    public function tambahPetugas()
    {
        Middleware::onlyAdmin();
        $level = $this->model('level_model')->getAllLevel();

        $data = [
            'title' => 'Tambah Petugas',
            'heading' => 'admin',
            'subHeading' => 'petugas',
            'options' => 'tambahPetugas',
            'level' => $level,
        ];

        $this->view('templates/header', $data);
        $this->view('admin/petugas/create', $data);
        $this->view('templates/footer');
    }

    public function storePetugas()
    {
        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'nama_petugas' => $_POST['nama'],
            'id_level' => $_POST['level'],
        ];

        // encrypt password
        $data['password'] = md5($data['password']);

        if ($this->model('petugas_model')->addPetugas($data) > 0)
        {
            Flasher::setFlash('Account registered!');
            $this->directTo('/admin/daftarPetugas');
        }
        Flasher::setFlash('Failed to create account');
        $this->directTo('/admin/daftarPetugas');
    }

    public function updatePetugas()
    {
        if (empty($_POST))
        {
            $this->view('not_found/index');
            exit;
        }
        $data = [
            'id_petugas' => $_POST['id'],
            'username' => $_POST['username'],
            'nama_petugas' => $_POST['nama'],
            'id_level' => $_POST['level'],
        ];

        if ($this->model('petugas_model')->updatePetugas($data) > 0)
        {
            Flasher::setFlash('Account updated!');
            $this->directTo('/admin/daftarPetugas');
        }
        Flasher::setFlash('Failed to update account!');
        $this->directTo('/admin/daftarPetugas');
    }

    public function deletePetugas()
    {
        $data = [
            'id_petugas' => $_POST['id'],
        ];

        if ($this->model('petugas_model')->deletePetugas($data) > 0)
        {
            Flasher::setFlash('Account deleted!');
            $this->directTo('/admin/daftarPetugas');
        }
        Flasher::setFlash('Failed to delete account');
        $this->directTo('/admin/daftarPetugas');
    }

    public function daftarTransportasi()
    {
        $transportasi = $this->model('transportasi_model')->getAllTransportasi();

        $data = [
            'title' => 'Daftar Transportasi',
            'heading' => 'admin',
            'subHeading' => 'transportasi',
            'options' => 'daftarTransportasi',
            'transportasi' => $transportasi,
        ];

        $this->view('templates/header', $data);
        $this->view('admin/transportasi/index', $data);
        $this->view('templates/footer');
    }

    public function getPetugasData()
    {
        echo json_encode($this->model('petugas_model')->getPetugasById($_POST['id_petugas']));
    }

    public function tipeTransportasi()
    {
        Middleware::onlyAdmin();

        $tipeTransportasi = $this->model('type_transportasi_model')->getAllTypeTransportasi();

        $data = [
            'title' => 'Tipe Transportasi',
            'heading' => 'admin',
            'subHeading' => 'transportasi',
            'options' => 'tipeTransportasi',
            'tipeTransportasi' => $tipeTransportasi,
        ];

        $this->view('templates/header', $data);
        $this->view('admin/tipe_transportasi/index', $data);
        $this->view('templates/footer');
    }

    public function getTipeTransportasiData()
    {
        echo json_encode($this->model('type_transportasi_model')->getTipeTransportationById($_POST['id_tipe_transportasi']));
    }

    public function storeTipeTransportasi()
    {
        Middleware::onlyAdmin();

        $data = [
            'nama' => $_POST['namaTipe'],
            'keterangan' => $_POST['keteranganTipe'],
        ];

        if ($this->model('type_transportasi_model')->addTipeTransportasi($data) > 0)
        {
            Flasher::setFlash('Tipe Transportasi sukses ditambahkan!', 'success');
            $this->directTo('/admin/tipeTransportasi');
        }
        Flasher::setFlash('Gagal menambahkan tipe transporasi');
        $this->directTo('/admin/tipeTransportasi');
    }

    public function updateTipeTransportasi()
    {
        Middleware::onlyAdmin();

        $data = [
            'id' => $_POST['id'],
            'nama' => $_POST['namaTipe'],
            'keterangan' => $_POST['keteranganTipe'],
        ];

        if ($this->model('type_transportasi_model')->updateTipeTransportasiById($data) > 0)
        {
            Flasher::setFlash('Tipe transportasi sukses dirubah!', 'success');
            $this->directTo('/admin/tipeTransportasi');
        }
        Flasher::setFlash('Gagal mengubah tipe transporasi');
        $this->directTo('/admin/tipeTransportasi');
    }
}