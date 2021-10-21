<x-app-layout :title="$book->name">

    <div class="container py-8">

        <div class="bg-white shadow-xl rounded-xl overflow-hidden flex flex-col md:flex-row mb-6">
            <div class="md:w-1/5">
                <x-img class="w-full" :src="$book->cover_url"/>
            </div>
            <div class="flex-1 p-4 md:p-6">
                <h1 class="text-2xl font-semibold mb-5">{{ $book->name }}</h1>
                <table>
                    <tr>
                        <td>Writer</td>
                        <td class="w-3">:</td>
                        <td>
                            @foreach ($book->writers as $writer)
                                @if (!$loop->first)
                                    <span> & </span>
                                @endif
                                <a href="{{ route('writers.show', $writer) }}">{{ $writer->name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @if ($book->translators->count())
                        <tr>
                            <td>Translator</td>
                            <td>:</td>
                            <td>
                                @foreach ($book->translators as $translator)
                                    @if (!$loop->first)
                                        <span> & </span>
                                    @endif
                                    <a href="{{ route('writers.show', $translator) }}">{{ $translator->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>ISBN</td>
                        <td>:</td>
                        <td>{{ $book->isbn }}</td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td>:</td>
                        <td>{{ $book->language }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>:</td>
                        <td>{{ $book->category }}</td>
                    </tr>
                    <tr>
                        <td>Page Count</td>
                        <td>:</td>
                        <td>{{ $book->page_count }}</td>
                    </tr>
                    <tr>
                        <td>Published At</td>
                        <td>:</td>
                        <td>{{ $book->published_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td>Publisher</td>
                        <td>:</td>
                        <td>{{ $book->publisher->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="flex-1 md:self-center p-4 md:p-6">
                <p class="mb-2 font-semibold">Monthly Statistics</p>
                <div class="grid grid-cols-2 divide-x divide-y border rounded-md border-collapse">
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Views</p>
                        <p class="text-2xl font-semibold">{{ $book->months_views_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Reads</p>
                        <p class="text-2xl font-semibold">{{ $book->months_reads_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Exchanges</p>
                        <p class="text-2xl font-semibold">{{ $book->months_exchanges_count }}</p>
                    </div>
                    <div class="p-4 border-collapse">
                        <p class="font-semibold">Challenges</p>
                        <p class="text-2xl font-semibold">{{ $book->months_challenges_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/3 md:max-w-sm">
                @auth
                    @php
                        $user_review = $book->reviews->firstWhere('user_id', auth()->user()->id) ?? new \App\Models\Review();
                    @endphp
                    <div class="bg-white rounded-xl shadow-xl p-6 mb-6">
                        <form action="{{ route('books.reviews.store', $book) }}" method="POST">
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
                @endauth

                <div class="bg-white rounded-xl shadow-xl p-6 text-center">
                    <h2 class="text-lg font-semibold mb-3">Readers Reviews</h2>
                    <div class="inline-flex items-center justify-center gap-2 bg-gray-200 rounded-full py-3 px-4">
                        <x-ratings class="text-primary-500" :rating="$book->reviews_avg_rating"/>
                        <p>{{ round($book->reviews_avg_rating, 1) }} out of 5</p>
                    </div>
                    <p class="text-center text-sm mt-4 mb-8">{{ $book->reviews_count }} readers review</p>
                    @foreach (range(5, 1) as $item)
                        @php
                            $percentage = $book->reviews_count > 0 ? round(($book->reviews->where('rating', $item)->count() * 100) / $book->reviews_count) : 0;
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
                @forelse ($book->reviews as $review)
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
                    <p>No reviews.</p>
                @endforelse
            </div>
        </div>

    </div>

</x-app-layout>