@props(['user'])
<x-list-tile :image="$user->image_url"
    :title="$user->name"
    :subtitle="$user->email"
    :attributes="$attributes" />
