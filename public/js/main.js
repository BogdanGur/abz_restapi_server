$(document).ready(function () {
    var page = 2;

    $(".load_more-btn").on("click", function () {
        if(!page) page = 2;

        $.ajax({
            dataType: "JSON",
            url: 'http://resume/api/v1/users?page='+page,
            success: function (data) {
                $.each(data.users, function () {
                    var img;
                    if(this.photo) img = this.photo;
                    else img = 'http://resume/storage/user_photos/no_image.png';

                    $(".users_load_block").append('' +
                        '<div class="user_block">' +
                        '   <div class="user_photo">' +
                        '       <img src="'+img+'" alt="">' +
                        '   </div>' +
                        '   <div class="user_info">' +
                        '       <ul>' +
                        '           <li><strong>Name:</strong> '+this.name+'</li>' +
                        '           <li><strong>Email:</strong> '+this.email+'</li>' +
                        '           <li><strong>Phone:</strong> '+this.phone+'</li>' +
                        '           <li><strong>Position:</strong> '+this.position+'</li>' +
                        '       </ul>' +
                        '    </div>' +
                        '</div>');
                });
            },
            error: function () {
                $('.load_more-btn').attr('disabled','disabled');
                $('.load_more-btn').addClass('disabled');
                console.log("Error");
            }
        });

        page += 1;
    });
});
