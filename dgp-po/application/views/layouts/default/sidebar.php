<?php
$level = $this->session->userdata('level');
if ($level == 9){
    $menu_sidebar = array(
        [
            'icon_class' => 'fa fa-list',
            'url' => base_url('portal/dashboard'),
            'title' => 'Portal',
            'active' => FALSE,
        ],
        [
            'icon_class' => 'fa fa-pie-chart',
            'url' => '#',
            'title' => 'Báo cáo',
            'active' => FALSE,
            'children' => [
                [
                    'url' => base_url('report/agent_code'),
                    'title' => 'Code',
                ],
                [
                    'url' => base_url('report/application'),
                    'title' => 'Doanh số',
                ],
            ]
        ],
        [
            'icon_class' => 'fa fa-cloud-upload',
            'url' => base_url('import/upload'),
            'title' => 'Import',
            'active' => FALSE,
        ],
        [
            'icon_class' => 'fa fa-cogs',
            'url' => "#",
            'title' => 'Cài đặt',
            'active' => FALSE,
            'children' => [
                [
                    'url' => base_url('config/account'),
                    'title' => 'Account',
                ],
//                [
//                    'url' => base_url('config/project'),
//                    'title' => 'Project',
//                ],
//                [
//                    'url' => base_url('config/product'),
//                    'title' => 'Product',
//                ],
//                [
//                    'url' => base_url('config/product_status'),
//                    'title' => 'productStatus',
//                ],
            ]
        ]
    );
} elseif ($level == 1){
    $userPermission = $this->session->userdata('userPermission');
    $userPermission = json_decode($userPermission);
    $importPermission = [];
    $reportMenu = [];
    if (in_array(2,$userPermission)){
        $importPermission = [
            'icon_class' => 'fa fa-cloud-upload',
            'url' => base_url('import/upload'),
            'title' => 'Import',
            'active' => FALSE,
        ];
    }

    if (in_array(1,$userPermission)){
        $reportMenu = [
            'icon_class' => 'fa fa-pie-chart',
            'url' => '#',
            'title' => 'Báo cáo',
            'active' => FALSE,
            'children' => [
                [
                    'url' => base_url('report/agent_code'),
                    'title' => 'Code',
                ],
                [
                    'url' => base_url('report/application'),
                    'title' => 'Doanh số',
                ],
            ]
        ];
    }

    $menu_sidebar = array(
        [
            'icon_class' => 'fa fa-list',
            'url' => base_url('portal/dashboard'),
            'title' => 'Portal',
            'active' => FALSE,
        ],
        $reportMenu,
        $importPermission
    );
} elseif ($level == 8){
    $userPermission = $this->session->userdata('userPermission');
    $userPermission = json_decode($userPermission);
    $importPermission = [];
    $reportMenu = [];

    if (in_array(1,$userPermission)){
        $reportMenu = [
            'icon_class' => 'fa fa-pie-chart',
            'url' => '#',
            'title' => 'Báo cáo',
            'active' => FALSE,
            'children' => [
                [
                    'url' => base_url('report/agent_code'),
                    'title' => 'Code',
                ],
                [
                    'url' => base_url('report/application'),
                    'title' => 'Doanh số',
                ],
            ]
        ];
    }

    $menu_sidebar = array(
        [
            'icon_class' => 'fa fa-list',
            'url' => base_url('portal/dashboard'),
            'title' => 'Portal',
            'active' => FALSE,
        ],
        $reportMenu,
        $importPermission
    );
}
?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class=""> <!--sidebar-collapse--->
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header" style="padding: 15px;">
                <div class="dropdown profile-element">
                    <a href="<?php echo base_url('dashboard'); ?>">

                    <span style="text-align: center">
                        <h3 style="color: white">ThienTu Report</h3>
                        <!--                        <img alt="image" class="img-responsive" src="-->
                        <?php //echo config_item('site_assets_index'); ?><!--inspinia/img/profile_small.png" />-->
                    </span>
                    </a>

                </div>
                <div class="logo-element">
                    <a href="<?php echo base_url('dashboard'); ?>">
                        TTR
                    </a>
                </div>
            </li>
            <?php foreach ($menu_sidebar as $sidebar_single):
                if(empty($sidebar_single)){
                    continue;
                }
                $active = '';
                if (base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) == $sidebar_single['url']) {
                    $active = 'active';
                }
                ?>
                <li class="<?php echo $active; ?>">
                    <a href="<?php echo $sidebar_single['url']; ?>">
                        <i class="<?php echo $sidebar_single['icon_class']; ?>"></i>
                        <span class="nav-label"><?php echo $sidebar_single['title']; ?></span>
                        <?php if (isset($sidebar_single['children'])): ?>
                            <span class="fa arrow"></span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($sidebar_single['children'])): ?>
                        <?php
                        $active = 'collapse';
                        if ($this->uri->segment(1) . '/' . $this->uri->segment(2) == "admin/mobile_card") {
                            $active = 'collapse in';
                        }
                        ?>
                        <ul class="nav nav-second-level <?php echo $active ?>">
                            <?php foreach ($sidebar_single['children'] as $child): ?>
                                <li><a href="<?php echo $child['url'] ?>"><?php echo $child['title'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>