let discussion = (discussion) => ({
    discussion: discussion,
    comments: [],
    init() {
        this.getComments();
        Echo.channel(`discussion.${this.discussion.id}`)
            .listen('NewComment', (e) => {
                this.discussion.comments_count++;
                if (!e.comment.comment_id) {
                    this.comments.push(e.comment);
                } else {
                    let comment = this.comments.find(comment => comment.id === e.comment.comment_id);
                    if (comment) {
                        if (!comment.replies) {
                            comment.replies = [];
                        }
                        comment.replies.push(e.comment);
                        comment.replies_count++;
                    }
                }
            });
    },
    postComment(el, replyTo = null) {
        let comment = el.value;
        if (comment) {
            axios.post(`/discussions/${this.discussion.id}/comments`, {
                text: comment,
                comment_id: replyTo,
            }).then((res) => {
                el.value = '';
            }).catch((error) => alert(error.message));
        }
    },
    getComments(commentId = null) {
        if (this.discussion && this.discussion.id) {
            axios.get(`/discussions/${this.discussion.id}/comments`, {
                params: {
                    comment_id: commentId,
                }
            }).then((res) => {
                if (!commentId) {
                    this.comments = res.data;
                } else {
                    // Set replies;
                    let comment = this.comments.find(comment => comment.id === commentId);
                    if (comment) {
                        comment.replies = res.data;
                    }
                }
            }).catch((error) => alert(error.message));
        }
    }
});

export default discussion;