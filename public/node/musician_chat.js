/**
 * Created by nomantufail on 10/27/2016.
 */
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var db = require('./db.js');
var mydb = new db();

app.get('/', function (req, res) {
    res.send('Working fine New');
});
var sockets = {};
var arr = [];
io.on('connection', function (socket) {
    socket.on('message_get', function (data) {
        io.emit('message_send', {'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id, 'chat_id': data.chat_id, 'message': data.message, 'chat_type': data.chat_type, 'chat_type_id': data.chat_type_id, 'to_be_show': data.to_be_show});
    });
    
    socket.on('groupmessage_get', function (data) {
        io.emit('groupmessage_send', {'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'group_member_profile_images':data.group_member_profile_images, 'text': data.text, 'other_id': data.other_id, 'chat_id': data.chat_id, 'message': data.message, 'chat_type': data.chat_type, 'chat_type_id': data.chat_type_id, 'to_be_show': data.to_be_show, 'chat_name': data.chat_name });
    });
    
    socket.on('notification_get', function (data) {
        //for group invites request notifications
        if (data.hasOwnProperty('group_invite') && data.hasOwnProperty('group_id') && data.hasOwnProperty('group_name') && data.hasOwnProperty('group_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'group_id': data.group_id, 'group_name': data.group_name, 'group_url': data.group_url, 'unique_text': data.unique_text, 'group_invite': 1, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification,
            });
        }
        //for group join request notifications
        else if (data.hasOwnProperty('group_id') && data.hasOwnProperty('group_name') && data.hasOwnProperty('group_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'group_id': data.group_id, 'group_name': data.group_name, 'group_url': data.group_url, 'unique_text': data.unique_text, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification, 'request_approve': data.request_approve,
            });
        }
        //for studio invites request notifications
        else if (data.hasOwnProperty('studio_invite') && data.hasOwnProperty('studio_id') && data.hasOwnProperty('studio_name') && data.hasOwnProperty('studio_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'studio_id': data.studio_id, 'studio_name': data.studio_name, 'studio_url': data.studio_url, 'unique_text': data.unique_text, 'studio_invite': 1, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification, 'request_approve': data.request_approve, 'type':data.type,
            });
        }
        //for teaching studio join request notifications
        else if (data.hasOwnProperty('studio_id') && data.hasOwnProperty('studio_name') && data.hasOwnProperty('studio_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'studio_id': data.studio_id, 'studio_name': data.studio_name, 'studio_url': data.studio_url, 'unique_text': data.unique_text, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification, 'request_approve': data.request_approve, 'type':data.type, 
            });
        }
        
         //for accompanist_invite request notifications
        else if (data.hasOwnProperty('accompanist_invite') && data.hasOwnProperty('accompanist_id') && data.hasOwnProperty('accompanist_name') && data.hasOwnProperty('accompanist_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'accompanist_id': data.accompanist_id, 'accompanist_name': data.accompanist_name, 'accompanist_url': data.accompanist_url, 'unique_text': data.unique_text, 'accompanist_invite': 1, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification, 'request_approve': data.request_approve,
            });
        }
        //for accompanist_id join request notifications
        else if (data.hasOwnProperty('accompanist_id') && data.hasOwnProperty('accompanist_name') && data.hasOwnProperty('accompanist_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'accompanist_id': data.accompanist_id, 'accompanist_name': data.accompanist_name, 'accompanist_url': data.accompanist_url, 'unique_text': data.unique_text, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification,'request_approve': data.request_approve,
            });
        }
        
         //for accompanist_invite request notifications
        else if (data.hasOwnProperty('friend_invite') && data.hasOwnProperty('friend_id') && data.hasOwnProperty('friend_name') && data.hasOwnProperty('friend_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'friend_id': data.friend_id, 'friend_name': data.friend_name, 'friend_url': data.friend_url, 'unique_text': data.unique_text, 'friend_invite': 1, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification,
            });
        }
        //for accompanist_id join request notifications
        else if (data.hasOwnProperty('friend_id') && data.hasOwnProperty('friend_name') && data.hasOwnProperty('friend_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'friend_id': data.friend_id, 'friend_name': data.friend_name, 'friend_url': data.friend_url, 'unique_text': data.unique_text, 'notification_icon': data.notification_icon,
                'left_notification': data.left_notification, 'friend_response':data.friend_response, 'user_name': data.user_name, 'user_photo': data.user_photo
            });
        }
        
        //from admin
        else if (data.hasOwnProperty('from_admin')) {
            io.emit('notification_send', {
                'url': data.url, 'user_id': data.user_id, 'text': data.text, 'unique_text': data.unique_text, 'notification_icon': data.notification_icon, 'from_admin': 'yes'
            });
        //for bookings
        } else if (data.hasOwnProperty('is_booking_notification')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'unique_text': data.unique_text, 'other_url': data.other_url, 'notification_icon': data.notification_icon, 'is_booking_notification': data.is_booking_notification
            });
        }
        //for others
        else if (data.hasOwnProperty('other_url') && data.hasOwnProperty('unique_text')) {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id,
                'unique_text': data.unique_text, 'other_url': data.other_url, 'notification_icon': data.notification_icon,
            });
        } else {
            io.emit('notification_send', {'url': data.url, 'user_id': data.user_id, 'other_name': data.other_name, 'photo': data.photo, 'text': data.text, 'other_id': data.other_id, 'chat_type': data.chat_type, 'chat_type_id': data.chat_type_id, 'to_be_show': data.to_be_show, 'is_message_notification': data.is_message_notification});
        }
    });
    socket.on('disconnect', function () {
        if (sockets[socket.id] != undefined) {
            mydb.releaseRequest(sockets[socket.id].user_id).then(function (result) {
                console.log('disconected: ' + sockets[socket.id].request_id);
                io.emit('request-released', {
                    'request_id': sockets[socket.id].request_id
                });
                delete sockets[socket.id];
            });
        }
    });
});



http.listen(5002, function () {
    console.log('listening on *:5002');
});