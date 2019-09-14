<?php foreach ($accompanists as $accompanist) { ?>                                 
    <tr>
        <td class="align-middle group_name" data-header="Group Name">
            <div class="media align-items-center">
                <span class="icon_43 icon-tstudio rounded-circle mr-2"></span>
                <div class="media-body">
                    <strong><a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="text_darkblue user_name"><?= $accompanist->name ?></a></strong>
                </div>
            </div>
        </td>
        <td class="group_location" data-header="Location">
            <span class="text_darkblue"><?= $accompanist->location ?></span>
        </td>
        <?php if ($accompanist->admin_id == Auth::id()) { ?>
            <td class="group_actions" data-header="Actions">
                <div class="btns">
                    <a href="<?= asset('edit_accompanist/' . $accompanist->id) ?>" class="act_accept text-black">Edit</a>
                    <a href="javascript:void(0)" onclick="openDeleteModal('<?= $accompanist->id ?>')" class="act_decline text_red">Delete</a>
                </div>
            </td>
        <?php } ?>
    </tr>
<?php } ?>