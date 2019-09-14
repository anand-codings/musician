$(function () {
    //Start game
    $(".play").on("click", function () {
        console.log("Largura " + $(window).width(), "Altura " + $(window).height());
        var score = 0;
        var totalBubbles = 0;
        var bubbleInterval = setInterval(addBubble, 500);
        $(this).hide();
        $(".youLose").hide();
        $(".info").hide();
        $("#score").text(score);
        $("#maxBubble").text(totalBubbles);

        function addBubble() {
            //Create the bubble
            var bubble = $('<img class="bubble" src="https://vignette.wikia.nocookie.net/tudosobrehoradeaventura/images/d/d4/Bolha.png/revision/latest?cb=20130908150958&path-prefix=pt-br" alt="bubble">');
            var x = Math.floor(Math.random() * ($(window).width() - bubble.width()));
            var y = Math.floor(Math.random() * ($(window).height() - 70));

            console.log(bubble.width(), bubble.height());

            //Append the bubble
            bubble.css("top", y + "px").css("left", x + "px").appendTo(document.body);
            totalBubbles += 1;
            $("#maxBubble").text(totalBubbles);

            //burst the bubble
            bubble.on("click", function () {
                $(this).fadeOut("fast");
                score = score + 1;
                totalBubbles -= 1;
                $("#score").text(score);
                $("#maxBubble").text(totalBubbles);
            });

            //You Lose
            if (totalBubbles > 6) {
                $(".bubble").hide();
                $(".play").show();
                $(".youLose").show();
                clearInterval(bubbleInterval);
            }
        }
    });
});

