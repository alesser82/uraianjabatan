    <script src="<?= base_url('assets/js/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap-select.js') ?>"></script>
    <?php
    if (isset($konten)) {
        switch ($konten) {
            case 'uraian_jabatan':
                echo '<script src="'.base_url('assets/js/UraianJabatan.js').'"></script>
                <script>
    UraianJabatan()
</script>';
                break;
            case 'pemegang_posisi':
                echo '<script src="'.base_url('assets/js/PemegangPosisi.js').'"></script>
                <script>
    PemegangPosisi()
</script>';
                break;
            case 'admin':
                echo '<script src="'.base_url('assets/js/Admin.js').'"></script>
                <script>
    Admin()
</script>';
                break;
            default:
                echo '';
                break;
        }
    }
    
?>
</body>
</html>