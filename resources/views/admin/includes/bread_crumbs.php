<ol class="breadcrumb">
    <?php 
    $breadCrumbsCount  = count($breadCrumbs);
    $breadCrumbsCounter = 1;
    ?>
    <?php foreach ($breadCrumbs as $breadCrumb) { ?>
        <li class="<?= $breadCrumbsCounter == $breadCrumbsCount ? 'active' : '' ?>">
            <a href="<?= asset($breadCrumb['href']) ?>"><?= $breadCrumb['name'] == 'Dashboard' ? '<i class="fa fa-dashboard"></i> Dashboard' : $breadCrumb['name'] ?></a>
        </li>
        <?php $breadCrumbsCounter++; ?>
    <?php } ?>
</ol>
