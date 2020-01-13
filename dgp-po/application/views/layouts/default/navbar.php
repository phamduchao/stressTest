
<nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <button onclick="change_pass('<?php echo $this->session->userdata('id');?>')"
                    href="javascript: void(0)" type="button"
                    class="btn btn-xs btn-outline btn-warning">
                Đổi mật khẩu
            </button>
        </li>
        <li>
            <a href="<?php echo base_url('user/logout'); ?>">
                <i class="fa fa-sign-out"></i> Thoát
            </a>
        </li>
    </ul>
</nav>
<script>
    function change_pass(userID) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "tapToDismiss": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": 0,
            "extendedTimeOut": 0,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "html": true,
        };
        var str = '<form class="form-horizontal" role="form" id="edit_pwd" method="post">';
        str += "<span>Password</span>";
        str += "<input placeholder='Để trống nếu không cần đổi password' name='pwdTxt' id='pwdTxt' value='' type='password' class='input-sm form-control' style='color: darkred'><br>";
        str += "<button onclick='save_pwd("+userID+")' class='btn btn-sm btn-primary btn-block' type='submit'>Xác nhận</button>";
        str += "</form>";
        toastr.error(str,'');
    }
    function save_pwd(userID) {
        $("#edit_pwd").submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var url = '<?php echo base_url('user/change_password');?>';
            $.ajax({
                type: "POST",
                url: url,
                data: $('#edit_pwd').serialize() + '&userID=' + userID,
                success: function (res) {
                    location.reload();
                }
            });

        });
    }
</script>