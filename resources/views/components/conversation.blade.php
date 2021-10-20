<div x-data="conversation">
    <template x-if="user && user.id">
        <div class="flex flex-col divide-y fixed bottom-0 max-w-full w-80 right-0 sm:right-10 bg-white shadow-2xl rounded-t-xl">
            <div class="text-sm leading-tight relative">
                <div class="flex items-center gap-3 py-2 px-4 leading-none">
                    <img :src="user.image_url"
                         class="w-10 h-10 rounded-full object-cover bg-gray-100">
                    <div class="flex-1">
                        <p class="text-sm font-semibold truncate"
                           x-text="user.name"></p>
                        <p class="text-xs truncate" x-text="user.email"></p>
                    </div>
                    <x-button
                            color="light"
                            class="rounded-full w-8 h-8 text-xl"
                            x-on:click="toggleCollapse()"
                            x-text="collapsed ? '&plus;' : '&minus;'"
                    >&minus;
                    </x-button>
                </div>
            </div>
            <div x-show="!collapsed" x-collapse x-cloak>
                <div
                        class="overflow-y-auto h-80 bg-gray-100 text-sm leading-tight"
                        :class="{'py-4 px-2': messages.length > 0}"
                        x-ref="messages">
                    <template x-for="message in messages" :key="message.id">

                        <div class="shadow-sm px-3 py-2 rounded-xl w-2/3 max-w-max mt-2"
                             :class="{
                                'bg-white rounded-bl-none': message.sender_id == user.id,
                                'bg-primary-100 rounded-br-none ml-auto': message.sender_id != user.id,
                            }">
                            <p x-text="message.message"></p>
                            <p class="text-xs opacity-50" x-text="message.created_at"></p>
                        </div>

                    </template>

                    <template x-if="!messages.length">
                        <img class="h-full w-full object-cover" src="{{ asset('images/sleepycat.gif') }}"
                             alt="No message here....">
                    </template>

                </div>
            </div>
            <div x-show="!collapsed" x-collapse x-cloak>
                <input type="text"
                       class="w-full border-0 py-4"
                       x-on:keydown.enter="sendMessage($el.value); $el.value = ''"
                       x-ref="message"
                       name="message"
                       x-on:focus="seeMessages()"
                       placeholder="Write a message & press enter...."/>
            </div>
        </div>
    </template>
</div>