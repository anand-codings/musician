<?php foreach ($groups as $group) { ?>                                 
    <tr>
        <td class="align-middle group_name" data-header="Group Name">
            <div class="media align-items-center">
                <span class="icon_43 icon-group rounded-circle mr-2"></span>
                <div class="media-body">
                    <strong><a href="<?=asset('group_time_line/'.$group->id)?>" class="text_darkblue user_name"><?= $group->name ?></a></strong>
                    <div class="date_time">You & <?= $group->approvedMembers->count() ?> other members</div>
                </div>
            </div>
        </td>
        <td class="group_state" data-header="States">
            <span class="text_darkblue"><?= $group->bookings->count() ?> Times Booked</span>
        </td>
        <td class="group_location" data-header="Location">
            <span class="text_darkblue"><?= $group->location ?></span>
        </td>
        <td class="group_team" data-header="Team">
            <span class="text_darkblue"><?= $group->approvedMembers->count() + 1 ?> Members</span>
        </td>
        <?php if ($group->admin_id == Auth::id()) { ?>
            <td class="group_actions" data-header="Actions">
                <div class="btns">
                    <a href="<?=asset('edit_group/'.$group->id)?>" class="act_accept text-black">Edit</a>
                    <a href="javascript:void(0)" onclick="openDeleteModal('<?= $group->id ?>')" class="act_decline text_red">Delete</a>
                </div>
            </td>
            
    <?php } ?>
    </tr>
<?php } ?>