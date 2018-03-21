<div class="navbar-default sidebar" role="navigation">
<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li>
            <?php echo '<p class="welcome"><b> <text style="font-size:150%;">&#9786</text> <i>ยินดีต้อนรับ </i>' . $this->session->userdata('name') . "!</b></p>"; ?>
        </li>
        <li>
            <a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i> แดชบอร์ด</a>
        </li>
        <?php if($this->session->userdata('role') == 'admin'): ?>
            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> ผู้ดูแลระบบ<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="<?=base_url('admin/user_list')?>">&raquo; รายชื่อผู้ใช้</a> </li>
                    <li> <a href="<?=base_url('admin/activity_log')?>">&raquo; บันทึกกิจกรรม</a> </li>
                </ul>
            </li>
        <?php endif; ?>
        <?php if($this->session->userdata('role') == 'admin'): ?>
            <li>
                <a href="#"><i class="fa fa-file fa-fw"></i> เกล็ดความรู้<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li> <a href="<?=base_url('knowlages/add_knowlages')?>">&raquo; เพิ่มเกล็ดความรู้</a> </li>
                    <li> <a href="<?=base_url('knowlages/view_knowlages')?>">&raquo; รายการเกล็ดความรู้</a> </li>
                </ul>
            </li>
        <?php endif; ?>
        <li>
            <a href="#"><i class="fa fa-user fa-fw"></i> Other Menu Sample<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li> <a href="#">&raquo; Other Sub Menu 1</a> </li>
                <li> <a href="#">&raquo; Other Sub Menu 2</a> </li>
            </ul>
        </li>
  
        
    </ul>
</div>
<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>