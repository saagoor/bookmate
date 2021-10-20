@props(['title', 'url'])

@php
    $twitterURL = 'https://twitter.com/intent/tweet?text=' . $title . '&amp;url=' . $url . '&amp;via=bookmate';
    $facebookURL = 'https://www.facebook.com/share.php?u=' . $url . '&amp;t=' . $title;
    $whatsappURL = 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url;
    $fbMessengerURL = 'fb-messenger://share?link=' . $url;
@endphp

<div x-data="{
    openShareDialog(){
        navigator.share({
            title: document.title,
            text: '{{ $title }}',
            url: '{{ $url }}',
        })
    }
}">
    <div class="grid grid-cols-2 gap-2">
        <x-link-button
                color="light"
                :href="$facebookURL"
                target="_blank">
            <x-bi-facebook class="h-8 w-8"/>
        </x-link-button>
        <x-link-button
                color="light"
                @click.prevent="openShareDialog()" :href="$twitterURL"
                target="_blank">
            <x-bi-instagram class="h-8 w-8"/>
        </x-link-button>
        <x-link-button
                color="light"
                :href="$whatsappURL"
                target="_blank">
            <x-bi-whatsapp class="h-8 w-8"/>
        </x-link-button>

        <x-link-button
                color="light"
                :href="$fbMessengerURL"
                target="_blank">
            <x-bi-messenger class="h-8 w-8"/>
        </x-link-button>
    </div>
</div>