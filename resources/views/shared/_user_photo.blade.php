<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->avatar() }}" alt="{{ $user->name }}" class="gravatar"/>
</a>