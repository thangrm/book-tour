<form action="{{ route('admin.logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
<?php
