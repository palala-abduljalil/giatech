<a href="{{ route('user-profile') }}">
    <user-panel :data="{{ json_encode($auth) }}"/>
</a>