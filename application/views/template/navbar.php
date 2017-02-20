<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li>
                    <a href="<?= base_url('Welcome/index')?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                </li>
                                
                <?php foreach ($_getMenu1 as $r1): ?>
                    <?php if($r1->HaveChild == 1): ?>
                        <li class="has-submenu">
                            <a href="#"><i class="<?= $r1->IconMenu?>"></i><?= $r1->LabelMenu?></a>
                            <ul class="submenu">
                                <?php foreach ($_getMenu2 as $r2): ?>
                                    <?php if($r2->HeaderMenu == $r1->MenuID): ?>
                                        <?php if($r2->HaveChild == 1): ?>
                                            <li class="has-submenu">
                                                <a href="#"><?= $r2->LabelMenu?></a>
                                                <ul class="submenu">
                                                    <?php foreach ($_getMenu3 as $r3): ?>
                                                        <?php if($r3->HeaderMenu == $r2->MenuID): ?>
                                                            <li><a href="<?= base_url($r3->LinkMenu)?>"><?= $r3->LabelMenu?></a></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li><a href="<?= base_url($r2->LinkMenu)?>"><?= $r2->LabelMenu?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= base_url($r1->LinkMenu)?>"><i class="<?= $r1->IconMenu?>"></i><?= $r1->LabelMenu?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->