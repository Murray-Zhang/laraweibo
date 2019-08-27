<a href="#">
    <strong id="following" class="stat">
{{--        {{ count($user->followings) }}--}}
        {{ $user->followings_count }}
    </strong>
    关注
</a>
<a href="#">
    <strong id="followers" class="stat">
{{--        {{ count($user->followers) }}--}}
        {{ $user->followers_count }}
    </strong>

    粉丝
</a>
<a href="#">
    <strong id="statuses" class="stat">
{{--        {{ $user->statuses()->count() }}--}}
        {{ $user->statuses_count }}
    </strong>
    微博
</a>