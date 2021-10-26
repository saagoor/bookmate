@props(['model', 'canReview' => auth()->check()])

@php
    $model->loadCount('reviews')
          ->loadAvg('reviews', 'rating')
          ->load('reviews.user');
@endphp

<div class="flex flex-col md:flex-row gap-6">
    <div class="md:w-1/3 md:max-w-sm">
        @if($canReview)
            @php
                $user_review = $model->reviews->firstWhere('user_id', auth()->user()->id) ?? new \App\Models\Review();
            @endphp
            <div class="bg-white rounded-xl shadow-xl p-6 mb-6">
                <form action="{{ route('reviews.store', ['reviewable_id' => $model->id, 'reviewable_type' => get_class($model)]) }}" method="POST">
                    @csrf
                    <div class="flex gap-4">
                        <x-img class="w-12 h-12 border rounded-full bg-primary-100"
                               :src="auth()->user()->image_url"/>
                        <div class="flex-1" x-data="{rating: {{ old('rating', $user_review->rating ?? '0') }}}">
                            <x-input-textarea
                                    class="mb-2"
                                    name="text"
                                    placeholder="Writer an informative review.....">{{ old('text', $user_review->text) }}</x-input-textarea>
                            <div class="mb-3">
                                @foreach (range(1, 5) as $item)
                                    <button type="button" x-on:click.prevent="rating = {{ $item }}">
                                        <x-heroicon-o-star x-show="rating < {{ $item }}"/>
                                        <x-heroicon-s-star x-cloak x-show="rating >= {{ $item }}"/>
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="rating" x-model="rating">
                            <x-button class="font-heading text-base">Post Your Review</x-button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-xl p-6 text-center">
            <h2 class="text-lg font-semibold mb-3">User Reviews</h2>
            <div class="inline-flex items-center justify-center gap-2 bg-gray-200 rounded-full py-3 px-4">
                <x-ratings class="text-primary-500" :rating="$model->reviews_avg_rating"/>
                <p>{{ round($model->reviews_avg_rating, 1) }} out of 5</p>
            </div>
            <p class="text-center text-sm mt-4 mb-8">{{ $model->reviews_count }} readers review</p>
            @foreach (range(5, 1) as $item)
                @php
                    $percentage = $model->reviews_count > 0 ? round(($model->reviews->where('rating', $item)->count() * 100) / $model->reviews_count) : 0;
                @endphp
                <div class="flex items-center justify-between gap-2 mt-4">
                    <span class="text-sm">{{ $item }} star</span>
                    <div class="flex-1 bg-gray-200 rounded-lg">
                        <div class="bg-primary-500 py-2 rounded-lg" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm w-8">{{ $percentage }}%</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex-1 divide-y bg-white rounded-xl shadow-xl">
        @forelse ($model->reviews as $review)
            <div class="p-6">
                <div class="flex gap-4 items-center flex-wrap mb-3">
                    <x-img class="h-12 w-12 rounded-full bg-primary-300" :src="$review->user->image_url"/>
                    <div class="leading-tight flex-1">
                        <p class="font-semibold">{{ $review->user->name }}</p>
                        <div class="inline-flex gap-4 items-center font-bold">
                            <x-ratings class="text-primary-500 text-sm" :rating="$review->rating"/>
                            <?php printf("%.1f", $review->rating) ?>
                        </div>
                    </div>
                    <p class="w-full md:w-auto text-sm md:text-base md:text-right">{{ $review->updated_at->diffForHumans() }}</p>
                </div>
                <div>
                    {{ $review->text }}
                </div>
            </div>
        @empty
            <p class="p-4 text-center">No review found.</p>
        @endforelse
    </div>
</div>