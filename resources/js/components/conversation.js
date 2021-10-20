document.addEventListener('alpine:init', () => {
    Alpine.data("conversation", function () {
        return {
            user: this.$persist({}),
            messages: [],
            collapsed: this.$persist(false),
            init() {
                if (!this.collapsed && this.user && this.user.id) {
                    this.fetchMessages();
                    this.listenToConversation();
                }
                window.addEventListener('conversation', (e) => {
                    this.user = e.detail;
                    this.fetchMessages();
                    this.listenToConversation();
                })
            },
            fetchMessages() {
                if (this.user && this.user.id) {
                    this.collapsed = false;
                    this.messages = [];
                    axios.get('/messages/' + this.user.id)
                        .then((response) => {
                            this.messages = response.data.data.reverse();
                            this.$nextTick(() => this.scroll());
                            this.$nextTick(() => this.$refs.message.focus());
                        })
                        .catch((error) => {
                            console.log(error.message, error.response.data);
                        });
                }
            },
            scroll() {
                let el = this.$refs.messages;
                el.scrollTop = el.scrollHeight;
            },
            toggleCollapse() {
                this.collapsed = !this.collapsed;
                if (!this.collapsed) {
                    this.fetchMessages();
                    this.$nextTick(() => this.$refs.message.focus());
                }
            },
            sendMessage(message) {
                if (message && this.user && this.user.id) {
                    axios.post('/messages/' + this.user.id, {
                        'message': message,
                    }).then((response) => {
                        console.log(response);
                        if (this.messages.length <= 0) {
                            this.messages.push(response.data);
                            this.listenToConversation(response.data.conversation_id);
                        }
                    }).catch((error) => {
                        console.log(error.message);
                    });
                }
            },
            async listenToConversation(conversationId = null) {
                if (!conversationId) {
                    await axios.get('/conversations/' + this.user.id).then((res) => {
                        console.log('convo: ' + res.data.id);
                        conversationId = res.data.id;
                    }).catch((error) => {
                        alert(error.message);
                    });
                }
                Echo.private(`chat.${conversationId}`)
                    .listen('SendMessage', (e) => {
                        this.messages.push(e.message);
                        this.$nextTick(() => this.scroll());
                        if (e.message.sender_id === this.user.id) {
                            this.newMessageSound.play();
                        }
                    });
            },
            seeMessages() {
                console.log('sending read');
                axios.post(`/messages/${this.user.id}/see`)
                    .then((response) => console.log(response))
                    .catch((error) => console.log(error.response.message))
            }
        }
    });
});