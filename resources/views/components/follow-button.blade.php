@props(['user'])

@php
    $authUser = auth()->user();
    $isFollowing = $authUser && $user->isFollowedBy($authUser);
@endphp

@if ($authUser && $authUser->id !== $user->id)
    <a href="#" class="follow-btn font-bold {{ $isFollowing ? 'text-red-600' : 'text-emerald-600' }}"
        data-user-id="{{ $user->id }}">
        {{ $isFollowing ? 'Unfollow' : 'Follow' }}
    </a>
@endif
