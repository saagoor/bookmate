@props(['discussion'])

<div x-data="discussion({{ $discussion }})">
    @auth
        <form action="{{ route('discussions.comments.store', $discussion) }}"
              x-on:submit.prevent="postComment($el['comment'])">
            <div class="flex gap-4 my-6">
                <x-img class="w-16 h-16 border rounded-full bg-primary-100"
                       :src="auth()->user()->image_url"/>
                <div class="flex-1">
                    <x-input-textarea
                            class="mb-2"
                            name="comment"
                            placeholder="Share your opinion....."></x-input-textarea>
                    <x-button>Post Comment</x-button>
                </div>
            </div>
        </form>
    @else
        <div class="p-4 mb-6 sm:p-6 card">
            <p class="text-lg">
                You need to
                <a href="{{ route('login') }}"><span class="font-semibold">Login</span></a>
                or
                <a href="{{ route('register') }}"><span class="font-semibold">Register</span></a>
                to participate in the discussion.
            </p>
        </div>
    @endauth
    <h3 class="mb-3 text-lg font-semibold"><span x-text="discussion.comments_count">{{ $discussion->comments_count }}</span> {{ Str::plural('Comment', $discussion->comments_count) }}</h3>
    {{--    Comments --}}
    <div>
        <template x-for='(comment, index) in comments'>
            <div class='flex gap-3 py-4'>
                <img class='w-10 h-10 border rounded-full bg-primary-100'
                     :src='comment.user.image_url'>
                <div class='flex-1'
                     x-data="{
                        showReplies: false,
                        showForm: false,
                        showReplyForm(){
                            this.showForm = !this.showForm;
                            let el = this.$root.querySelector('[x-show=showForm]');
                            el.scrollIntoView();
                            el.querySelector('input').focus();
                        }
                    }"
                >
                    <p class='leading-tight'>
                        <a href='#'><span class='font-bold' x-text='comment.user.name'></span></a>
                        <span x-text='comment.text'></span>
                    </p>
                    <div class='flex gap-1.5 items-center text-xs opacity-70'>
                        <button>Like</button> &#9900;
                        <button x-on:click='getComments(comment.id); showReplies = !showReplies'
                                x-text="'View ' + comment.replies_count + ' Replies'">View Replies
                        </button> &#9900;
                        <button x-on:click.prevent='showReplyForm()'
                                class='hover:text-primary-600'>Reply
                        </button> &#9900;
                        <span x-text='moment(comment.created_at).fromNow()'>0s</span> &#9900;
                        <span>0 likes</span>
                    </div>
                    {{-- Replies --}}
                    <template x-if='showReplies && comment.replies && comment.replies.length'>
                        <div>
                            <template x-for='(reply, index) in comment.replies'>
                                <div class='flex gap-3 py-4'>
                                    <img class='w-10 h-10 border rounded-full bg-primary-100'
                                         :src='reply.user.image_url'>
                                    <div class='flex-1'>
                                        <p class='leading-tight'>
                                            <a href='#'>
                                                <span class='font-bold' x-text='reply.user.name'></span>
                                            </a>
                                            <span x-text='reply.text'></span>
                                        </p>
                                        <div class='flex gap-1.5 text-xs opacity-70'>
                                            <button>Like</button> &#9900;
                                            <span x-text='moment(reply.created_at).fromNow()'>0s</span> &#9900;
                                            <span>0 likes</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    {{-- Reply Form--}}
                    <div x-show='showForm' x-collapse class='mt-1'>
                        <input x-on:keydown.enter='postComment($el, comment.id)'
                               type='text'
                               name='reply'
                               placeholder='Writer a reply....'
                               class='rounded-md shadow-sm border-gray-300 focus:border-primary-300 focus:ring-0'>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>