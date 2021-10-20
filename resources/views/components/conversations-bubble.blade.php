<div class="self-center"
     x-data="{
        conversations: [],
        getConversations(){
            axios.get('/conversations')
            .then((response) => {
                this.conversations = response.data.data;
            })
            .catch((error) => {
                console.log(error.message);
            });
        },
        get unread_messages_count(){
            let total = 0;
            this.conversations.forEach((convo) => {
                if(convo.unread_messages_count > 0){
                    total++
                }
            });
            return total;
        },
        init(){
            this.getConversations();
        }
    }">
    <x-dropdown align="right" width="w-60">
        <x-slot name="trigger">
            <button x-on:click="if(!open){getConversations()}"
                    class="relative inline-flex items-center text-sm font-semibold text-gray-700 transition duration-150 ease-in-out hover:text-gray-800 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:border-gray-300">
                <x-heroicon-s-chat-alt-2 class="w-8 h-8"/>
                <template x-if="unread_messages_count > 0">
                <span class="inline-flex items-center justify-center text-xs font-semibold absolute bottom-2/3 left-2/3 h-5 w-5 bg-primary-500 rounded-full"
                      x-text="unread_messages_count"></span>
                </template>
            </button>
        </x-slot>

        <x-slot name="content">
            <template x-for="(conversation, index) in conversations" :key="index">
                <button x-on:click="openConversation(conversation.user)"
                        class="relative flex gap-2 items-center py-2 px-2 text-left w-full hover:bg-gray-50"
                        :class="{'border-b': index != conversations.length - 1}"
                >
                    <img :src="conversation.user.image_url"
                         class="w-10 h-10 rounded-full object-cover bg-gray-100">
                    <div>
                        <p class="text-sm font-semibold truncate"
                           x-text="conversation.user.name"></p>
                        <p class="text-xs truncate" x-text="conversation.user.email"></p>
                    </div>
                    <template x-if="conversation.unread_messages_count > 0">
                        <span class="inline-flex items-center justify-center text-xs font-semibold absolute right-2 top-2 h-6 w-6 bg-primary-500 rounded-full"
                              x-text="conversation.unread_messages_count"></span>
                    </template>
                </button>
            </template>
            <template x-if="!conversations || !conversations.length">
                <p class="py-2 px-4">No Conversation</p>
            </template>
        </x-slot>

    </x-dropdown>
</div>