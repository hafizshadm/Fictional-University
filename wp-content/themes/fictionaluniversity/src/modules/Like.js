import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on('click', this.ourClickDispatcher.bind(this));
    }

    ourClickDispatcher(e) {
        var currentLikeBox = $(e.target).closest(".like-box");
        if(currentLikeBox.attr("data-exists") == 'yes'){
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }

    createLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                (xhr).setRequestHeader("X-WP-Nonce", universityData.nonce)
            },
            url: universityData.root_url + '/wp-json/university/v1/manage-like',
            type: 'POST',
            data: {
                'professorId': currentLikeBox.data("professor")
            },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'yes');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount++;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr("data-like", response);
                console.log(response);
            },
            error: (err) => {
                console.log(err);
            }
        });
    }

    deleteLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                (xhr).setRequestHeader("X-WP-Nonce", universityData.nonce)
            },
            url: universityData.root_url + '/wp-json/university/v1/manage-like',
            type: 'DELETE',
            data: {
                'like': currentLikeBox.attr("data-like")
            },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount--;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr("data-like", 0);
                console.log(response);
            },
            error: (err) => {
                console.log(err);
            }
        });
    }
}

export default Like;