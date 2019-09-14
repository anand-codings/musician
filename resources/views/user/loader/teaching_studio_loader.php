<?php foreach ($teachingStudios as $teachingStudio) { ?>                                 
    <tr>
        <td class="align-middle group_name" data-header="Group Name">
            <div class="media align-items-center">
                <span class="icon_43 icon-tstudio rounded-circle mr-2"></span>
                <div class="media-body">
                    <strong><a href="<?=asset('teaching_studio_time_line/'.$teachingStudio->id)?>" class="text_darkblue user_name"><?= $teachingStudio->name ?></a></strong>
                    <div class="date_time">You & <?= $teachingStudio->approvedTeachers->count() ?> other members</div>
                </div>
            </div>
        </td>
        <td class="group_location" data-header="Location">
            <span class="text_darkblue"><?= $teachingStudio->location ?></span>
        </td>
        <td class="group_team" data-header="Team">
            <span class="text_darkblue"><?= $teachingStudio->approvedMembers->count() ?> Members</span>
        </td>
        <?php if ($teachingStudio->admin_id == Auth::id()) { ?>
            <td class="group_actions" data-header="Actions">
                <div class="btns">
                    <a href="<?=asset('edit_teaching_studio/'.$teachingStudio->id)?>" class="act_accept text-black">Edit</a>
                    <a href="javascript:void(0)" onclick="openDeleteModal('<?= $teachingStudio->id ?>')" class="act_decline text_red">Delete</a>
                </div>
            </td>
            
    <?php } ?>
    </tr>
<?php } ?>