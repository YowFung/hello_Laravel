<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->gravatar($size) }}" alt="{{ $user->name }}" class="gravatar"/>
</a>